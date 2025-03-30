<?php
class BrowseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $filters = $_GET ?? [];

        $users = $this->userModel->searchUsers($_SESSION['user_id'], $_GET ?? []);

        require_once VIEWS . 'browse/index.php';
    }
}
