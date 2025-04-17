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
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 0;
}

.formContainer {
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

input[type="text"], input[type="email"], input[type="password"] {
    box-sizing: border-box;
}

input:focus {
    border-color: #5c67f2;
    outline: none;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #5c67f2;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
}

button:hover {
    background-color: #4b54d8;
}

p {
    color: #ff4d4d;
    font-size: 14px;
    margin: 5px 0;
}

a {
    display: block;
    text-align: center;
    color: #5c67f2;
    margin-top: 20px;
    text-decoration: none;
    font-size: 14px;
}

a:hover {
    text-decoration: underline;
}
</style>
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
