<?php
function getCategories() {
    return [
        'revenu' => ['Salaire', 'Bourse', 'Ventes', 'Autres'],
        'depense' => ['Logement', 'Transport', 'Alimentation', 'Santé', 'Divertissement', 'Éducation', 'Autres']
    ];
}

function getCategoryId($pdo, $name, $type) {
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE nom = ? AND type = ?");
    $stmt->execute([$name, $type]);
    $category = $stmt->fetch();
    
    if ($category) return $category['id'];

    $stmt = $pdo->prepare("INSERT INTO categories (nom, type) VALUES (?, ?)");
    $stmt->execute([$name, $type]);
    return $pdo->lastInsertId();
}

// function addtransaction
function addTransaction($pdo, $userId, $categoryName, $categoryType, $amount, $description, $date) {
    $categoryId = getCategoryId($pdo, $categoryName, $categoryType);
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, category_id, montant, description, date_transaction) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $categoryId, $amount, $description, $date]);
}

function getTransactionById($pdo, $id, $userId) {
    $stmt = $pdo->prepare("SELECT t.*, c.nom AS categorie_nom, c.type AS categorie_type 
                           FROM transactions t 
                           JOIN categories c ON t.category_id = c.id 
                           WHERE t.id = ? AND t.user_id = ?");
    $stmt->execute([$id, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// function for modiffer
function updateTransaction($pdo, $id, $userId, $categoryName, $categoryType, $amount, $description, $date) {
    $categoryId = getCategoryId($pdo, $categoryName, $categoryType);
    $stmt = $pdo->prepare("UPDATE transactions 
                           SET category_id = ?, montant = ?, description = ?, date_transaction = ? 
                           WHERE id = ? AND user_id = ?");
    $stmt->execute([$categoryId, $amount, $description, $date, $id, $userId]);
}

// function for delet
function deleteTransaction($pdo, $id, $userId) {
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $userId]);
}

?>
