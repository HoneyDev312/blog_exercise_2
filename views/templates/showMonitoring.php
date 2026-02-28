<?php

/** 
 * Affichage de la partie informations par article : liste des articles avec le titre, le nombre de * vues, le nombre de commentaires et la date de publication pour chacun. 
 */

$currentSort = $_SESSION["sort"];
$currentDir = $_SESSION["dir"];

function nextDir(string $currentSort, string $col, string $currentDir): string
{
    return ($currentSort === $col && $currentDir === 'asc') ? 'desc' : 'asc';
}
function arrow(string $currentSort, string $col, string $currentDir): string
{
    if ($currentSort !== $col) return '↕';
    return $currentDir === 'asc' ? '↑' : '↓';
}

?>

<h2>Monitorer les articles</h2>
<div class="adminMonitoring">
    <div class="monitoringLine">
        <div class="title">
            <?php
            echo '<a href="index.php?action=showMonitoring&sort=id&dir=' . nextDir($sort, 'id', $dir) . '">';
            echo 'Titre ' . arrow($sort, 'id', $dir);
            echo '</a>';
            ?>
        </div>
        <div class="content view">
            <?php
            echo '<a href="index.php?action=showMonitoring&sort=view&dir=' . nextDir($sort, 'view', $dir) . '">';
            echo 'Vues ' . arrow($sort, 'view', $dir);
            echo '</a>';
            ?>
        </div>
        <div class="content comment">
            <?php
            echo '<a href="index.php?action=showMonitoring&sort=comment&dir=' . nextDir($sort, 'comment', $dir) . '">';
            echo 'Commentaires ' . arrow($sort, 'comment', $dir);
            echo '</a>';
            ?>
        </div>
        <div class="content date">
            <?php
            echo '<a href="index.php?action=showMonitoring&sort=date&dir=' . nextDir($sort, 'date', $dir) . '">';
            echo 'Date de Publication ' . arrow($sort, 'date', $dir);
            echo '</a>';
            ?></div>

    </div>
    <?php foreach ($articles as $article) { ?>
        <div class="monitoringLine">
            <div class="title"><?= $article->getTitle() ?></div>
            <div class="content view"><?= $article->getViewCount() ?></div>
            <div class="content comment"><?= $article->getCommentCount() ?></div>
            <div class="content date"><?= $article->getDateCreation()->format('d/m/Y') ?></div>

        </div>
    <?php } ?>
</div>

<a class="submit" href="index.php?action=admin">Retour à la page précedente</a>