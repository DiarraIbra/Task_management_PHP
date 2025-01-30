<?php
include 'db.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteTask($conn, $id);
    header('Location: index.php');
    exit();
}