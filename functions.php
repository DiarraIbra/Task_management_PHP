<?php
function getAllTasks($conn)
{
    $sql = "SELECT * FROM taches ORDER BY date_tache, heure_debut";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addTask($conn, $tache, $description, $heure_debut, $heure_fin, $date_tache)
{
    $sql = "INSERT INTO taches (tache, description, heure_debut, heure_fin, date_tache) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tache, $description, $heure_debut, $heure_fin, $date_tache]);
}

function getTaskById($conn, $id)
{
    $sql = "SELECT * FROM taches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateTask($conn, $id, $tache, $description, $heure_debut, $heure_fin, $date_tache)
{
    $sql = "UPDATE taches SET tache = ?, description = ?, heure_debut = ?, heure_fin = ?, date_tache = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tache, $description, $heure_debut, $heure_fin, $date_tache, $id]);
}

function deleteTask($conn, $id)
{
    $sql = "DELETE FROM taches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}