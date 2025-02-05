<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM taches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$id])) {
        $_SESSION['message'] = "Tâche supprimée avec succès !";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de la tâche.";
    }
    header('Location: index.php');
    exit();
}
