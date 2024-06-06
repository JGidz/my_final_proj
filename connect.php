<?php
$host = "localhost"; 
$port = "5432"; 
$dbname = "users";
$user = "postgres"; 
$password = "P0lygonals"; 

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


