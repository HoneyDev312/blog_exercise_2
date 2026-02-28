<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id): ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article): void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article): void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation) VALUES (:id_user, :title, :content, NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article): void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticlesForMonitoring(): array
    {
        $sql = "SELECT a.id, a.title, a.content, a.date_creation, a.view_count, COUNT(c.id) AS comment_count 
        FROM article a
        LEFT JOIN comment c ON c.id_article = a.id
        GROUP BY a.id, a.title, a.content, a.date_creation
        ORDER BY a.id DESC";

        $result = $this->db->query($sql);

        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    /**
     * Tri les articles en fonction de l'id, du nombre de vue, du nombre de commentaire ou de la 
     * date de publication.
     * @param array $articles : liste d'article     
     * @param string $sort : orde de tri.
     * @return array : un tableau d'objets Article trié.
     */
    public function sortArticles(array $articles, string $sort, string $dir): array
    {
        usort($articles, function ($a, $b) use ($sort, $dir) {
            return match ($sort . "_" . $dir) {
                'id_desc' => $b->getId() <=> $a->getId(),
                'id_asc' => $a->getId() <=> $b->getId(),
                'view_desc' => $b->getViewCount() <=> $a->getViewCount(),
                'view_asc' => $a->getViewCount() <=> $b->getViewCount(),

                'comment_desc' => $b->getCommentCount() <=> $a->getCommentCount(),
                'comment_asc' => $a->getCommentCount() <=> $b->getCommentCount(),

                'date_desc' => $b->getDateCreation()->getTimestamp() <=> $a->getDateCreation()->getTimestamp(),
                'date_asc' => $a->getDateCreation()->getTimestamp() <=> $b->getDateCreation()->getTimestamp(),

                default => 0,
            };
        });

        return $articles;
    }
}
