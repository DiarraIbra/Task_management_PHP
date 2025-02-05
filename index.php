<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalTasks = $conn->query("SELECT COUNT(*) FROM taches")->fetchColumn();
$totalPages = ceil($totalTasks / $limit);

$sql = "SELECT * FROM taches ORDER BY date_tache, heure_debut LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <a href="logout.php" style="float: right; margin: 10px;">Déconnexion</a>
        <h1>Gestion des tâches</h1>

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="notification success"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])) : ?>
            <div class="notification error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

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
                <?php foreach ($taches as $tache) : ?>
                    <tr>
                        <td><?= htmlspecialchars($tache['tache']) ?></td>
                        <td><?= htmlspecialchars($tache['description']) ?></td>
                        <td><?= htmlspecialchars($tache['heure_debut']) ?></td>
                        <td><?= htmlspecialchars($tache['heure_fin']) ?></td>
                        <td><?= htmlspecialchars($tache['date_tache']) ?></td>
                        <td>
                            <a href='edit_task.php?id=<?= $tache['id'] ?>'>Modifier</a>
                            <a href='delete_task.php?id=<?= $tache['id'] ?>'
                                onclick='return confirm("Êtes-vous sûr ?")'>Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="?page=<?= $i ?>" class="<?= $page === $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
</body>

</html>