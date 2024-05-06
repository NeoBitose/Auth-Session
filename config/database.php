<?php 

$url = 'http://localhost/tugas-11';
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test_inject_strong';
try {
  $conn = new mysqli($host, $username, $password, $database);
} catch (\Throwable $e) {

  header('Location: http://localhost/views/errors/500.php?message="'.$e.'"');
}

