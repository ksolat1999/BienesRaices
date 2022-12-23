<?php

    require '../../includes/app.php';

    use App\Vendedor;

    estaAutenticado();

    //validar q sea un ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    //obtener el arreglo del vendedor
    $vendedor = Vendedor::find($id);

    //arreglo con mensajes de errores
    $errores = Vendedor::getErrores();

    //ejecutar el codigo despues de q el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //asignar los valores
        $args = $_POST['vendedor'];

        //sincronizar objeto en memoria con lo q el usuario escribió
        $vendedor->sincronizar($args);

        //validacion 
        $errores = $vendedor->validar();
        
        //si no hay errores
        if(empty($errores))  {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');

?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>