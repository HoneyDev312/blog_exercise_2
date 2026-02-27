<?php

/** 
 * Affichage de la partie informations par article : liste des articles avec le titre, le nombre de * vues, le nombre de commentaires et la date de publication pour chacun. 
 */
?>

<h2>Monitorer les articles</h2>
<form method="get" action="index.php">
    <input type="hidden" name="action" value="showMonitoring">

    <label for="sort">Trier par :</label>
    <select id="sort" name="sort">
        <option value="id_desc">Titre (récent → ancien)</option>
        <option value="id_asc">Titre (ancien → récent)</option>
        <option value="views_desc">Vues (plus → moins)</option>
        <option value="views_asc">Vues (moins → plus)</option>
        <option value="comments_desc">Vues (plus → moins)</option>
        <option value="comments_asc">Vues (moins → plus)</option>
        <option value="date_desc">Date (récent → ancien)</option>
        <option value="date_asc">Date (ancien → récent)</option>
    </select>
    <button class="submit" type="submit">Appliquer</button>
</form>
<div class="adminMonitoring">
    <div class="monitoringLine">
        <div class="title">Titre</div>
        <div class="content">Nombre de vue</div>
        <div class="content">Nombre de commentaire</div>
        <div class="content">Date de publication</div>

    </div>
    <?php foreach ($articles as $article) { ?>
        <div class="monitoringLine">
            <div class="title"><?= $article->getTitle() ?></div>
            <div class="content"><?= $article->getViewCount() ?></div>
            <div class="content"><?= $article->getCommentCount() ?></div>
            <div class="content"><?= $article->getDateCreation()->format('d/m/Y') ?></div>

        </div>
    <?php } ?>
</div>

<a class="submit" href="index.php?action=admin">Retour à la page précedente</a>