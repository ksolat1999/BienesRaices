<?php

namespace App;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';

    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {

        if(!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }

        if(!$this->apellido) {
            self::$errores[] = "El apellido es obligatorio";
        }

        if(!$this->telefono) {
            self::$errores[] = "El teléfono es obligatorio";
        }

        //expresion regular = buscar un patron dentro de un texto
        if(!preg_match('/[0-9]{10}/', $this->telefono) or strlen($this->telefono) > 10) {
            self::$errores[] = "Formato de teléfono no válido";
        }

        return self::$errores;
    }
}