<?php

class NotificationModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function countUnread(int $userId): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM notifications
            WHERE user_id = :user AND is_read = FALSE
        ");
        $stmt->execute(['user' => $userId]);
        return (int)$stmt->fetchColumn();
    }

    public function markAllAsRead(int $userId): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE notifications SET is_read = TRUE
            WHERE user_id = :user AND is_read = FALSE
        ");
        $stmt->execute(['user' => $userId]);
    }

    public function getUnreadNotifications(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM notifications
            WHERE user_id = :user AND is_read = FALSE
            ORDER BY created_at DESC
        ");
        $stmt->execute(['user' => $userId]);
        return $stmt->fetchAll();
    }
    public function markAsReadFromUser(int $receiverId, int $senderId, string $type): void
{
    $stmt = $this->pdo->prepare("
        UPDATE notifications
        SET is_read = TRUE
        WHERE user_id = :receiver AND sender_id = :sender AND type = :type AND is_read = FALSE
    ");
    $stmt->execute([
        'receiver' => $receiverId,
        'sender' => $senderId,
        'type'    => $type
    ]);
}

}
