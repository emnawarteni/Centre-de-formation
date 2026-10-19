<?php
$host = "localhost";
$port = "5433";
$dbname = "base10";
$user = "postgres";
$password = "password";
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if(!$conn){
    die("Erreur connexion");
}
?>