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
    <link rel="stylesheet" href="register.css">
    <title>Inscription</title>
</head>
<body>

    <div class="formContainer">
        <h2>Inscrivez-vous maintenant</h2>
        <form method="post">
            <input type="text" placeholder="Nom" name="nom" value="<?php echo htmlspecialchars($nom ?? ''); ?>">
            <?php if (isset($errors['nom'])): ?>
                <p><?php echo $errors['nom']; ?></p>
            <?php endif; ?>

            <input type="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
            <?php if (isset($errors['email'])): ?>
                <p><?php echo $errors['email']; ?></p>
            <?php endif; ?>

            <input type="password" name="password" placeholder="Mot de passe">
            <?php if (isset($errors['password'])): ?>
                <p><?php echo $errors['password']; ?></p>
            <?php endif; ?>

            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe">
            <?php if (isset($errors['confirm_password'])): ?>
                <p><?php echo $errors['confirm_password']; ?></p>
            <?php endif; ?>

            <?php if (isset($errors['passwordMatch'])): ?>
                <p><?php echo $errors['passwordMatch']; ?></p>
            <?php endif; ?>

            <button type="submit" name="submit">S'inscrire</button>
        </form>
        <a href="login.php">Vous avez déjà un compte ? Se connecter</a>
    </div>

</body>
</html>
