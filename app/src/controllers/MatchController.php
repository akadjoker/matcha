
<?php

require_once MODELS . 'LikeModel.php';
require_once MODELS . 'UserModel.php';

class MatchController
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) 
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $likeModel = new LikeModel();
        $matchIds = $likeModel->getMutualMatches($userId);
       // var_dump($matchIds);

        // Se não houver matches, retorna um array vazio
        $userModel = new UserModel();
        $matches = $userModel->getUsersByIds($matchIds);

        require_once VIEWS . 'match/index.php';
    }
}
