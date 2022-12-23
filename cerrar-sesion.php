<?php

session_start();

//cerrar la sesion reasignandole un arreglo vacio
$_SESSION = [];

//redireccionar al usuario
header('Location: /');