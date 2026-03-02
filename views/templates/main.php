<?php

/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emilie Forteroche</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php
    $action = $_GET['action'] ?? 'home';
    ?>
    <header>
        <nav>
            <a href="index.php" class="<?= $action === 'home' ? 'active' : '' ?>">Articles</a>
            <a href="index.php?action=apropos" class="<?= $action === 'apropos' ? 'active' : '' ?>">À propos</a>

            <?php
            $isLoggedIn = isset($_SESSION['user']);
            $isAdmin = $isLoggedIn && (($_SESSION['roleUser'] ?? null) === 'admin');
            ?>

            <?php if (!$isLoggedIn): ?>
                <a href="index.php?action=admin" class="<?= $action === 'admin' ? 'active' : '' ?>">Connexion</a>
            <?php else: ?>
                <?php if ($isAdmin): ?>
                    <a href="index.php?action=admin" class="<?= $action === 'admin' ? 'active' : '' ?>">Admin</a>
                <?php endif; ?>
                <a href="index.php?action=disconnectUser">Déconnexion</a>
            <?php endif; ?>
        </nav>
        <div>
            <?php
            // Si on est connecté on affiche le mode admin
            if ($isAdmin) {
                echo '<h2>Mode Administrateur</h2>';
            }
            ?>
            <h1>Emilie Forteroche</h1>
        </div>


    </header>

    <main>
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer>
        <p>Copyright © Emilie Forteroche 2023 - Openclassrooms
    </footer>

</body>

</html>