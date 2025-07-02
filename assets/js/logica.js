// --- Constantes y Variables Globales ---
const COSTO_POR_KM = 1000; // Define el costo por kilómetro en pesos argentinos

let mapModal; // Mapa para la selección de puntos en el modal
let mapRoute; // Mapa para mostrar la ruta calculada
let temporaryMarker; // Marcador temporal en el modal para el punto A o B
let currentPointType; // Almacena si estamos seleccionando el punto 'A' o 'B'
let routingControl = null; // Control de ruta de Leaflet Routing Machine

// Objeto para almacenar las coordenadas y direcciones confirmadas de los puntos A y B
const confirmedPoints = {
    A: { lat: null, lng: null, address: null, marker: null },
    B: { lat: null, lng: null, address: null, marker: null }
};

// Objeto para almacenar la selección temporal dentro del modal
let temporarySelection = { lat: null, lng: null, address: null };

// --- Referencias a Elementos del DOM ---
const mapModalElement = document.getElementById('mapModal');
const calculateButton = document.getElementById('calculate-distance-btn');
const resultsSection = document.getElementById('results-section');
const routeMapContainer = document.getElementById('route-map-container');
const distanceOutput = document.getElementById('distance-output');
const costOutput = document.getElementById('cost-output');
const errorMessageDiv = document.querySelector('.error-message');
const loadingDiv = document.querySelector('.loading');
const resetButton = document.getElementById('reset-button'); // Nuevo botón de reiniciar

// Botones y campos de entrada para geocodificación
const addressAInput = document.getElementById('addressA-input');
const addressBInput = document.getElementById('addressB-input');
const geocodeAButton = document.getElementById('geocode-A-btn');
const geocodeBButton = document.getElementById('geocode-B-btn');

// --- Funciones Principales ---

/**
 * Inicializa el mapa dentro del modal la primera vez que se abre.
 * Se centra en San Miguel de Tucumán.
 */
function initializeMapModal() {
    const tucumanCoordinates = [-26.83, -65.22]; // Coordenadas de San Miguel de Tucumán
    mapModal = L.map('map-modal-container').setView(tucumanCoordinates, 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapModal);

    // Añadir el listener para clics en el mapa
    mapModal.on('click', handleMapModalClick);
}

/**
 * Maneja el clic en el mapa del modal para seleccionar un punto.
 * Añade o mueve un marcador temporal y obtiene la dirección inversa.
 * @param {Object} event - Objeto de evento de Leaflet.
 */
function handleMapModalClick(event) {
    const clickedLatLng = event.latlng;
    temporarySelection.lat = clickedLatLng.lat;
    temporarySelection.lng = clickedLatLng.lng;

    // Si no hay marcador, lo crea. Si ya existe, lo mueve.
    if (!temporaryMarker) {
        temporaryMarker = L.marker(clickedLatLng, { draggable: true }).addTo(mapModal);
    } else {
        temporaryMarker.setLatLng(clickedLatLng);
    }
    
    // Obtenemos la dirección usando la API de Nominatim (geocodificación inversa)
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${clickedLatLng.lat}&lon=${clickedLatLng.lng}`)
        .then(response => response.json())
        .then(data => {
            temporarySelection.address = data.display_name || 'Ubicación seleccionada';
        })
        .catch(error => {
            console.error("Error al obtener la dirección:", error);
            temporarySelection.address = `Lat: ${clickedLatLng.lat.toFixed(4)}, Lng: ${clickedLatLng.lng.toFixed(4)}`;
        });
}

/**
 * Confirma la selección del punto (A o B) del modal y actualiza la UI.
 */
function confirmPointSelection() {
    if (temporarySelection.lat && temporarySelection.lng) {
        // Copia la selección temporal al punto confirmado (A o B)
        confirmedPoints[currentPointType] = { ...temporarySelection };

        // Actualiza el campo de entrada de texto con la dirección para el usuario
        document.getElementById(`address${currentPointType}-input`).value = confirmedPoints[currentPointType].address;
        // Almacena las coordenadas en los hidden inputs
        document.getElementById(`lat${currentPointType}`).value = confirmedPoints[currentPointType].lat;
        document.getElementById(`lng${currentPointType}`).value = confirmedPoints[currentPointType].lng;
        // También guarda la dirección para referencia interna si es necesario
        document.getElementById(`display-address${currentPointType}`).value = confirmedPoints[currentPointType].address;
    }
}

/**
 * Realiza la geocodificación de una dirección.
 * @param {string} address - La dirección a buscar.
 * @returns {Promise<Object|null>} - Una promesa que resuelve con un objeto {lat, lng, address} o null si falla.
 */
async function geocodeAddress(address) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`);
        const data = await response.json();
        if (data && data.length > 0) {
            const firstResult = data[0];
            return {
                lat: parseFloat(firstResult.lat),
                lng: parseFloat(firstResult.lon),
                address: firstResult.display_name
            };
        }
    } catch (error) {
        console.error("Error al geocodificar la dirección:", error);
    }
    return null;
}

