<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tache = htmlspecialchars($_POST['tache']);
    $description = htmlspecialchars($_POST['description']);
    $heure_debut = htmlspecialchars($_POST['heure_debut']);
    $heure_fin = htmlspecialchars($_POST['heure_fin']);
    $date_tache = htmlspecialchars($_POST['date_tache']);

    $sql = "INSERT INTO taches (tache, description, heure_debut, heure_fin, date_tache) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$tache, $description, $heure_debut, $heure_fin, $date_tache])) {
        $_SESSION['message'] = "Tâche ajoutée avec succès !";
    } else {
        $_SESSION['error'] = "Erreur lors de l'ajout de la tâche.";
    }
    header('Location: index.php');
    exit();
}