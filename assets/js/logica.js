// --- Constantes y Variables Globales ---

// --- CONSTANTES DE CÁLCULO --- ⚙️
const TARIFA_MINIMA_VIAJE_CORTO = 10000;
const FACTOR_CALCULO_KM = 2.2;
const PRECIO_BASE_KM = 1300;
const DESCUENTO_LARGA_DISTANCIA = 0.10; // 10%

const COSTO_AYUDA = 5000;
const COSTO_EXTRA_ASCENSOR_POR_CARGA = 500;
const COSTO_EXTRA_ESCALERAS_POR_CARGA = 2000;
const COSTO_POR_CARGA_ADICIONAL = 1000; // <-- NUEVO: Costo de $1000 por cada carga

let mapModal, mapRoute, temporaryMarker, currentPointType;
let routingControl = null;

const confirmedPoints = {
    A: { lat: null, lng: null, address: null, marker: null },
    B: { lat: null, lng: null, address: null, marker: null }
};

let temporarySelection = { lat: null, lng: null, address: null };

// --- Referencias a Elementos del DOM ---
const mapModalElement = document.getElementById('mapModal');
const calculateButton = document.getElementById('calculate-cost-btn');
const resultsSection = document.getElementById('results-section');
const routeMapContainer = document.getElementById('route-map'); 
const distanceOutput = document.getElementById('distance-output');
const costOutput = document.getElementById('cost-output');
const errorMessageDiv = document.querySelector('.error-message');
const loadingDiv = document.querySelector('.loading');
const actionButtonsContainer = document.getElementById('action-buttons-container');
const addressAInput = document.getElementById('addressA-input');
const addressBInput = document.getElementById('addressB-input');
const geocodeAButton = document.getElementById('geocode-A-btn');
const geocodeBButton = document.getElementById('geocode-B-btn');
const quotationFormContainer = document.getElementById('quotation-form-container');

// --- Funciones Principales ---

function initializeMapModal() {
    const tucumanCoordinates = [-26.83, -65.22];
    mapModal = L.map('map-modal-container').setView(tucumanCoordinates, 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapModal);

    mapModal.on('click', handleMapModalClick);
}

