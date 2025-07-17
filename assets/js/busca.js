let mapModal;
    let markerModal;
    let selectedLat = null;
    let selectedLng = null;

    // Function to initialize the map inside the modal
    // This needs to be called when the modal is shown to ensure the map container is visible
    function initializeMapModal() {
        if (!mapModal) { // Initialize only once
            mapModal = L.map('map-modal-container').setView([-26.8083, -65.2176], 13); // Centered roughly on San Miguel de Tucumán

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mapModal);

            mapModal.on('click', function(e) {
                if (markerModal) {
                    mapModal.removeLayer(markerModal);
                }
                selectedLat = e.latlng.lat;
                selectedLng = e.latlng.lng;
                markerModal = L.marker([selectedLat, selectedLng]).addTo(mapModal)
                    .bindPopup('Ubicación seleccionada').openPopup();
            });
        }

        // Invalidate size after modal is fully shown to ensure map renders correctly
        $('#mapModal').on('shown.bs.modal', function () {
            mapModal.invalidateSize();
            // If there's a previously selected location, set the view to it
            if (selectedLat && selectedLng) {
                mapModal.setView([selectedLat, selectedLng], 15);
                if (markerModal) {
                    mapModal.removeLayer(markerModal);
                }
                markerModal = L.marker([selectedLat, selectedLng]).addTo(mapModal)
                    .bindPopup('Ubicación seleccionada').openPopup();
            } else {
                // Otherwise, set to a default view (e.g., center of Tucumán province)
                mapModal.setView([-26.8083, -65.2176], 13);
            }
        });
    }

    // Call initializeMapModal when the page loads or when appropriate
    $(document).ready(function() {
        initializeMapModal();
    });


    // --- Search Functionality ---
    const addressSearchInput = document.getElementById('address-search-input');
    const searchAddressBtn = document.getElementById('search-address-btn');
    const addressSuggestionsDiv = document.getElementById('address-suggestions');
    const confirmSelectionBtn = document.getElementById('confirm-selection-btn');

    let debounceTimer;

    // Function to fetch and display suggestions
    function fetchAddressSuggestions(query) {
        if (query.length < 3) { // Only search for queries with 3 or more characters
            addressSuggestionsDiv.innerHTML = '';
            return;
        }

        // Limit search to Argentina, specifically Tucumán (using 'county' or 'state' bias)
        // Adjust the 'viewbox' and 'bounded' parameters to prioritize results within Tucumán
        const nominatimUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=ar&state=Tucuman&limit=10&addressdetails=1`;

        fetch(nominatimUrl)
            .then(response => response.json())
            .then(data => {
                addressSuggestionsDiv.innerHTML = ''; // Clear previous suggestions
                if (data.length === 0) {
                    addressSuggestionsDiv.innerHTML = '<div class="list-group-item">No se encontraron sugerencias.</div>';
                    return;
                }

                data.forEach(result => {
                    const listItem = document.createElement('a');
                    listItem.href = '#';
                    listItem.classList.add('list-group-item', 'list-group-item-action');
                    listItem.textContent = result.display_name;
                    listItem.addEventListener('click', (event) => {
                        event.preventDefault();
                        addressSearchInput.value = result.display_name; // Set input value to selected suggestion
                        selectedLat = parseFloat(result.lat);
                        selectedLng = parseFloat(result.lon);
                        
                        // Clear previous marker and add a new one
                        if (markerModal) {
                            mapModal.removeLayer(markerModal);
                        }
                        markerModal = L.marker([selectedLat, selectedLng]).addTo(mapModal)
                            .bindPopup(result.display_name).openPopup();
                        mapModal.setView([selectedLat, selectedLng], 16); // Zoom to selected location
                        addressSuggestionsDiv.innerHTML = ''; // Clear suggestions after selection
                    });
                    addressSuggestionsDiv.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('Error fetching address suggestions:', error);
                addressSuggestionsDiv.innerHTML = '<div class="list-group-item text-danger">Error al buscar sugerencias.</div>';
            });
    }

    // Debounce input for suggestions
    addressSearchInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchAddressSuggestions(e.target.value);
        }, 500); // 500ms debounce time
    });

    // Handle explicit search button click
    searchAddressBtn.addEventListener('click', () => {
        fetchAddressSuggestions(addressSearchInput.value);
    });

    // Handle confirmation button click
    confirmSelectionBtn.addEventListener('click', () => {
        if (selectedLat && selectedLng) {
            // Here you would update your external inputs (e.g., addressA-input, addressB-input)
            // For demonstration, let's just log the selected coordinates and address
            console.log('Ubicación confirmada:');
            console.log('Latitud:', selectedLat);
            console.log('Longitud:', selectedLng);
            console.log('Dirección:', addressSearchInput.value);

            // Example of updating external input fields (replace with your actual input IDs)
            // document.getElementById('addressA-input').value = addressSearchInput.value;
            // document.getElementById('latitude-input').value = selectedLat; // If you have separate inputs for lat/lng
            // document.getElementById('longitude-input').value = selectedLng;

            // Optionally, clear the selection and map for the next use
            selectedLat = null;
            selectedLng = null;
            if (markerModal) {
                mapModal.removeLayer(markerModal);
            }
            addressSearchInput.value = '';
            addressSuggestionsDiv.innerHTML = '';
        } else {
            alert('Por favor, selecciona una ubicación en el mapa o busca una dirección.');
            // Prevent modal from closing if no location is selected
            // You might need to adjust the data-bs-dismiss attribute on the button
            // or return false if using an older Bootstrap version
        }
    });

    // Reset map and selection when modal is hidden
    $('#mapModal').on('hidden.bs.modal', function () {
        selectedLat = null;
        selectedLng = null;
        if (markerModal) {
            mapModal.removeLayer(markerModal);
        }
        addressSearchInput.value = '';
        addressSuggestionsDiv.innerHTML = '';
        // mapModal.remove(); // Only uncomment this if you need to completely destroy and re-initialize the map every time
        // mapModal = null;
    });