<?php

require_once MODELS . 'UserModel.php';

class SearchController
{
    public function index()
    {
        if (empty($_SESSION['user_id']))
        {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $filters = [];

        if (!empty($_GET['gender'])) {
            $filters['gender'] = $_GET['gender'];
        }

        if (!empty($_GET['orientation'])) {
            $filters['orientation'] = $_GET['orientation'];
        }

        if (!empty($_GET['location'])) {
            $filters['location'] = $_GET['location'];
        }

        if (!empty($_GET['min_age'])) {
            $filters['min_age'] = (int) $_GET['min_age'];
        }

        if (!empty($_GET['max_age'])) {
            $filters['max_age'] = (int) $_GET['max_age'];
        }

        if (!empty($_GET['tags']) && is_array($_GET['tags'])) {
            $filters['tags'] = array_map('trim', $_GET['tags']);
        }

        $model = new UserModel();
        $users = $model->searchUsers($userId, $filters);
        $tags = $model->getAllTags();
        
        include VIEWS . 'search/index.php';
        
    }
}
