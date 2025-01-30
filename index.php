<?php
include 'db.php';
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des tâches</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Gestion des tâches</h1>

        <form action="add_task.php" method="POST">
            <label for="tache">Tâche :</label>
            <input type="text" name="tache" id="tache" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description"></textarea>

            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" id="heure_debut" required>

            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" required>

            <label for="date_tache">Date :</label>
            <input type="date" name="date_tache" id="date_tache" required>

            <button type="submit">Ajouter</button>
        </form>

        <h2>Liste des tâches</h2>
        <table>
            <thead>
                <tr>
                    <th>Tâche</th>
                    <th>Description</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $taches = getAllTasks($conn);
                foreach ($taches as $tache) {
                    echo "<tr>
                            <td>{$tache['tache']}</td>
                            <td>{$tache['description']}</td>
                            <td>{$tache['heure_debut']}</td>
                            <td>{$tache['heure_fin']}</td>
                            <td>{$tache['date_tache']}</td>
                            <td>
                                <a href='edit_task.php?id={$tache['id']}'>Modifier</a>
                                <a href='delete_task.php?id={$tache['id']}' onclick='return confirm(\"Êtes-vous sûr ?\")'>Supprimer</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>