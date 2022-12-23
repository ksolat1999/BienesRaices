<?php

    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    //base de datos
    // require '../../includes/config/database.php';
    // $db = conectarDB();

    $propiedad = new Propiedad;

    //consultar bd para obtener los vendedores
    // $consulta = "SELECT * FROM vendedores";
    // $resultado = mysqli_query($db, $consulta);

    //consulta para obtener todos los vendedores 
    $vendedores = Vendedor::all();

    //arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    // $titulo = '';
    // $precio = '';
    // $descripcion = '';
    // $habitaciones = '';
    // $wc = '';
    // $estacionamiento = '';
    // $vendedorId = '';

    //ejecutar el codigo despues de q el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //crea una nueva instancia
        $propiedad = new Propiedad($_POST['propiedad']);

        //generar un nombre unico para la imagen
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        //setear la imagen
        //realiza un resize a la imagen con intervention
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        //validar
        $errores = $propiedad->validar();

        // $numero = "1HOLA";
        // $numero2 = 1;

        // //sanitizar
        // $resultado = filter_var($numero, FILTER_SANITIZE_NUMBER_INT);
        // var_dump($resultado);

        // //validar
        // $resultado = filter_var($numero2, FILTER_VALIDATE_INT);
        // var_dump($resultado);

        // exit;

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";
        // exit;

        //sanitizar entrada de datos con forma de funciones
        // $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
        // $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        // $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        // $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
        // $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
        // $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
        // $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor'] );
        // $creado = date('Y/m/d');

        //asignar files hacia una variable
        
        // exit;


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
        // if(!$imagen['name'] || $imagen['error']) {
        //     $errores[] = 'La imagen es obligatoria';
        // }

        // //validar por tamaño de imagenes (1mb maximo)
        // //bytes a kb
        // $medida = 1000 * 1000;

        // if($imagen['size'] > $medida) {
        //     $errores[] = 'La imagen es muy pesada';
        // }


        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        //revisar q el arreglo de errores este vacio
        if(empty($errores)) {

            // $imagen = $_FILES['imagen'];

            //subir la imagen
            // move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            //crear carpeta para subir imagenes        
            //retorna si una carpeta existe o no
            if(!is_dir(CARPETA_IMAGENES)) {
                //crear un directorio o carpeta
                mkdir(CARPETA_IMAGENES);
            }

            //guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            // $resultado = mysqli_query($db, $query);

            //guardar en la BD
            $propiedad->guardar();

            // //mensaje de exito o error
            // if($resultado) {
            //     //redireccionar al usuario
            //     header('Location: /admin?resultado=1');
            // }
        }

    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>