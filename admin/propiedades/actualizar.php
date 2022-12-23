<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';

    estaAutenticado();
    // // Proteger esta ruta.
    // $auth = estaAutenticado();

    // if(!$auth) {
    //     header('Location: /');
    // }

    //validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    //base de datos
    // require '../../includes/config/database.php';
    // $db = conectarDB();

    // //consulta para obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);
    // $consulta = "SELECT * FROM propiedades WHERE id = ${id}";
    // $resultado = mysqli_query($db, $consulta);
    // $propiedad = mysqli_fetch_assoc($resultado);

    //consultar bd para obtener los vendedores
    // $consulta = "SELECT * FROM vendedores";
    // $resultado = mysqli_query($db, $consulta);

    //consulta para obtener todos los vendedores 
    $vendedores = Vendedor::all();

    //arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    //asignar valores iniciales
    // $titulo = $propiedad->titulo;
    // $precio = $propiedad['precio'];
    // $descripcion = $propiedad['descripcion'];
    // $habitaciones = $propiedad['habitaciones'];
    // $wc = $propiedad['wc'];
    // $estacionamiento = $propiedad['estacionamiento'];
    // $vendedorId = $propiedad['vendedorId'];
    // $imagenPropiedad = $propiedad['imagen'];

    //ejecutar el codigo despues de q el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //asignar los atributos 
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        // $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
        // $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        // $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        // $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
        // $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
        // $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
        // $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor'] );
        // $creado = date('Y/m/d');

        //validacion 
        $errores = $propiedad->validar();

        //subida de archivos 
        //generar un nombre unico para la imagen
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        //asignar files hacia una variable
        // $imagen = $_FILES['imagen'];

        // if(!$titulo) {
        //     $errores[] = "Debes añadir un titulo";
        // }

        // if(!$precio) {
        //     $errores[] = "Debes añadir un precio";
        // }

        // if( strlen( $descripcion ) < 50 ) {
        //     $errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
        // }

        // if(!$habitaciones) {
        //     $errores[] = "El número de habitaciones es obligatorio";
        // }

        // if(!$wc) {
        //     $errores[] = "El número de baños es obligatorio";
        // }

        // if(!$estacionamiento) {
        //     $errores[] = "El número de lugares de estacionamiento es obligatorio";
        // }

        // if(!$vendedorId) {
        //     $errores[] = "Elige un vendedor";
        // }

        // //validacion para imagenes
        // // if(!$imagen['name'] || $imagen['error']) {
        // //     $errores[] = 'La imagen es obligatoria';
        // // }

        // //validar por tamaño de imagenes (1mb maximo)
        // //bytes a kb
        // $medida = 1000 * 1000;

        // if($imagen['size'] > $medida) {
        //     $errores[] = 'La imagen es muy pesada';
        // }


        //revisar q el arreglo de errores este vacio
        if(empty($errores)) {

            // //subir imagenes
            // //crear carpeta
            // $carpetaImagenes = '../../imagenes/';
            // //retorna si una carpeta existe o no
            // if(!is_dir($carpetaImagenes)) {
            //     //crear un directorio o carpeta
            //     mkdir($carpetaImagenes);
            // }

            // $nombreImagen = '';

            // //verificar si se actualizo la imagen
            // if($imagen['name']) {
            //     //eliminar la imagen previa
            //     unlink($carpetaImagenes . $propiedad['imagen']);

            //     //generar un nombre unico para la imagen
            //     $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
            //     //subir la imagen
            //     move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            // } else {
            //     $nombreImagen = $propiedad['imagen'];
            // }         

            if($_FILES['propiedad']['tmp_name']['imagen']) {
            //almacenar la imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();

            //insertar en la base de datos
            // $query = " UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id} ";

            // $resultado = mysqli_query($db, $query) or die(mysqli_error($db));

            // if($resultado) {
            //     //redireccionar al usuario
            //     header('Location: /admin?resultado=2');
            // }
        }

    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>