function handleMapModalClick(event) {
    const clickedLatLng = event.latlng;
    temporarySelection.lat = clickedLatLng.lat;
    temporarySelection.lng = clickedLatLng.lng;

    if (!temporaryMarker) {
        temporaryMarker = L.marker(clickedLatLng, { draggable: true }).addTo(mapModal);
    } else {
        temporaryMarker.setLatLng(clickedLatLng);
    }
    
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

function confirmPointSelection() {
    if (temporarySelection.lat && temporarySelection.lng) {
        confirmedPoints[currentPointType] = { ...temporarySelection };

        document.getElementById(`address${currentPointType}-input`).value = confirmedPoints[currentPointType].address;
        document.getElementById(`lat${currentPointType}`).value = confirmedPoints[currentPointType].lat;
        document.getElementById(`lng${currentPointType}`).value = confirmedPoints[currentPointType].lng;
        document.getElementById(`display-address${currentPointType}`).value = confirmedPoints[currentPointType].address;
    }
}

async function geocodeAddress(address) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&countrycodes=ar`);
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
    } else {
        showError(`No se pudo encontrar la dirección para el Punto ${pointType}.`);
    }
}

function initializeRouteMap() {
    if (!mapRoute) {
        mapRoute = L.map(routeMapContainer.id).setView([-26.83, -65.22], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapRoute);
    }
}

function showError(message) {
    errorMessageDiv.innerText = message;
    errorMessageDiv.style.display = 'block';
}

function hideMessages() {
    errorMessageDiv.style.display = 'none';
    loadingDiv.style.display = 'none';
}

function validateForm() {
    const latA = document.getElementById('latA').value;
    const latB = document.getElementById('latB').value;
    const nombre = document.getElementById('nombrePersona').value;
    const cargas = document.getElementById('cantidadCargas').value;

    if (!nombre.trim()) {
        showError('Por favor, ingresa tu nombre completo.');
        return false;
    }
    if (!latA || !latB) {
        showError('Debes seleccionar un punto de origen y uno de destino.');
        return false;
    }
    if (!cargas || parseInt(cargas) < 1) {
        showError('La cantidad de cargas debe ser al menos 1.');
        return false;
    }
    return true;
}

/**
 * NUEVO: Función para reiniciar la cotización y volver al formulario.
 */
function resetQuote() {
    resultsSection.style.display = 'none';
    quotationFormContainer.style.display = 'block';
    if (routingControl && mapRoute) {
        mapRoute.removeControl(routingControl);
        routingControl = null;
    }
}

// --- Event Listeners ---

document.addEventListener('DOMContentLoaded', function() {
    
    initializeRouteMap();

    mapModalElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        currentPointType = button.getAttribute('data-point-type');
        
        document.getElementById('mapModalLabel').innerText = `Seleccionar Punto ${currentPointType}`;
        temporarySelection = { lat: null, lng: null, address: null };

        if (!mapModal) {
            initializeMapModal();
        }
        mapModal.setView([-26.83, -65.22], 13);
        if (temporaryMarker) {
            temporaryMarker.remove();
            temporaryMarker = null;
        }
    });

    mapModalElement.addEventListener('shown.bs.modal', function() {
        if (mapModal) {
            mapModal.invalidateSize();
        }
    });

    document.getElementById('confirm-selection-btn').addEventListener('click', confirmPointSelection);
    geocodeAButton.addEventListener('click', () => handleGeocodeButtonClick('A'));
    geocodeBButton.addEventListener('click', () => handleGeocodeButtonClick('B'));

    calculateButton.addEventListener('click', function() {
        hideMessages();
        
        if (!validateForm()) return;

        loadingDiv.innerText = 'Calculando ruta...';
        loadingDiv.style.display = 'block';

        if (routingControl && mapRoute) {
            mapRoute.removeControl(routingControl);
            routingControl = null;
        }

        routingControl = L.Routing.control({
            waypoints: [
                L.latLng(confirmedPoints.A.lat, confirmedPoints.A.lng),
                L.latLng(confirmedPoints.B.lat, confirmedPoints.B.lng)
            ],
            router: L.Routing.osrmv1({ serviceUrl: `https://router.project-osrm.org/route/v1` }),
            routeWhileDragging: false,
            addWaypoints: false,
            show: false,
            createMarker: function(i, waypoint, n) {
                const markerLabel = i === 0 ? 'Punto A (Origen)' : 'Punto B (Destino)';
                return L.marker(waypoint.latLng, {
                    draggable: false,
                    icon: L.icon({
                        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                        shadowSize: [41, 41]
                    })
                }).bindPopup(`<b>${markerLabel}</b>`);
            }
        }).addTo(mapRoute);

        routingControl.on('routesfound', function(e) {
            loadingDiv.style.display = 'none';
            const summary = e.routes[0].summary;
            const distanceKm = summary.totalDistance / 1000;
            
            // Mostrar resultados y mapa
            quotationFormContainer.style.display = 'none';
            resultsSection.style.display = 'block';
            mapRoute.fitBounds(e.routes[0].coordinates);
            mapRoute.invalidateSize();
            
            setTimeout(() => {
                resultsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
            
            
            // --- NUEVA LÓGICA: bifurcación para viajes largos ---
            if (distanceKm > 15) {
                // Caso 1: Viaje especial de más de 15 km
                distanceOutput.innerText = `${distanceKm.toFixed(2)} km`;
                costOutput.innerHTML = `<p class="lead text-center fw-bold text-warning">Viaje especial con más de 15 kilómetros, ¡escribinos!</p>`;
                
                const specialMessage = "Hola, quisiera cotizar un viaje especial.";
                const whatsappUrl = `https://api.whatsapp.com/send?phone=5493815827335&text=${encodeURIComponent(specialMessage)}`;

                actionButtonsContainer.innerHTML = `
                    <a href="${whatsappUrl}" target="_blank" class="btn btn-success btn-lg mb-2 w-100">Contactar por Viaje Especial</a>
                    <button type="button" id="reset-trip-btn" class="btn btn-secondary btn-lg w-100">Reiniciar Viaje</button>
                `;
                document.getElementById('reset-trip-btn').addEventListener('click', resetQuote);

            } else {
                // Caso 2: Viaje normal (menos de 15 km)
                let costoViaje = 0;
                if (distanceKm < 2) {
                    costoViaje = TARIFA_MINIMA_VIAJE_CORTO;
                } else if (distanceKm <= 8) {
                    costoViaje = distanceKm * FACTOR_CALCULO_KM * PRECIO_BASE_KM;
                } else {
                    let costoSinDescuento = distanceKm * FACTOR_CALCULO_KM * PRECIO_BASE_KM;
                    costoViaje = costoSinDescuento * (1 - DESCUENTO_LARGA_DISTANCIA);
                }

                let costosAdicionales = 0;
                const cantidadCargas = parseInt(document.getElementById('cantidadCargas').value) || 1;
                
                // NUEVO: Se suma el costo por cada carga
                costosAdicionales += cantidadCargas * COSTO_POR_CARGA_ADICIONAL;

                if (document.getElementById('ayudaCargarSi').checked) costosAdicionales += COSTO_AYUDA;
                if (document.getElementById('ayudaDescargarSi').checked) costosAdicionales += COSTO_AYUDA;
                if (document.getElementById('ascensorSi').checked) costosAdicionales += (cantidadCargas * COSTO_EXTRA_ASCENSOR_POR_CARGA);
                if (document.getElementById('escalerasSi').checked) costosAdicionales += (cantidadCargas * COSTO_EXTRA_ESCALERAS_POR_CARGA);

                const totalCost = costoViaje + costosAdicionales;

                const formatter = new Intl.NumberFormat('es-AR', { style: 'currency', currency: 'ARS' });
                distanceOutput.innerText = `${distanceKm.toFixed(2)} km`;
                costOutput.innerText = formatter.format(totalCost);
                
                actionButtonsContainer.innerHTML = `
                    <button type="button" id="confirm-trip-btn" class="btn btn-primary btn-lg me-2">Solicitar Servicio</button>
                    <button type="button" id="reset-trip-btn" class="btn btn-secondary btn-lg">Reiniciar Viaje</button>
                `;
                
                document.getElementById('reset-trip-btn').addEventListener('click', resetQuote);
                document.getElementById('confirm-trip-btn').addEventListener('click', handleConfirmTrip);
            }
        });

        routingControl.on('routingerror', function(e) {
            loadingDiv.style.display = 'none';
            showError('No se pudo encontrar una ruta. Intenta con otras ubicaciones.');
            console.error("Error de enrutamiento:", e);
        });
    });
});

