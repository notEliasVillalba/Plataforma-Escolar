<?php include 'Static/includes/header.php'; ?>

<style>

html, body {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
    color: #333;
}

body {
    display: flex;
    flex-direction: column;
}

.hero {
    text-align: center;
    padding: 40px 20px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
}

.hero h1 {
    font-size: 3em;
}

.hero p {
    font-size: 1.5em;
}

section {
    padding: 40px 20px;
    text-align: center;
}

.about {
    background-color: #f5f5f5;
}

.about h2 {
    font-size: 2em;
}

.about p {
    font-size: 1.2em;
    color: #555;
}

.sections {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    padding: 20px;
}

.section-card {
    text-align: center;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    margin: 10px;
    width: 30%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.section-card h3 {
    font-size: 1.5em;
}

.section-card p {
    color: #666;
}

.section-card a {
    display: inline-block;
    color: white;
    background-color: #007BFF;
    padding: 10px 15px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
}

.section-card a:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

footer {
    background-color: #2C4877;
    color: white;
    padding: 10px;
    text-align: center;
    width: 100%;
}

</style>

<div class="carousel"></div>

<div class="hero">
    <h1>¡Bienvenidos a PLATAFORMA ESCOLAR!</h1>
    <p>Formando líderes con valores, excelencia académica y compromiso.</p>
</div>

<section class="about">
    <h2>Acerca de Nosotros</h2>
    <p>[Nombre de la Escuela] es una institución educativa comprometida con el desarrollo integral de nuestros estudiantes. Ofrecemos programas educativos de alta calidad que fomentan el aprendizaje, la creatividad y la responsabilidad social.</p>
</section>

<section class="sections">
    <div class="section-card">
        <h3>Horarios</h3>
        <p>Consulta los horarios de clases y actividades.</p>
        <a href="#">Ver Horarios</a>
    </div>
    <div class="section-card">
        <h3>Noticias</h3>
        <p>Mantente informado con las últimas noticias de la escuela.</p>
        <a href="#">Leer Noticias</a>
    </div>
    <div class="section-card">
        <h3>Eventos</h3>
        <p>Descubre nuestros próximos eventos y actividades.</p>
        <a href="#">Ver Eventos</a>
    </div>
</section>

<?php include 'Static/includes/footer.php'; ?>
