<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$username = ;
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $sql = "SELECT * FROM utilisateurs WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'username' => $_POST['username']
        ]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO utilisateurs (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$username, $hashed_password])) {
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header('Location: login.php');
                exit();
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Inscription</h1>
        <?php if (isset($error)) : ?>
        <div class="notification error"><?= $error ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </div>
</body>

</html>