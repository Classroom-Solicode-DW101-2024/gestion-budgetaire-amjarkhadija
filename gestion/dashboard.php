
<?php
session_start();
if (!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user']['id'];
$pdo = new PDO("mysql:host=localhost;dbname=gestion_budget", "root", "");


function getTotal($pdo, $userId, $type) {
    $sql = "
        SELECT SUM(t.montant) AS total 
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :userId AND c.type = :type
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':userId' => $userId, ':type' => $type]);
    return $stmt->fetchColumn() ?: 0;
}


function getRecentTransactions($pdo, $userId) {
    $sql = "
        SELECT t.*, c.nom AS categorie, c.type 
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = :userId
        ORDER BY t.date_transaction DESC
       
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$totalRevenu = getTotal($pdo, $userId, 'revenu');
$totalDepense = getTotal($pdo, $userId, 'depense');
$solde = $totalRevenu - $totalDepense;
$recentTransactions = getRecentTransactions($pdo, $userId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financier</title>
   <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <h1>Dashboard Financier</h1>
        <p class="subtitle">Visualisez et gérez vos finances avec facilité</p>
    </header>

    <div class="container">
        <div class="cards-container">
            <div class="card revenu">
                <i class="fas fa-arrow-circle-up"></i>
                <h3>Total Revenus</h3>
                <p><?= number_format($totalRevenu, 2, ',', ' ') ?> €</p>
            </div>
            <div class="card depense">
                <i class="fas fa-arrow-circle-down"></i>
                <h3>Total Dépenses</h3>
                <p><?= number_format($totalDepense, 2, ',', ' ') ?> €</p>
            </div>
            <div class="card solde">
                <i class="fas fa-wallet"></i>
                <h3>Solde</h3>
                <p><?= number_format($solde, 2, ',', ' ') ?> €</p>
            </div>
        </div>

        <div class="section-header">
            <h2>Dernières Transactions</h2>
            <a href="transactions.php" class="view-all">Voir tout <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="transactions-container">
            <?php if (empty($recentTransactions)): ?>
                <div class="empty-state">
                    <i class="fas fa-receipt" style="font-size: 32px; margin-bottom: 10px;"></i>
                    <p>Aucune transaction récente à afficher</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Catégorie</th>
                            <th>Montant</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransactions as $t): ?>
                            <tr>
                                <td>
                                    <span class="badge <?= $t['type'] == 'revenu' ? 'badge-revenu' : 'badge-depense' ?>">
                                        <?= $t['type'] == 'revenu' ? 'Revenu' : 'Dépense' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="category-tag">
                                        <?php
                                        $icon = '';
                                        switch (strtolower($t['categorie'])) {
                                            case 'alimentation':
                                                $icon = 'fa-utensils';
                                                break;
                                            case 'transport':
                                                $icon = 'fa-car';
                                                break;
                                            case 'logement':
                                                $icon = 'fa-home';
                                                break;
                                            case 'loisirs':
                                                $icon = 'fa-gamepad';
                                                break;
                                            case 'salaire':
                                                $icon = 'fa-money-bill-wave';
                                                break;
                                            default:
                                                $icon = 'fa-tag';
                                        }
                                        ?>
                                        <i class="fas <?= $icon ?>"></i>
                                        <?= htmlspecialchars($t['categorie']) ?>
                                    </span>
                                </td>
                                <td class="amount-<?= $t['type'] ?>">
                                    <?= $t['type'] == 'revenu' ? '+' : '-' ?><?= number_format($t['montant'], 2, ',', ' ') ?> €
                                </td>
                                <td><?= htmlspecialchars($t['description']) ?></td>
                                <td class="date-column">
                                    <?php
                                    $date = new DateTime($t['date_transaction']);
                                    echo $date->format('d/m/Y');
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <p>© <?= date('Y') ?> - Gestion de Budget Personnel</p>
    </footer>
</body>
</html>
