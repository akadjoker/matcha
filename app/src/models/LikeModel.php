<?php

 
require_once CONFIG . 'database.php';

class LikeModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

 
    public function getLikesGivenByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT liked_id FROM likes WHERE liker_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

 
    public function getLikesReceivedByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT liker_id FROM likes WHERE liked_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

   
    public function getMutualMatches(int $userId): array
    {
        $likesGiven = $this->getLikesGivenByUser($userId);
       // echo 'likesGiven: ';
       // var_dump($likesGiven);
        $likesReceived = $this->getLikesReceivedByUser($userId);
      //  echo '              likesReceived: ';
      //  var_dump($likesReceived);

        // Interseção dos dois arrays: só os que estão em ambos os arrays são matches
        return array_intersect($likesGiven, $likesReceived);
    }
    public function getUsersWhoLikedMe(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT u.id, u.username, u.avatar
            FROM likes l
            JOIN users u ON l.liker_id = u.id
            WHERE l.liked_id = :id
        ");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchAll();
    }
    public function alreadyLiked(int $likerId, int $likedId): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT 1 FROM likes
            WHERE liker_id = :liker AND liked_id = :liked
            LIMIT 1
        ");
        $stmt->execute([
            'liker' => $likerId,
            'liked' => $likedId
        ]);
        return (bool) $stmt->fetchColumn();
    }
    public function toggleLike(int $likerId, int $likedId): void
    {
        if ($this->alreadyLiked($likerId, $likedId))
        {
            // Já existe like , remover
            $stmt = $this->pdo->prepare("
                DELETE FROM likes
                WHERE liker_id = :liker AND liked_id = :liked
            ");
            $stmt->execute([
                'liker' => $likerId,
                'liked' => $likedId
            ]);
        }
        else
        {
            // Novo like — inserir
            $stmt = $this->pdo->prepare("
                INSERT INTO likes (liker_id, liked_id)
                VALUES (:liker, :liked)
            ");
            $stmt->execute([
                'liker' => $likerId,
                'liked' => $likedId
            ]);
    
            // Inserir notificação só agora
            $stmtNotif = $this->pdo->prepare("
                INSERT INTO notifications (user_id, sender_id, type)
                VALUES (:receiver, :sender, 'like')
            ");
            $stmtNotif->execute([
                'receiver' => $likedId,
                'sender' => $likerId
            ]);
        }
    }
    
}