<?php
include 'db.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tache = $_POST['tache'];
    $description = $_POST['description'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $date_tache = $_POST['date_tache'];

    addTask($conn, $tache, $description, $heure_debut, $heure_fin, $date_tache);
    header('Location: index.php');
    exit();
}