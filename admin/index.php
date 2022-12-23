<?php

    require '../includes/app.php';
    estaAutenticado();
    //importar las clases
    use App\Propiedad;
    use App\Vendedor;

    // if(!$auth) {
    //     header('Location: /');
    // }

    // //importar conexion a bd
    // require '../includes/config/database.php';
    // $db = conectarDB();

    // //escribir el query
    // $query = "SELECT * FROM propiedades";

    // //consultar la bd
    // $resultadoConsulta = mysqli_query($db, $query);

    //implementar un metodo para obtener todas las propiedades utilizando active record
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    //revisar request method
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //validar id
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {

            $tipo = $_POST['tipo'];

            if(validarTipoContenido($tipo)) {
                //compara lo q vamos a eliminar 
                if($tipo === 'vendedor') {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                } else if($tipo === 'propiedad') {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }

            // //eliminar el archivo
            // $query = "SELECT imagen FROM propiedades WHERE id = ${id}";

            // $resultado = mysqli_query($db, $query);
            // $propiedad = mysqli_fetch_assoc($resultado);

            // unlink('../imagenes/' . $propiedad['imagen']);

            // //eliminar la propiedad
            // $query = "DELETE FROM propiedades WHERE id = ${id}";
            // $resultado = mysqli_query($db, $query);

            // if($resultado) {
            //     header('Location: /admin?resultado=3');
            // }
        }
    }

    //incluye un template
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php  
            $mensaje = mostrarNotificacion( intval($resultado) );
            if($mensaje) { ?>
                <p class="alerta exito"><?php echo s($mensaje) ?> </p>
            <?php } ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

        <h2>Propiedades</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!--mostrar los resultados-->
                <?php foreach( $propiedades as $propiedad ): ?>
                <tr>
                    <td class="blanco"> <?php echo $propiedad->id; ?> </td>
                    <td class="blanco"> <?php echo $propiedad->titulo; ?> </td>
                    <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"> </td>
                    <td class="blanco">$ <?php echo $propiedad->precio; ?> </td>
                    <td>
                        <form method="POST" class="w-100">
                        <!-- boton oculto -->
                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                        <input type="hidden" name="tipo" value="propiedad">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>

                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!--mostrar los resultados-->
                <?php foreach( $vendedores as $vendedor ): ?>
                <tr>
                    <td class="blanco"> <?php echo $vendedor->id; ?> </td>
                    <td class="blanco"> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td class="blanco"> <?php echo $vendedor->telefono; ?> </td>
                    <td>
                        <form method="POST" class="w-100">
                        <!-- boton oculto -->
                        <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                        <input type="hidden" name="tipo" value="vendedor">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>

                        <a href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

<?php

    //cerrar la conexion a bd
    // mysqli_close($db);

    incluirTemplate('footer');
?>