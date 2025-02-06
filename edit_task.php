<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// Pour afficher les informations de la tache avec id 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // 1 ere etape
    $sql = "SELECT * FROM taches WHERE id = ?";
    // 2 ieme etape 
    $stmt = $conn->prepare($sql);
    // 3 ieme etape
    $stmt->execute([$id]);
    $tache = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = htmlspecialchars($_POST['id']);
    $tache = htmlspecialchars($_POST['tache']);
    $description = htmlspecialchars($_POST['description']);
    $heure_debut = htmlspecialchars($_POST['heure_debut']);
    $heure_fin = htmlspecialchars($_POST['heure_fin']);
    $date_tache = htmlspecialchars($_POST['date_tache']);
    // 1 ere etape
    $sql = "UPDATE taches SET tache = ?, description = ?, heure_debut = ?, heure_fin = ?, date_tache = ? WHERE id = ?";
    // 2 ieme etape
    $stmt = $conn->prepare($sql);
    // 3 ieme etape
    if ($stmt->execute([$tache, $description, $heure_debut, $heure_fin, $date_tache, $id])) {
        $_SESSION['message'] = "Tâche mise à jour avec succès !";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de la tâche.";
    }
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la tâche</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Modifier la tâche</h1>
        <form action="edit_task.php" method="POST">
            <input type="hidden" name="id" value="<?= $tache['id'] ?>">

            <label for="tache">Tâche :</label>
            <input type="text" name="tache" id="tache" value="<?= $tache['tache'] ?>" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description"><?= $tache['description'] ?></textarea>

            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" id="heure_debut" value="<?= $tache['heure_debut'] ?>" required>

            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" value="<?= $tache['heure_fin'] ?>" required>

            <label for="date_tache">Date :</label>
            <input type="date" name="date_tache" id="date_tache" value="<?= $tache['date_tache'] ?>" required>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</body>

</html>