/**
 * Maneja el evento de click del botón de geocodificación.
 * @param {string} pointType - 'A' o 'B' para indicar qué punto se está geocodificando.
 */
async function handleGeocodeButtonClick(pointType) {
    const inputElement = document.getElementById(`address${pointType}-input`);
    const address = inputElement.value.trim();

    if (!address) {
        showError('Por favor, ingresa una dirección para buscar.');
        return;
    }

    loadingDiv.innerText = `Buscando ${pointType}...`;
    loadingDiv.style.display = 'block';
    hideMessages();

    const result = await geocodeAddress(address);

    loadingDiv.style.display = 'none';

    if (result) {
        confirmedPoints[pointType] = result;
        document.getElementById(`lat${pointType}`).value = result.lat;
        document.getElementById(`lng${pointType}`).value = result.lng;
        document.getElementById(`display-address${pointType}`).value = result.address;
        console.log(`Punto ${pointType} geocodificado:`, result);
    } else {
        showError(`No se pudo encontrar la dirección para el Punto ${pointType}. Intenta ser más específico.`);
    }
}

/**
 * Inicializa el mapa para mostrar la ruta calculada.
 * Se crea la primera vez que se calcula una ruta.
 */
function initializeRouteMap() {
    mapRoute = L.map('route-map').setView([-26.83, -65.22], 13); // Centra en Tucumán
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapRoute);
}

/**
 * Muestra un mensaje de error.
 * @param {string} message - El mensaje de error a mostrar.
 */
function showError(message) {
    errorMessageDiv.innerText = message;
    errorMessageDiv.style.display = 'block';
}

/**
 * Oculta todos los mensajes (loading y error).
 */
function hideMessages() {
    errorMessageDiv.style.display = 'none';
    loadingDiv.style.display = 'none';
}

/**
 * Reinicia la cotización, limpiando los campos y ocultando los resultados.
 */
function resetCalculation() {
    // Limpiar campos de entrada
    addressAInput.value = '';
    addressBInput.value = '';

    // Resetear puntos confirmados
    confirmedPoints.A = { lat: null, lng: null, address: null, marker: null };
    confirmedPoints.B = { lat: null, lng: null, address: null, marker: null };

    // Limpiar hidden inputs
    document.getElementById('latA').value = '';
    document.getElementById('lngA').value = '';
    document.getElementById('display-addressA').value = '';
    document.getElementById('latB').value = '';
    document.getElementById('lngB').value = '';
    document.getElementById('display-addressB').value = '';

    // Ocultar resultados y mapa de ruta
    resultsSection.style.display = 'none';
    routeMapContainer.style.display = 'none';
    hideMessages();

    // Eliminar la ruta del mapa de resultados si existe
    if (routingControl) {
        if (mapRoute) { // Asegurarse de que mapRoute existe antes de remover el control
            mapRoute.removeControl(routingControl);
        }
        routingControl = null;
    }

    // Eliminar marcadores del mapa de ruta si existen
    if (mapRoute) {
        if (confirmedPoints.A.marker) {
            mapRoute.removeLayer(confirmedPoints.A.marker);
            confirmedPoints.A.marker = null;
        }
        if (confirmedPoints.B.marker) {
            mapRoute.removeLayer(confirmedPoints.B.marker);
            confirmedPoints.B.marker = null;
        }
    }

    // Centrar el mapa de ruta si ya está inicializado
    if (mapRoute) {
        mapRoute.setView([-26.83, -65.22], 13); // Centra en Tucumán
    }
}

// --- Event Listeners ---

// Se ejecuta CADA VEZ que el modal del mapa está a punto de mostrarse
// --- Evento 'show.bs.modal': Se dispara JUSTO ANTES de que el modal empiece a mostrarse. ---
mapModalElement.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    currentPointType = button.getAttribute('data-point-type');
    
    document.getElementById('mapModalLabel').innerText = `Seleccionar Punto ${currentPointType}`;
    temporarySelection = { lat: null, lng: null, address: null };

    // Si el mapa aún no ha sido inicializado, lo hacemos aquí.
    if (!mapModal) {
        initializeMapModal();
    }
    // Centramos el mapa y limpiamos marcadores temporales cada vez que se abre.
    mapModal.setView([-26.83, -65.22], 13);
    if (temporaryMarker) {
        temporaryMarker.remove();
        temporaryMarker = null;
    }
});

