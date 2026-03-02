<?php

class CommentController
{
    /**
     * Ajoute un commentaire.
     * @return void
     */
    public function addComment(): void
    {
        // Récupération des données du formulaire.
        $pseudo = Utils::request("pseudo");
        $content = Utils::request("content");
        $idArticle = Utils::request("idArticle");

        // On vérifie que les données sont valides.
        if (empty($pseudo) || empty($content) || empty($idArticle)) {
            throw new Exception("Tous les champs sont obligatoires. 3");
        }

        // On vérifie que l'article existe.
        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($idArticle);

        if (!$article) {
            throw new Exception("L'article demandé n'existe pas.");
        }

        // On crée l'objet Comment.
        $comment = new Comment([
            'pseudo' => $pseudo,
            'content' => $content,
            'idArticle' => $idArticle
        ]);

        // On ajoute le commentaire.
        $commentManager = new CommentManager();
        $result = $commentManager->addComment($comment);

        // On vérifie que l'ajout a bien fonctionné.
        if (!$result) {
            throw new Exception("Une erreur est survenue lors de l'ajout du commentaire.");
        }

        // On redirige vers la page de l'article.
        Utils::redirect("showArticle", ['id' => $idArticle]);
    }

    /**
     * Ajoute un commentaire.
     * @return void
     */
    public function deleteComment(): void
    {
        // Récupération des données du formulaire.
        $comment_id = Utils::request("idComment");
        $idArticle = Utils::request("idArticle");

        // On efface le commentaire.
        $commentManager = new CommentManager();
        $result = $commentManager->deleteComment($comment_id);

        // On vérifie que l'ajout a bien fonctionné.
        if (!$result) {
            throw new Exception("Une erreur est survenue lors de la suppression du commentaire.");
        }

        // On redirige vers la page de l'article.
        Utils::redirect("showArticle", ['id' => $idArticle]);
    }
}
