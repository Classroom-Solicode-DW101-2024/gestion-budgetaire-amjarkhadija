<?php 
require 'config.php';
include 'user.php';

$errors = [];

if (isset($_POST['submit'])){
    $nom= $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_Password = $_POST['confirm_password'];

    if (empty($nom)){
        $errors['nom'] = 'Veuillez entrer votre nom';
    }

    if (empty($email)){
        $errors['email'] = 'Veuillez entrer votre email';
    } else {
        $emailExists = checkUser($email, $pdo);
        if ($emailExists) {
            $errors['email'] = 'Cet email est déjà utilisé. Veuillez en choisir un autre.';
        }
    }

    if (empty($password)){
        $errors['password'] = 'Veuillez entrer votre mot de passe';
    }

    if (empty($confirm_Password)){
        $errors['confirm_password'] = 'Veuillez confirmer votre mot de passe';
    }

    if (!empty($password) && !empty($confirm_Password) && $password !== $confirm_Password){
        $errors['passwordMatch'] = 'Les mots de passe ne correspondent pas';
    }

    if (empty($errors)) {
        $user = [
            'nom' => htmlspecialchars($nom),
            'email' => htmlspecialchars($email),
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        addUser($user, $pdo);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/register.css">
    <title>Inscription</title>
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
        <h2>Inscrivez-vous maintenant</h2>
        <form method="post">

            <input type="text" placeholder="Nom" name="nom" id="nom" value="<?php echo isset($nom) ? htmlspecialchars($nom) : ''; ?>">
            <?php if (isset($errors['nom'])): ?>
                <p><?php echo $errors['nom']; ?></p>
            <?php endif; ?>

            <input type="email" placeholder="Email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <p><?php echo $errors['email']; ?></p>
            <?php endif; ?>

            <input type="password" name="password" id="registerPassword" placeholder="Mot de passe" >
            <?php if (isset($errors['password'])): ?>
                <p><?php echo $errors['password']; ?></p>
            <?php endif; ?>

            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmer le mot de passe">
            <?php if (isset($errors['confirm_password'])): ?>
                <p><?php echo $errors['confirm_password']; ?></p>
            <?php endif; ?>

            <?php if (isset($errors['passwordMatch'])): ?>
                <p><?php echo $errors['passwordMatch']; ?></p>
            <?php endif; ?>

            <button name="submit">S'inscrire</button>
        </form>
        <a href="login.php">Vous avez déjà un compte ? Se connecter</a>
    </div>
    
</body>
</html>
