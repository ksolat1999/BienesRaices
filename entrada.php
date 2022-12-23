<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guia para la decoración de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus?Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus?</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architecto placeat id quas nostrum reiciendis ex, saepe omnis doloribus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore tenetur, hic alias temporibus repellat in fugiat vero sit qui obcaecati architec</p>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>