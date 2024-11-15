<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
<html>
<head>
    <title>Plaza Mundo - Inicio</title>
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <div class="container-fluid main-container">
        <div class="background-logo"></div>
        
        <div class="hero-section animate__animated animate__fadeIn">
            <div class="welcome-message">
                <h2>Bienvenido a Plaza Mundo</h2>
                <p class="user-greeting">¡Hola, <?php echo $_SESSION['usuario']; ?>!</p>
            </div>
        </div>

        <div class="company-section animate__animated animate__fadeInUp">
            <div class="logo-container">
                <img src="../img/JUEGOATRACCIONES.jpg" alt="Plaza Mundo Logo" class="company-logo">
            </div>
            <h1 class="company-title">Plaza Mundo Entretenimiento S.A</h1>
            <p class="company-description">
                Somos líderes en entretenimiento familiar, brindando diversión y seguridad en cada evento.
            </p>
        </div>

        <!-- Mission & Vision Section -->
        <div class="mission-vision-container">
            <div class="mission-card animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <i class="fas fa-bullseye"></i>
                    <h2>Misión</h2>
                </div>
                <div class="card-content">
                    <p>"Brindar experiencias únicas e inolvidables a familias y visitantes a través de un ambiente seguro, accesible y lleno de diversión, consolidándonos como líderes en entretenimiento ferial."</p>
                </div>
            </div>

            <div class="mission-card animate__animated animate__fadeInRight">
                <div class="card-header">
                    <i class="fas fa-eye"></i>
                    <h2>Visión</h2>
                </div>
                <div class="card-content">
                    <p>"Ser la feria más reconocida a nivel nacional e internacional, ofreciendo innovación constante en atracciones y servicios, con un enfoque en la satisfacción y seguridad de nuestros visitantes, contribuyendo al desarrollo social y económico de nuestra comunidad."</p>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card animate__animated animate__fadeInLeft">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>5</h3>
                <p>Años de Operación</p>
            </div>
            
            <div class="stat-card animate__animated animate__fadeInUp">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>250</h3>
                <p>Eventos Organizados</p>
            </div>
            
            <div class="stat-card animate__animated animate__fadeInRight">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>500,000</h3>
                <p>Visitantes Totales</p>
            </div>
        </div>

        <div class="contact-container animate__animated animate__fadeInUp">
            <h2 class="contact-title">Información de Contacto</h2>
            <div class="contact-cards">
                <div class="contact-item">
                    <i class="fas fa-envelope pulse"></i>
                    <p>soporte@plazamundo.com</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone pulse"></i>
                    <p>+503 23452345</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt pulse"></i>
                    <p>San Salvador, El Salvador</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
    }else{
        header("location:../index.php");
    }
?>