// --- Evento 'shown.bs.modal': Se dispara DESPUÉS de que el modal ha sido COMPLETAMENTE mostrado. ---
// ESTE ES EL EVENTO CLAVE para llamar a invalidateSize()
mapModalElement.addEventListener('shown.bs.modal', function() {
    // Aseguramos que el mapa se redimensione correctamente DESPUÉS de que el modal está completamente visible.
    if (mapModal) { // Verificamos que el mapa exista antes de intentar invalidar el tamaño
        mapModal.invalidateSize();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    initializeRouteMap();
});

// Listener para el botón de confirmar selección dentro del modal
document.getElementById('confirm-selection-btn').addEventListener('click', confirmPointSelection);

// Listeners para los botones de geocodificación
geocodeAButton.addEventListener('click', () => handleGeocodeButtonClick('A'));
geocodeBButton.addEventListener('click', () => handleGeocodeButtonClick('B'));

// Listener para el nuevo botón de "Reiniciar Cotización"
resetButton.addEventListener('click', resetCalculation);

// Listener para el botón principal de "Calcular Distancia y Costo"
calculateButton.addEventListener('click', function() {
    hideMessages();
    resultsSection.style.display = 'none';
    routeMapContainer.style.display = 'none';
    
    if (!confirmedPoints.A.lat || !confirmedPoints.B.lat) {
        showError('Error: Debes seleccionar ambos puntos (A y B) usando el mapa o ingresando direcciones.');
        return;
    }

    loadingDiv.innerText = 'Calculando ruta...';
    loadingDiv.style.display = 'block';

    // Si ya existe una ruta calculada en el mapa de resultados, la eliminamos antes de calcular la nueva
    if (routingControl) {
        mapRoute.removeControl(routingControl);
        routingControl = null;
    }
    // Si el mapa de ruta no existe, lo inicializa
    if (!mapRoute) {
        initializeRouteMap();
    } else {
        // Eliminar marcadores anteriores del mapa de ruta
        if (confirmedPoints.A.marker) {
            mapRoute.removeLayer(confirmedPoints.A.marker);
            confirmedPoints.A.marker = null;
        }
        if (confirmedPoints.B.marker) {
            mapRoute.removeLayer(confirmedPoints.B.marker);
            confirmedPoints.B.marker = null;
        }
    }
    
    routingControl = L.Routing.control({
        waypoints: [
            L.latLng(confirmedPoints.A.lat, confirmedPoints.A.lng),
            L.latLng(confirmedPoints.B.lat, confirmedPoints.B.lng)
        ],
        router: L.Routing.osrmv1({
            serviceUrl: `https://router.project-osrm.org/route/v1`
        }),
        routeWhileDragging: false,
        addWaypoints: false,
        show: false,
        createMarker: function(i, waypoint, n) {
            let marker = L.marker(waypoint.latLng, {
                draggable: false,
                icon: L.icon({
                    iconUrl: i === 0 ? 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png' : 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                    shadowSize: [41, 41]
                })
            });
            if (i === 0) confirmedPoints.A.marker = marker;
            else confirmedPoints.B.marker = marker;
            return marker;
        }
    }).addTo(mapRoute);

    routingControl.on('routesfound', function(e) {
        loadingDiv.style.display = 'none';
        const routes = e.routes;
        const summary = routes[0].summary;

        const distanceKm = summary.totalDistance / 1000;
        const totalCost = distanceKm * COSTO_POR_KM;

        const formatter = new Intl.NumberFormat('es-AR', {
            style: 'currency',
            currency: 'ARS',
            minimumFractionDigits: 2,
        });

        distanceOutput.innerText = `${distanceKm.toFixed(2)} km`;
        costOutput.innerText = formatter.format(totalCost);
        
        resultsSection.style.display = 'block';
        routeMapContainer.style.display = 'block';

        mapRoute.fitBounds(routingControl.getPlan().getWaypoints().map(wp => wp.latLng));
        mapRoute.invalidateSize();
    });

    routingControl.on('routingerror', function(e) {
        loadingDiv.style.display = 'none';
        showError('No se pudo encontrar una ruta por carretera entre los puntos seleccionados. Intenta con ubicaciones más cercanas o diferentes.');
        console.error("Error de enrutamiento:", e);
    });
});