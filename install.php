<?php

/**
  * Open a connection via PDO to create a
  * new database and table with structure.
  *
  */
require "config.php";

try{
    // code to execute
    $connection = new PDO("mysql:host=$host", $username, $password);
    //set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = file_get_contents("data/init.sql");
    $connection->exec($sql);
    echo "Database and table users created successfully.";
    
}catch(PDOException $error) {
    // exception
    echo $sql . "<br>" . $error->getMessage();
    }

$connection = null;
