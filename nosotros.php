<?php
    require 'includes/app.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce Sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp"> 
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg"> 
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>25 Años de Experiencia</blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus?Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus?</p>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architec</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Tempore quisquam facilis repellendus, aperiam placeat fugit magnam eum tenetur rem vero distinctio voluptatem quas ea totam optio, voluptas debitis autem vel!</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Tempore quisquam facilis repellendus, aperiam placeat fugit magnam eum tenetur rem vero distinctio voluptatem quas ea totam optio, voluptas debitis autem vel!</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Tempore quisquam facilis repellendus, aperiam placeat fugit magnam eum tenetur rem vero distinctio voluptatem quas ea totam optio, voluptas debitis autem vel!</p>
            </div>
        </div>
    </section>

<?php
    incluirTemplate('footer');
?>