<?php
// If you installed via composer, just use this code to require autoloader on the top of your projects.
require 'medoo.php';
    
// Using Medoo namespace
use Medoo\Medoo;
    
$database = new Medoo([
    // required
    'database_type' => 'mysql',
    'database_name' => 'word',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

$count = $database->count("sehirler");
echo $count;

?>