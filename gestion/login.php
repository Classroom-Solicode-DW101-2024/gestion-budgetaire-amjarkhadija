<?php
session_start();
require 'config.php';
require 'user.php';

$errors = [];

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $errors['email'] = 'Veuillez entrer votre email';
    }

    if (empty($password)) {
        $errors['password'] = 'Veuillez entrer votre mot de passe';
    }

    if (empty($errors)) {
        $user = loginUser($email, $password, $pdo);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit();
        } else {
            $errors['login'] = 'Email ou mot de passe incorrect';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="formContainer">
        <h2>Login</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <p><?php echo $errors['email']; ?></p>
            <?php endif; ?>

            <input type="password" name="password" placeholder="Mot de passe">
            <?php if (isset($errors['password'])): ?>
                <p><?php echo $errors['password']; ?></p>
            <?php endif; ?>

            <?php if (isset($errors['login'])): ?>
                <p><?php echo $errors['login']; ?></p>
            <?php endif; ?>

            <button name="submit">Login</button>
        </form>
        <a href="register.php">Pas encore de compte ? S'inscrire</a>
    </div>
</body>
</html>
