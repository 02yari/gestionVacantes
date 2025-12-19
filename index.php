<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultores Chiriquí | Plataforma de Vacantes</title>
    <link rel="stylesheet" href="public/css/index.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <div class="branding">
            <h1>Consultores Chiriquí</h1>
            <span>Talento • Oportunidades • Crecimiento</span>
        </div>

        <nav class="menu">
            <a href="app/Views/Auth/login.php">Empresa</a>
            <a href="app/Views/Auth/login.php">Publicar Vacante</a>
            <a href="app/Views/Auth/login.php">Consultora</a>
            <a href="app/Views/Auth/login.php">Chatbot</a>

        </nav>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h2>Conectamos personas con oportunidades reales</h2>
        <p>
            Una plataforma moderna que permite a empresas públicas y privadas
            publicar vacantes accesibles para toda la población, sin procesos complejos.
        </p>

        <div class="hero-actions">
            <a href="app/controllers/VacanteController.php" class="btn btn-main">
                Explorar Vacantes
            </a>
             <a href="app/Views/Auth/login.php" class="btn btn-outline">
                Publicar Vacante
            </a>
        </div>
    </div>
</section>

<!-- BENEFICIOS -->
<section class="benefits">
    <div class="benefit-card">
        <h3>Accesibilidad</h3>
        <p>
            Las personas pueden consultar oportunidades laborales sin necesidad
            de crear una hoja de vida o registrarse.
        </p>
    </div>

    <div class="benefit-card">
        <h3>Gestión Profesional</h3>
        <p>
            Las empresas cuentan con herramientas claras para administrar vacantes
            y visualizar interacciones.
        </p>
    </div>

    <div class="benefit-card">
        <h3>Análisis & Facturación</h3>
        <p>
            La empresa consultora gestiona estadísticas, peajes de acceso
            y facturación digital.
        </p>
    </div>
</section>

<!-- SECCIÓN INFORMATIVA -->
<section class="about">
    <div class="about-text">
        <h2>Sobre la Plataforma</h2>
        <p>
            Este proyecto nace con el objetivo de acercar las oportunidades laborales
            a la población de la provincia de Chiriquí, mediante un sistema intuitivo,
            moderno y orientado a resultados.
        </p>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>© <?php echo date("Y"); ?> Consultores Chiriquí, S.A.</p>
    <span>Proyecto Académico – Plataforma de Gestión de Vacantes</span>
</footer>

</body>
</html>
