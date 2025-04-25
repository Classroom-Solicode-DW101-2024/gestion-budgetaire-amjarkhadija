<?php
function addUser($user, $connection) {
    $nom = $user['nom'];
    $email = $user['email'];
    $password = $user['password'];

    $sql = "INSERT INTO users (nom, email, password) 
            VALUES (:nom, :email, :password)";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $_SESSION['user'] = $user;
    header('Location: index.php');
    exit();
}

function checkUser($email, $connection) {
    $email = htmlspecialchars($email);

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return !empty($user);
}

function loginUser($email, $password, $connection) {
    $email = htmlspecialchars($email);

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}
?>
