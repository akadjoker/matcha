<?php

class LikeController
{
    public function received()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $likeModel = new LikeModel();
        $userModel = new UserModel();

        $likers = $likeModel->getUsersWhoLikedMe($_SESSION['user_id']);
        $alreadyLiked = $likeModel->getLikesGivenByUser($_SESSION['user_id']);

        // Removemos os que já devolvemos like (já são match)
        $filtered = array_filter($likers, fn($u) => !in_array($u['id'], $alreadyLiked));

        // $notifModel = new NotificationModel();
        // $notifModel->markAllAsRead($_SESSION['user_id']);

        require_once VIEWS . 'likes/received.php';
    }

 

}
