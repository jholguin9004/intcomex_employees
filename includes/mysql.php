<?php
require('config.php');
try{
    $mbd = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);
}catch(Exception $e){
    throw new Exception('Error al conectar con la DB:' . $e->getMessage());
}
?>