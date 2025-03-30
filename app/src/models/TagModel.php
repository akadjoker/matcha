<?php

class TagModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();

    }

    public function getTagsForUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT t.name FROM tags t INNER JOIN user_tags ut ON t.id = ut.tag_id WHERE ut.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function updateUserTags($userId, $tags)
    {
        // limpamos tags antigas
        $this->pdo->prepare("DELETE FROM user_tags WHERE user_id = ?")->execute([$userId]);

        foreach ($tags as $tagName)
        {
            // add tag se não existir
            $stmt = $this->pdo->prepare("INSERT INTO tags (name) VALUES (?) ON CONFLICT (name) DO NOTHING");
            $stmt->execute([$tagName]);

            // get o ID da tag
            $stmt = $this->pdo->prepare("SELECT id FROM tags WHERE name = ?");
            $stmt->execute([$tagName]);
            $tagId = $stmt->fetchColumn();

            // add relação
            $stmt = $this->pdo->prepare("INSERT INTO user_tags (user_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$userId, $tagId]);
        }
    }
}
