<?php
session_start();
if (!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user']['id'];
$pdo = new PDO("mysql:host=localhost;dbname=gestion_budget", "root", "");


$selectedYear = $_GET['year'] ?? null;
$selectedMonth = $_GET['month'] ?? null;


$whereClause = "t.user_id = :userId";
$params = [':userId' => $userId];

if ($selectedYear && $selectedMonth) {
    $whereClause .= " AND YEAR(t.date_transaction) = :year AND MONTH(t.date_transaction) = :month";
    $params[':year'] = $selectedYear;
    $params[':month'] = $selectedMonth;
}

function getTotal($pdo, $userId, $type, $whereClause, $params) {
    $sql = "
        SELECT SUM(t.montant) AS total 
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE $whereClause AND c.type = :type
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($params, [':type' => $type]));
    return $stmt->fetchColumn() ?: 0;
}

function getRecentTransactions($pdo, $whereClause, $params) {
    $sql = "
        SELECT t.*, c.nom AS categorie, c.type 
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE $whereClause
        ORDER BY t.date_transaction DESC
        LIMIT 5
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$totalRevenu = getTotal($pdo, $userId, 'revenu', $whereClause, $params);
$totalDepense = getTotal($pdo, $userId, 'depense', $whereClause, $params);
$solde = $totalRevenu - $totalDepense;
$recentTransactions = getRecentTransactions($pdo, $whereClause, $params);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestion Budget</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <h1>Dashboard Financier</h1>

   
    <form method="get" style="margin-bottom: 20px;">
        <label>Année:
            <select name="year">
                <option value="">-- Tous --</option>
                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                    <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </label>

        <label>Mois:
            <select name="month">
                <option value="">-- Tous --</option>
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= sprintf("%02d", $m) ?>" <?= $selectedMonth == sprintf("%02d", $m) ? 'selected' : '' ?>>
                        <?= date("F", mktime(0, 0, 0, $m, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </label>

        <button type="submit">Filtrer</button>
    </form>

    
    <div style="display:flex; gap:20px;">
        <div style="padding:20px; background:#e0ffe0; border-radius:10px;">
            <h3>Total Revenus</h3>
            <p><?= number_format($totalRevenu, 2) ?> €</p>
        </div>
        <div style="padding:20px; background:#ffe0e0; border-radius:10px;">
            <h3>Total Dépenses</h3>
            <p><?= number_format($totalDepense, 2) ?> €</p>
        </div>
        <div style="padding:20px; background:#e0e0ff; border-radius:10px;">
            <h3>Solde</h3>
            <p><strong><?= number_format($solde, 2) ?> €</strong></p>
        </div>
    </div>

    <h2>Dernières Transactions</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Type</th>
            <th>Catégorie</th>
            <th>Montant</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
        <?php foreach ($recentTransactions as $t): ?>
            <tr>
                <td><?= $t['type'] == 'revenu' ? 'Revenu' : 'Dépense' ?></td>
                <td><?= htmlspecialchars($t['categorie']) ?></td>
                <td><?= number_format($t['montant'], 2) ?> €</td>
                <td><?= htmlspecialchars($t['description']) ?></td>
                <td><?= $t['date_transaction'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <footer class="site-footer">
        <p>&copy; <?= date("Y") ?> MonApp. Tous droits réservés.</p>
    </footer>
</body>
</html>
