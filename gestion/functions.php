<?php
function getCategories($pdo) {
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
?>
