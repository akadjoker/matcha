<?php

class BrowseController
{
    private UserModel $userModel;
    private LikeModel $likeModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->likeModel = new LikeModel();
    }

    public function index()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $filters = $_GET ?? [];

        $users = $this->userModel->searchUsers($userId, $filters);

        // Verificar se já foram gostados
        foreach ($users as &$user)
        {
            $user['already_liked'] = $this->likeModel->alreadyLiked($userId, $user['id']);
        }
        unset($user);

        require_once VIEWS . 'browse/index.php';
    }
}
