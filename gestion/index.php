<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Gestion Budget</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #f1f1f1;
        }

        nav {
            background-color: #1f1f1f;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #f1f1f1;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #4CAF50;
        }

        .content {
            text-align: center;
            padding: 60px 20px;
        }

        .content img {
            max-width: 400px;
            width: 90%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 255, 100, 0.2);
        }

        .content p {
            font-size: 20px;
            margin-top: 25px;
        }

        /* Feature Cards Section */
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background-color: #1f1f1f;
            border-radius: 15px;
            padding: 30px 25px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-top: 3px solid #4CAF50;
            position: relative;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(76, 175, 80, 0.2);
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 20px;
            color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 50%;
            margin: 0 auto 25px;
        }

        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #ffffff;
        }

        .feature-card p {
            font-size: 16px;
            color: #cccccc;
            line-height: 1.6;
        }

        .cta-btn {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .cta-btn:hover {
            background-color: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .site-footer {
            background-color: #1f1f1f;
            color: #f1f1f1;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 40px;
        }

        .site-footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">Gestion Budget</div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="transactions.php">Transactions</a></li>
        <li><a href="register.php">Connexion</a></li>
    </ul>
</nav>

<div class="content">
    <img src="img/budget.png" alt="Image de budget">
    <h1>Maîtrisez votre budget, atteignez vos objectifs !</h1>
    <p>Avec notre application de gestion financière, suivez chaque euro dépensé ou gagné.</p>
    <p>Visualisez vos statistiques, planifiez mieux et vivez l'esprit tranquille.</p>
    
    <a href="register.php" class="cta-btn">Commencer maintenant</a>
</div>

<div class="features">
    <div class="feature-card">
        <div class="feature-icon">💰</div>
        <h3>Suivi des dépenses</h3>
        <p>Enregistrez facilement toutes vos dépenses quotidiennes et catégorisez-les pour un meilleur aperçu de vos habitudes financières.</p>
    </div>
    
    <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Analyse détaillée</h3>
        <p>Visualisez vos finances avec des graphiques clairs et des rapports détaillés pour comprendre où va votre argent.</p>
    </div>
    
    <div class="feature-card">
        <div class="feature-icon">🎯</div>
        <h3>Objectifs financiers</h3>
        <p>Définissez des objectifs d'épargne et suivez votre progression pour atteindre l'indépendance financière étape par étape.</p>
    </div>
    
    <div class="feature-card">
        <div class="feature-icon">🔔</div>
        <h3>Alertes personnalisées</h3>
        <p>Recevez des notifications pour les dépenses importantes, les factures à venir ou quand vous approchez de vos limites budgétaires.</p>
    </div>
</div>

<footer class="site-footer">
    <p>&copy; <?php echo date("Y"); ?> MonApp. Tous droits réservés.</p>
</footer>
</body>
</html>