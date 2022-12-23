<?php 

namespace App;

class ActiveRecord {
    //BD
    protected static $db;
    //crear arreglo de columnas
    protected static $columnasDB = [];
    
    protected static $tabla = '';

    //Errores
    protected static $errores = [];

    //forma anterior a PHP 8
    // public $id;       
    // public $titulo;       
    // public $precio;       
    // public $imagen;       
    // public $descripcion;       
    // public $habitaciones;       
    // public $wc;       
    // public $estacionamiento;       
    // public $creado;       
    // public $vendedorId; 
    
    //definir la conexion a la BD
    public static function setDB($database) {
        self::$db = $database;
    }
    

    // public function __construct($args = [])
    // {
    //     $this->id = $args['id'] ?? NULL;
    //     $this->titulo = $args['titulo'] ?? '';
    //     $this->precio = $args['precio'] ?? '';
    //     $this->imagen = $args['imagen'] ?? '';
    //     $this->descripcion = $args['descripcion'] ?? '';
    //     $this->habitaciones = $args['habitaciones'] ?? '';
    //     $this->wc = $args['wc'] ?? '';
    //     $this->estacionamiento = $args['estacionamiento'] ?? '';
    //     $this->creado = date('Y/m/d');
    //     $this->vendedorId = $args['vendedorId'] ?? 1;
    // }

    public function guardar() {
        if(!is_null($this->id)) {
            //actualizar
            $this->actualizar();
        } else {
            //creando un nuevo registro
            $this->crear();
        }
    }

    public function crear() {
        //sanitizar entrada de datos con POO
        $atributos = $this->sanitizarAtributos();

        //crear string a partir de un arreglo  (acceder a llaves del arreglo )
        // $string = join(', ', array_keys($atributos));

        //acceder a los valores de un arreglo
        // $string = join(', ', array_values($atributos));

        //insertar en la base de datos
        // $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) VALUES ( '$this->titulo', '$this->precio', '$this->imagen', '$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedorId' ) ";

        //insertar datos ya sanitizados en la BD
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        //mensaje de exito o error
        if($resultado) {
            //redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar() {
        //sanitizar entrada de datos con POO
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if($resultado) {
            //redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
    }

    //eliminar una propiedad
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    //iterar sobre las columnas - identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //sanitizar
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //subida de archivos
    public function setImagen($imagen) {
        //elimina la imagen previa
        if(!is_null($this->id) ) {
            //comprobar si el archivo existe
            $this->borrarImagen();
        }

        //asignar al atributo de imagen el nombre de la imagen 
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //elimina el archivo (imagen)
    public function borrarImagen() {
        //comprobar si el archivo existe
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //validacion
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    //lista todas las propiedades 
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //obtiene determinado numero de registros
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //busca una propiedad por su id (actualizar)
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        //consultar la BD
        $resultado = self::$db->query($query);

        //iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //liberar la memoria
        $resultado->free();

        //retornar los resultados 
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            if( property_exists($objeto, $key) ) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //sincroniza el objeto en memoria con los cambios realizados por el usuario (actualizar)
    public function sincronizar( $args = [] ) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }

}