/**
 * Prepara el mensaje detallado de WhatsApp y abre la aplicación.
 */
/**
 * MODIFICADO: Prepara el mensaje de WhatsApp, guarda los datos en el servidor y abre la aplicación.
 */
async function handleConfirmTrip() {
    // Recolectar todos los datos necesarios para la cotización y el mensaje de WhatsApp
    const quoteDetails = {
        nombre: document.getElementById('nombrePersona').value,
        // Usar los valores de los inputs directamente o los confirmados si existen
        origen: document.getElementById('addressA-input').value || confirmedPoints.A.address,
        destino: document.getElementById('addressB-input').value || confirmedPoints.B.address,
        distancia: document.getElementById('distance-output').textContent,
        costo: document.getElementById('cost-output').textContent,
        cantidadCargas: document.getElementById('cantidadCargas').value,
        ayudaCargar: document.getElementById('ayudaCargarSi').checked ? 'Sí' : 'No',
        ayudaDescargar: document.getElementById('ayudaDescargarSi').checked ? 'Sí' : 'No',
        ascensor: document.getElementById('ascensorSi').checked ? 'Sí' : 'No',
        escaleras: document.getElementById('escalerasSi').checked ? 'Sí' : 'No',
        fecha: document.getElementById('programarFecha').checked ? `${document.getElementById('fecha').value} a las ${document.getElementById('hora').value}` : 'Ahora mismo',
        descripcion: document.getElementById('descripcionAdicional').value || 'Sin descripción.'
    };

    // --- LÓGICA DE GUARDADO EN EL SERVIDOR ---
    const datosParaGuardar = new FormData();
    datosParaGuardar.append('nombre', quoteDetails.nombre);
    datosParaGuardar.append('origen', quoteDetails.origen);
    datosParaGuardar.append('destino', quoteDetails.destino);
    datosParaGuardar.append('distancia', quoteDetails.distancia);
    datosParaGuardar.append('costo', quoteDetails.costo);
    // Asegúrate que el campo 'fecha' coincida con lo que tu PHP espera
    datosParaGuardar.append('fecha', quoteDetails.fecha);
    datosParaGuardar.append('timestamp', new Date().toISOString()); // Fecha y hora exacta de la solicitud
    datosParaGuardar.append('descripcion_adicional', quoteDetails.descripcion); // Campo para la descripción adicional

    try {
        // La ruta corregida para tu estructura de carpetas: index.php (raíz) -> assets/php/guardar_viaje.php
        const response = await fetch('assets/php/guardar_viaje.php', {
            method: 'POST',
            body: datosParaGuardar
        });
        const result = await response.json(); // Espera la respuesta JSON de PHP

        if (result.status === 'success') {
            console.log('Viaje guardado en el servidor exitosamente:', result.message);
        } else {
            // Esto mostrará cualquier error que PHP haya retornado
            console.error('Error del servidor al guardar el viaje:', result.message);
        }
    } catch (error) {
        // Esto captura errores de red o del lado del cliente antes de recibir respuesta de PHP
        console.error('Error de conexión o al procesar la respuesta al intentar guardar el viaje:', error);
    }
    // --- FIN DE LA LÓGICA DE GUARDADO ---

    // 3. Construir el mensaje de WhatsApp (tu código original)
    const message = `
¡Hola Fletes-Ya! Quisiera solicitar el siguiente servicio:
--------------------------------------
*Nombre:* ${quoteDetails.nombre}
*Origen:* ${quoteDetails.origen}
*Destino:* ${quoteDetails.destino}
*Distancia:* ${quoteDetails.distancia}
*Costo Estimado:* ${quoteDetails.costo}
--------------------------------------
*Detalles Adicionales:*
- Cargas: ${quoteDetails.cantidadCargas}
- Ayuda Carga: ${quoteDetails.ayudaCargar}
- Ayuda Descarga: ${quoteDetails.ayudaDescargar}
- Ascensor: ${quoteDetails.ascensor}
- Escaleras: ${quoteDetails.escaleras}
- Cuándo: ${quoteDetails.fecha}
- Descripción: ${quoteDetails.descripcion}
--------------------------------------
Por favor, contáctenme para coordinar. ¡Gracias!
    `.trim().replace(/^\s+/gm, ''); // Elimina espacios iniciales y finales de cada línea

    // 4. Abrir WhatsApp
    const numeroWhatsApp = '5493815827335'; // Asegúrate de que este número sea correcto y completo con código de país
    const whatsappUrl = `https://api.whatsapp.com/send?phone=${numeroWhatsApp}&text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank'); // Abre en una nueva pestaña
}