<?php

//importar la conexion
require 'includes/app.php';
$db = conectarDB();

//crear un email y password
$email = "correo@correo.com";
$password = "123456";

//hashear password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ( '${email}', '${passwordHash}' ); ";

//agregarlo a la base de datos
mysqli_query($db, $query);