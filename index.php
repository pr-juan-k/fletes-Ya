<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>fletes-YA</title>
  <meta name="description" content="Fletes-Ya:¡Ingresa ahora y cotiza tu viaje de forma rápida y sencilla! Tu empresa de fletes y mudanzas con más de 10 años de experiencia en Tucumán. Servicios profesionales, puntuales y responsables. ¡Ingresa ahora y cotiza tu viaje de forma rápida y sencilla!">
  <meta name="keywords" content="fletes, mudanzas, transporte, camiones, fletes Tucumán, mudanzas Tucumán, fletes San Miguel de Tucumán, transporte de carga, fletes económicos, mudanzas urgentes, cotizar flete, fletes y mudanzas Tucumán, servicio de fletes, fletes confiables, empresa de fletes, transportes">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        
        <img src="assets/img/myAddfFT/fletes-YA-1.jpg" alt=""  class="myLog">
  
        <!-- <h1 class="sitename">fletest-YA</h1>-->

        
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="index.php" class="active"><i class="bi bi-house-door"></i> Inicio</a></li>
            <li><a href="#hero"><i class="bi bi-calculator"></i> Ir A Cotizar</a></li>
            <li><a href="#about"><i class="bi bi-bookmark-check"></i> Reservados</a></li>

            <li><a href="#viajes-realizados"><i class="bi bi-geo-alt"></i> Viajes Realizados</a></li>
            <li><a href="#register-section"><i class="bi bi-person-plus"></i> Registrarse</a></li>
            <li><a href="#about-us-block"><i class="bi bi-envelope"></i> Sobre Nosotros</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    </div>
  </header>

  <main class="main">

    <section id="hero" class="hero section dark-background">
        <div class="hero-container">
            <img src="assets/img/myAddfFT/portaDA.jpg" alt="Imagen de Fondo" class="video-background">
            
            <div class="overlay"></div>
            
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    
                    <div class="col-lg-8 col-md-10" data-aos="zoom-out" data-aos-delay="200">
                        <div class="stats-card p-4 p-md-5">
                            <div class="stats-header text-center mb-4">
                                <h1>Fletes-Ya</h1>
                                <h5>Cotiza tu Viaje al Instante</h5>
                                <div class="decoration-line mx-auto mt-3 mb-4"></div>
                            </div>
    
                            <div class="php-email-form">
                                <div class="col-md-12 mb-4" id="results-section" style="display:none;">
                                    <h5 class="text-center mb-3">Resumen de tu Cotización:</h5>
                                    <div id="route-map" class="results-map-container mb-3" style="min-height: 250px; border-radius: 8px; overflow: hidden;"></div>
                                    <p class="lead text-center">Distancia estimada: <strong id="distance-output"></strong></p>
                                    <p class="lead text-center">Costo total del viaje: <strong id="cost-output"></strong></p>
                                    <div class="text-center mt-4" id="action-buttons-container">
                                        </div>
                                </div>
    
                                <div id="quotation-form-container">
                                    <h5 class="text-center mb-4">Ingresa los detalles de tu flete:</h5>
                                    <div class="row gy-4">
                                        <div class="col-md-12">
                                            <label for="nombrePersona" class="form-label">Nombre Completo:</label>
                                            <input type="text" class="form-control" id="nombrePersona" name="nombrePersona" placeholder="Ej: Juan Pérez" required>
                                        </div>
    
                                        <div class="col-md-12">
                                            <label for="addressA-input" class="form-label">Punto A (Origen):</label>
                                            <div class="input-group">
                                                <input type="text" id="addressA-input" class="form-control" placeholder="Ej: Av. Roca 100, Tucumán">
                                                <button type="button" class="btn btn-outline-secondary" id="geocode-A-btn">Buscar</button>
                                            </div>
                                            <button type="button" class="btn btn-info mt-2 w-100 text-white" data-bs-toggle="modal" data-bs-target="#mapModal" data-point-type="A">Seleccionar en Mapa (Punto A)</button>
                                            <input type="hidden" id="latA">
                                            <input type="hidden" id="lngA">
                                            <input type="hidden" id="display-addressA">
                                        </div>
    
                                        <div class="col-md-12">
                                            <label for="addressB-input" class="form-label">Punto B (Destino):</label>
                                            <div class="input-group">
                                                <input type="text" id="addressB-input" class="form-control" placeholder="Ej: San Martín 500, Tucumán">
                                                <button type="button" class="btn btn-outline-secondary" id="geocode-B-btn">Buscar</button>
                                            </div>
                                            <button type="button" class="btn btn-info mt-2 w-100 text-white" data-bs-toggle="modal" data-bs-target="#mapModal" data-point-type="B">Seleccionar en Mapa (Punto B)</button>
                                            <input type="hidden" id="latB">
                                            <input type="hidden" id="lngB">
                                            <input type="hidden" id="display-addressB">
                                        </div>
    
                                        <div class="col-md-12">
                                            <label for="cantidadCargas" class="form-label">Cantidad de cargas:</label>
                                            <input type="number" class="form-control" id="cantidadCargas" name="cantidadCargas" min="1" placeholder="Ej: 3" required>
                                        </div>
    
                                        <div class="col-md-12">
                                            <label class="form-label d-block">¿Necesita ayuda para cargar? (+$5.000)</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ayudaCargar" id="ayudaCargarSi" value="si" required>
                                                <label class="form-check-label" for="ayudaCargarSi">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ayudaCargar" id="ayudaCargarNo" value="no" checked>
                                                <label class="form-check-label" for="ayudaCargarNo">No</label>
                                            </div>
                                        </div>
                        
                                        <div class="col-md-12">
                                            <label class="form-label d-block">¿Necesita ayuda para descargar? (+$5.000)</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ayudaDescargar" id="ayudaDescargarSi" value="si" required>
                                                <label class="form-check-label" for="ayudaDescargarSi">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ayudaDescargar" id="ayudaDescargarNo" value="no" checked>
                                                <label class="form-check-label" for="ayudaDescargarNo">No</label>
                                            </div>
                                        </div>
                        
                                        <div class="col-md-12">
                                            <label class="form-label d-block">¿Hay ascensor en el origen/destino? (+$500 por carga)</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ascensor" id="ascensorSi" value="si" required>
                                                <label class="form-check-label" for="ascensorSi">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ascensor" id="ascensorNo" value="no" checked>
                                                <label class="form-check-label" for="ascensorNo">No</label>
                                            </div>
                                        </div>
                        
                                        <div class="col-md-12">
                                            <label class="form-label d-block">¿Hay escaleras en el origen/destino? (+$2.000 por carga)</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="escaleras" id="escalerasSi" value="si" required>
                                                <label class="form-check-label" for="escalerasSi">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="escaleras" id="escalerasNo" value="no" checked>
                                                <label class="form-check-label" for="escalerasNo">No</label>
                                            </div>
                                        </div>
                        
                                        <div class="col-md-12">
                                            <label class="form-label d-block">¿Cuándo desea el flete?</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="fechaFlete" id="solicitarAhora" value="ahora" checked>
                                                <label class="form-check-label" for="solicitarAhora">Solicitar ahora</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="fechaFlete" id="programarFecha" value="programar">
                                                <label class="form-check-label" for="programarFecha">Programar fecha</label>
                                            </div>
                                        </div>
                        
                                        <div id="programarFechaCampos" class="col-md-12" style="display: none;">
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Día</label>
                                                <input type="date" class="form-control" id="fecha" name="fecha">
                                            </div>
                                            <div class="mb-3">
                                                <label for="hora" class="form-label">Hora</label>
                                                <input type="time" class="form-control" id="hora" name="hora">
                                            </div>
                                        </div>
                        
                                        <div class="col-md-12">
                                            <label for="descripcionAdicional" class="form-label">Descripción Adicional (Opcional):</label>
                                            <textarea class="form-control" id="descripcionAdicional" name="descripcionAdicional" rows="3" placeholder="Ej: Mercadería frágil, instrucciones de entrega, etc."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 text-center mt-4">
                                        <div class="loading" style="display:none;">Calculando...</div>
                                        <div class="error-message alert alert-danger" style="display:none;"></div>
                                        <button type="button" id="calculate-cost-btn" class="btn btn-success btn-lg">Calcular Costo del Viaje</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="event-ticker">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-md-6 col-xl-4 col-12 ticker-item">
                        <span class="date">DESDE 2014</span>
                        <span class="title">Más de 10 Años de Experiencia en Fletes</span>
                        <a href="#about-us-block" class="btn-register">Conocenos</a>
                    </div>
                    
                    <div class="col-md-6 col-12 col-xl-4 ticker-item">
                        <span class="date">NUESTRO COMPROMISO</span>
                        <span class="title">Puntualidad Absoluta en Cada Entrega</span>
                        <a href="#hero" class="btn-register">Cotizá Ya</a>
                    </div>
                    
                    <div class="col-md-6 col-12 col-xl-4 ticker-item">
                        <span class="date">CLIENTES SATISFECHOS</span>
                        <span class="title">El 98% nos Recomienda por Responsabilidad</span>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Seleccionar ubicación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Haz clic en el mapa para seleccionar un punto.</p>
                    <div id="map-modal-container" style="height: 400px; width: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="confirm-selection-btn" data-bs-dismiss="modal">Confirmar Selección</button>
                </div>
            </div>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

  <script src="logica.js"></script>
  

    <!-- mi calculos-->

    <!--  Section reservados -->
    <section id="about" class="about section py-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="display-5 fw-bold mb-3">Viajes Recientes <span class="text-primary">Reservados</span></h2>
                    <p class="lead text-muted mx-auto" style="max-width: 700px;">Descubre algunos de los fletes que nuestros usuarios han reservado recientemente. Nos enorgullece mostrar nuestra actividad y compromiso.</p>
                </div>
            </div>

            <div class="row g-4 justify-content-center" id="reserved-trips-container">
                <?php
                // La ruta al archivo de texto
                $archivoTxt = 'assets/php/realizados.txt'; // Asegúrate de que esta ruta sea correcta

                $viajesReservadosActivos = [];
                $now = new DateTime(); // Obtener la fecha y hora actual

                if (file_exists($archivoTxt)) {
                    $todosLosViajes = file($archivoTxt, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    $todosLosViajes = array_reverse($todosLosViajes); // Mostrar los más nuevos primero

                    foreach ($todosLosViajes as $viaje) {
                        $datos = explode(' | ', $viaje);

                        $fecha_servicio_raw = $datos[6] ?? 'Ahora mismo';

                        // Si la fecha de servicio NO es "Ahora mismo", es un viaje RESERVADO
                        if (strcasecmp($fecha_servicio_raw, 'Ahora mismo') !== 0) {
                            try {
                                // Intentar parsear la fecha de servicio para comparar
                                // El formato esperado es "YYYY-MM-DD a las HH:MM"
                                // Necesitamos limpiarlo para que DateTime lo entienda
                                $fechaServicioStr = str_replace(' a las ', ' ', $fecha_servicio_raw);
                                $fechaServicioObj = new DateTime($fechaServicioStr);

                                // Solo añadir a la lista si la fecha de servicio es FUTURA o HOY
                                // Esto significa que aún no ha "expirado"
                                if ($fechaServicioObj >= $now) {
                                    $viajesReservadosActivos[] = $datos; // Guarda los datos parseados
                                }
                            } catch (Exception $e) {
                                // Ignorar líneas con formato de fecha inválido o no parseable
                                // echo "Error parseando fecha: " . $fecha_servicio_raw . " - " . $e->getMessage() . "<br>";
                            }
                        }
                    }
                }

                // Si no hay viajes reservados activos, muestra un mensaje
                if (empty($viajesReservadosActivos)) {
                    echo '<div class="col-12 text-center py-5">';
                    echo '<p class="lead text-muted">No hay viajes <span class="fw-bold text-primary">reservados</span> activos en este momento.</p>';
                    echo '<p class="text-secondary small">¡Anímate a programar tu próximo flete!</p>';
                    echo '</div>';
                } else {
                    // Limitar a los 4 más recientes viajes reservados activos (si hay más)
                    $limitedReservadosActivos = array_slice($viajesReservadosActivos, 0, 4);

                    foreach ($limitedReservadosActivos as $datos) {
                        // Asignar a variables
                        $timestamp        = $datos[0] ?? '';
                        $nombre           = $datos[1] ?? 'Cliente';
                        $origen           = $datos[2] ?? 'Origen no especificado';
                        $destino          = $datos[3] ?? 'Destino no especificado';
                        $distancia        = $datos[4] ?? '';
                        $costo            = $datos[5] ?? '';
                        $fecha_servicio   = $datos[6] ?? '';
                        $descripcion      = $datos[7] ?? 'Servicio de flete estándar.';

                        // Procesar el timestamp de creación del registro para "Hace X tiempo"
                        $tiempoTranscurrido = '';
                        try {
                            $fechaCreacion = new DateTime($timestamp);
                            $intervalo = $now->diff($fechaCreacion); // Usar $now para calcular la diferencia

                            if ($intervalo->y > 0) {
                                $tiempoTranscurrido = 'Hace ' . $intervalo->y . ' año' . ($intervalo->y > 1 ? 's' : '');
                            } elseif ($intervalo->m > 0) {
                                $tiempoTranscurrido = 'Hace ' . $intervalo->m . ' mes' . ($intervalo->m > 1 ? 'es' : '');
                            } elseif ($intervalo->d > 0) {
                                $tiempoTranscurrido = 'Hace ' . $intervalo->d . ' día' . ($intervalo->d > 1 ? 's' : '');
                            } elseif ($intervalo->h > 0) {
                                $tiempoTranscurrido = 'Hace ' . $intervalo->h . ' hora' . ($intervalo->h > 1 ? 's' : '');
                            } elseif ($intervalo->i > 0) {
                                $tiempoTranscurrido = 'Hace ' . $intervalo->i . ' minuto' . ($intervalo->i > 1 ? 's' : '');
                            } else {
                                $tiempoTranscurrido = 'Hace un momento';
                            }
                        } catch (Exception $e) {
                            $tiempoTranscurrido = 'Fecha desconocida';
                        }

                        // Formatear la fecha del servicio para mostrar en la tarjeta
                        $fechaServicioDisplay = '';
                        if (strcasecmp($fecha_servicio, 'Ahora mismo') !== 0) {
                            try {
                                $fsObj = new DateTime(str_replace(' a las ', ' ', $fecha_servicio));
                                $fechaServicioDisplay = $fsObj->format('d/m/Y H:i'); // Formato más amigable
                            } catch (Exception $e) {
                                $fechaServicioDisplay = $fecha_servicio; // Mostrar tal cual si no se puede parsear
                            }
                        } else {
                            $fechaServicioDisplay = 'Inmediato'; // No debería llegar aquí por el filtro
                        }

                        // Simplificar el trayecto para la tarjeta
                        $origen_corto = strtok($origen, ',');
                        $destino_corto = strtok($destino, ',');
                        $trayecto = htmlspecialchars($origen_corto) . ' a ' . htmlspecialchars($destino_corto);
                ?>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card trip-card h-100 shadow-sm border-0 rounded-lg overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title text-primary mb-3 fw-bold"><i class="bi bi-person-fill me-2"></i> <?php echo htmlspecialchars($nombre); ?></h5>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-info"></i> Origen: <strong><?php echo htmlspecialchars($origen_corto); ?></strong></li>
                                <li class="mb-2"><i class="bi bi-pin-map-fill me-2 text-info"></i> Destino: <strong><?php echo htmlspecialchars($destino_corto); ?></strong></li>
                                <li class="mb-2"><i class="bi bi-rulers me-2 text-info"></i> Distancia: <strong><?php echo htmlspecialchars($distancia); ?></strong></li>
                                <li class="mb-2"><i class="bi bi-currency-dollar me-2 text-info"></i> Costo: <strong><?php echo htmlspecialchars($costo); ?></strong></li>
                                <li class="mb-2"><i class="bi bi-calendar-check me-2 text-info"></i> Fecha Reserva: <strong><?php echo htmlspecialchars($fechaServicioDisplay); ?></strong></li>
                                <li class="mb-0"><i class="bi bi-info-circle me-2 text-info"></i> Notas: <span class="text-dark"><?php echo htmlspecialchars($descripcion); ?></span></li>
                            </ul>
                        </div>
                        <div class="card-footer bg-light border-top text-muted text-end py-3 px-4 small">
                            <?php echo $tiempoTranscurrido; ?>
                        </div>
                    </div>
                </div>

                <?php
                    } // Fin del foreach
                }
                ?>
            </div>
        </div>
    </section>
    <!-- /Section reservados -->


    <!-- viajes-realizados Section -->
    <section id="viajes-realizados" class="events section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Viajes Realizados Recientes</h2>
                <p>Los fletes más actuales completados en la última semana.</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-4" id="viajes-grid">
                    <?php
                    // La ruta al archivo de texto
                    $archivoTxt = 'assets/php/realizados.txt'; // Asegúrate de que esta ruta sea correcta

                    $viajesRecientes = [];
                    $now = new DateTime(); // Fecha y hora actual
                    // Establece la zona horaria al inicio del script si no está ya definida globalmente
                    date_default_timezone_set('America/Argentina/Tucuman'); 

                    if (file_exists($archivoTxt)) {
                        $todosLosViajes = file($archivoTxt, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        $todosLosViajes = array_reverse($todosLosViajes); // Mostrar los más nuevos primero

                        $count = 0; // Contador para limitar a 4 viajes
                        foreach ($todosLosViajes as $viaje) {
                            // Si ya hemos alcanzado 4 viajes recientes, salimos del bucle
                            if ($count >= 4) {
                                break; 
                            }

                            $datos = explode(' | ', $viaje);

                            // Asegurarse de que el array $datos tenga suficientes elementos
                            // Nuestro formato es: timestamp | nombre | origen | destino | distancia | costo | fecha_servicio | descripcion
                            if (count($datos) < 8) {
                                continue; // Saltar líneas incompletas o mal formateadas
                            }
                            
                            $timestamp        = $datos[0];
                            $nombre           = $datos[1];
                            $origen           = $datos[2];
                            $destino          = $datos[3];
                            $distancia        = $datos[4];
                            $costo            = $datos[5];
                            $fecha_servicio   = $datos[6]; // Esta es la fecha ingresada por el usuario (Ahora mismo o programada)
                            $descripcion      = $datos[7];

                            // Intentar parsear el timestamp de CREACIÓN del registro para verificar la última semana
                            try {
                                $fechaRegistro = new DateTime($timestamp);
                                $unaSemanaAtras = (clone $now)->modify('-1 week'); // Clonar $now para no modificar el original
                                
                                // Solo procesar si el registro es de la última semana y NO es un viaje reservado futuro
                                // Ya que esta sección es para "Viajes Realizados", no "Reservados"
                                if ($fechaRegistro >= $unaSemanaAtras) {
                                    // Para esta sección de "realizados", podemos incluir todos los que estén dentro de la semana
                                    // y no sean "reservados" a futuro. Si "fecha_servicio" es "Ahora mismo",
                                    // o si "fecha_servicio" es una fecha pasada, se considera "realizado".
                                    
                                    $isReservedFuture = false;
                                    if (strcasecmp($fecha_servicio, 'Ahora mismo') !== 0) {
                                        try {
                                            $fechaServicioObj = new DateTime(str_replace(' a las ', ' ', $fecha_servicio));
                                            if ($fechaServicioObj > $now) { // Si la fecha de servicio es en el futuro
                                                $isReservedFuture = true;
                                            }
                                        } catch (Exception $e) {
                                            // Error al parsear fecha de servicio, se asume no futura.
                                        }
                                    }

                                    if (!$isReservedFuture) {
                                        $viajesRecientes[] = [
                                            'timestamp' => $timestamp,
                                            'nombre' => $nombre,
                                            'origen' => $origen,
                                            'destino' => $destino,
                                            'distancia' => $distancia,
                                            'costo' => $costo,
                                            'fecha_servicio' => $fecha_servicio,
                                            'descripcion' => $descripcion
                                        ];
                                        $count++; // Incrementar el contador de viajes mostrados
                                    }
                                }
                            } catch (Exception $e) {
                                // Ignorar líneas con timestamp inválido
                            }
                        }
                    }

                    // Si no hay viajes recientes que cumplan el criterio
                    if (empty($viajesRecientes)) {
                        echo '<div class="col-12 text-center py-5">';
                        echo '<p class="lead text-muted">No hay viajes realizados en la última semana.</p>';
                        echo '<p class="text-secondary small">¡Anímate a ser el próximo en contratar nuestros servicios!</p>';
                        echo '</div>';
                    } else {
                        // Iterar y mostrar los viajes recientes encontrados
                        foreach ($viajesRecientes as $viajeData) {
                            $timestamp = $viajeData['timestamp'];
                            $nombre = $viajeData['nombre'];
                            $origen = $viajeData['origen'];
                            $destino = $viajeData['destino'];
                            $distancia = $viajeData['distancia'];
                            $costo = $viajeData['costo'];
                            $fecha_servicio_raw = $viajeData['fecha_servicio'];
                            $descripcion = $viajeData['descripcion'];

                            // Procesar la fecha de REGISTRO para la tarjeta
                            try {
                                $fechaObj = new DateTime($timestamp);
                                $mes  = strtoupper($fechaObj->format('M'));
                                $dia  = $fechaObj->format('d');
                                $anio = $fechaObj->format('Y');
                                $hora = $fechaObj->format('H:i A');
                            } catch (Exception $e) {
                                $mes = '???'; $dia = '??'; $anio = '????'; $hora = '??:??';
                            }

                            // Simplificar el trayecto para la tarjeta
                            $origen_corto = strtok($origen, ',');
                            $destino_corto = strtok($destino, ',');
                            $trayecto = htmlspecialchars($origen_corto) . ' a ' . htmlspecialchars($destino_corto);
                    ?>

                    <div class="col-lg-6 event-item">
                        <div class="event-card">
                            <div class="event-date">
                                <span class="month"><?php echo $mes; ?></span>
                                <span class="day"><?php echo $dia; ?></span>
                                <span class="year"><?php echo $anio; ?></span>
                            </div>
                            <div class="event-content">
                                <div class="event-tag academic">Flete Particular</div>
                                <h3>Cliente: <?php echo htmlspecialchars($nombre); ?></h3>
                                <p><?php echo htmlspecialchars($descripcion); ?></p>
                                <div class="event-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span><?php echo $hora; ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-geo-alt"></i>
                                        <span><?php echo $trayecto; ?></span>
                                    </div>
                                </div>
                                <div class="event-actions">
                                    <a href="https://wa.me/5493813440889?text=Hola,%20quisiera%20pedir%20un%20presupuesto%20similar%20al%20viaje%20de%20<?php echo urlencode($nombre); ?>" class="btn-calendar" target="_blank"><i class="bi bi-whatsapp"></i> Cotizar Similar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        } // Fin del foreach para mostrar viajes recientes
                    }
                    ?>
                </div>
                </div>
    </section>
    <!-- /viajes-realizados Section -->

    

    <!-- Featured Programs Section -->
    <section id="register-section" class="register-section section py-5">
      <div class="container" data-aos="fade-up">
  
          <div class="container section-title text-center mb-5" data-aos="fade-up">
              <h2 class="display-5 fw-bold mb-3">¡Registrate con <span class="text-primary">Fletes-Ya!</span></h2>
              <p class="lead text-muted mx-auto" style="max-width: 700px;">Completa el formulario para empezar a disfrutar de nuestros servicios de fletes.</p>
          </div><div class="row justify-content-center">
              <div class="col-lg-8 col-md-10">
                  <div class="card p-4 shadow-lg rounded-lg border-0" data-aos="fade-up" data-aos-delay="100">
                      <div class="card-body">
                          <form action="#" method="post" class="php-email-form">
                              <div class="row gy-4">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="nombre" class="form-label">Nombre</label>
                                          <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Tu nombre" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="apellido" class="form-label">Apellido</label>
                                          <input type="text" name="apellido" class="form-control" id="apellido" placeholder="Tu apellido" required>
                                      </div>
                                  </div>
                              </div>
  
                              <div class="row gy-4 mt-3">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="email" class="form-label">Correo Electrónico</label>
                                          <input type="email" class="form-control" name="email" id="email" placeholder="tu@ejemplo.com" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="telefono" class="form-label">Número de Teléfono</label>
                                          <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="Ej: 381 1234567" required>
                                      </div>
                                  </div>
                              </div>
  
                              <div class="form-group mt-4">
                                  <label class="form-label d-block mb-2">Tipo de Cliente:</label>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="tipoCliente" id="nuevoCliente" value="nuevo" required>
                                      <label class="form-check-label" for="nuevoCliente">Nuevo Cliente</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="tipoCliente" id="clienteHabitual" value="habitual">
                                      <label class="form-check-label" for="clienteHabitual">Cliente Habitual</label>
                                  </div>
                              </div>
  
                              <div class="my-3">
                                  <div class="loading text-center" style="display:none;">Cargando...</div>
                                  <div class="error-message text-danger text-center" style="display:none;"></div>
                                  <div class="sent-message text-success text-center" style="display:none;">¡Tu registro ha sido enviado!</div>
                              </div>
  
                              <div class="text-center mt-4">
                                  <button type="submit" class="btn btn-primary btn-lg px-5">Registrarse</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
  
      </div>
  </section>
    <!-- /Featured Programs Section -->

    <!-- sobre nosotros Section -->
    <section id="about-us-block" class="about-us-block section py-5">
      <div class="container" data-aos="fade-up">
  
          <div class="container section-title text-center mb-5" data-aos="fade-up">
              <h2 class="display-5 fw-bold mb-3">Conocé Más <span class="text-primary">Sobre Nosotros</span></h2>
              <p class="lead text-muted mx-auto" style="max-width: 700px;">Descubre la trayectoria y los valores que nos han convertido en líderes en servicios de fletes en Tucumán.</p>
          </div><div class="row align-items-center gy-4">
              <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                  <div class="about-us-img position-relative">
                      <img src="assets/img/myAddfFT/descriptiva.jpg" class="img-fluid rounded-4 shadow-lg" alt="Imagen Descriptiva de Fletes-Ya">
                      <div class="img-overlay rounded-4">
                          <h3 class="text-white">Tu Solución en Fletes</h3>
                          <p class="text-white-50">Confianza, eficiencia y los mejores precios.</p>
                      </div>
                  </div>
              </div>
  
              <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                  <div class="about-us-content ps-lg-4">
                      <h3 class="fw-bold mb-4">Fletes-Ya: Experiencia y Compromiso en Cada Viaje</h3>
                      <p class="lead text-dark mb-4">
                          Con **más de 10 años de experiencia** en el sector, Fletes-Ya se ha consolidado como tu socio confiable para todo tipo de traslados en la provincia de Tucumán. Nos enorgullece ofrecer un servicio que combina **responsabilidad, puntualidad y precios accesibles**, adaptándonos a tus necesidades.
                      </p>
  
                      <div class="row g-4 mb-4">
                          <div class="col-md-6" data-aos="zoom-in" data-aos-delay="200">
                              <div class="feature-item text-center text-md-start">
                                  <div class="icon-box mx-auto mx-md-0 mb-3">
                                      <i class="bi bi-clock-history text-primary"></i>
                                  </div>
                                  <h4 class="fw-bold fs-5">Puntualidad Garantizada</h4>
                                  <p class="text-muted small">Valoramos tu tiempo. Nuestros servicios están diseñados para llegar a destino en el momento justo, sin demoras innecesarias.</p>
                              </div>
                          </div>
  
                          <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300">
                              <div class="feature-item text-center text-md-start">
                                  <div class="icon-box mx-auto mx-md-0 mb-3">
                                      <i class="bi bi-wallet-fill text-primary"></i>
                                  </div>
                                  <h4 class="fw-bold fs-5">Precios Accesibles</h4>
                                  <p class="text-muted small">Ofrecemos tarifas competitivas sin sacrificar la calidad del servicio. Tu economía es importante para nosotros.</p>
                              </div>
                          </div>
  
                          <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
                              <div class="feature-item text-center text-md-start">
                                  <div class="icon-box mx-auto mx-md-0 mb-3">
                                      <i class="bi bi-truck text-primary"></i>
                                  </div>
                                  <h4 class="fw-bold fs-5">Fletes para Cualquier Carga</h4>
                                  <p class="text-muted small">Desde pequeñas mudanzas hasta cargas comerciales, tenemos la capacidad y los vehículos adecuados para cada tipo de flete.</p>
                              </div>
                          </div>
  
                          <div class="col-md-6" data-aos="zoom-in" data-aos-delay="500">
                              <div class="feature-item text-center text-md-start">
                                  <div class="icon-box mx-auto mx-md-0 mb-3">
                                      <i class="bi bi-geo-alt-fill text-primary"></i>
                                  </div>
                                  <h4 class="fw-bold fs-5">Cobertura en Toda Tucumán</h4>
                                  <p class="text-muted small">Realizamos viajes a lo largo y ancho de la provincia, llegando a cada rincón con la misma eficiencia y dedicación.</p>
                              </div>
                          </div>
                      </div>
  
                      <div class="about-us-cta" data-aos="fade-up" data-aos-delay="600">
                          <a href="#register-section" class="btn btn-primary btn-lg">¡Registrate y Solicitá tu Flete!</a>
                      </div>
                  </div>
              </div>
          </div>
  
      </div>
    </section>
    <!-- /sobre nosotros Section -->


    

  </main>

  <footer id="footer" class="footer position-relative dark-background">

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Fletes-YA</strong> <span>All Rights Reserved</span></p>
      <div class="credits">

        Designed by <a href="https://wa.me/5493813440889?text=Hola,%20quisiera%20hacerte%20una%20consulta%20sobre%20tus%20servicios%20de%20PAGINAS%20WEBS.">Program.JK</a>
      </div>
    </div>

  </footer>

  <!--boton wp-->
  <a href="https://wa.me/5493813440889?text=Hola,%20quisiera%20hacerte%20una%20consulta%20sobre%20tus%20servicios%20de%20flete." 
   id="whatsapp-btn" 
   class="whatsapp-btn d-flex align-items-center justify-content-center" 
   target="_blank" 
   aria-label="Contactar por WhatsApp">
   <i class="bi bi-whatsapp"></i>
</a>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!--API mapa -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>


  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- Mi logica.js -->
  <script src="assets/js/logica.js"></script>


</body>

</html>