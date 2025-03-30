<?php

class ProfileController
{
    private UserModel $userModel;
    private TagModel $tagModel;
    private LikeModel $likeModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->tagModel = new TagModel();
        $this->likeModel = new LikeModel();
    }

    public function index()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $user = $this->userModel->getById($_SESSION['user_id']);
        $tags = $this->tagModel->getTagsForUser($_SESSION['user_id']);
        $userTagsString = implode(' ', array_map(fn($t) => '#' . $t, $tags));

        require_once VIEWS . 'profile/index.php';
    }

    public function update()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $id = $_SESSION['user_id'];
        $bio = trim($_POST['bio'] ?? '');

        if (strlen($bio) > 500)
        {
            $_SESSION['error'] = 'A tua descrição (bio) é demasiado longa. Limite: 500 caracteres.';
            header("Location: index.php?controller=profile&action=index");
            exit;
        }

        // Avatar
        if (!empty($_FILES['avatar']['name']))
        {
            $avatarName = uniqid('avatar_') . '.' . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $targetDir = PUBLIC_PATH . '/uploads/';
            if (!is_dir($targetDir))
            {
                mkdir($targetDir, 0777, true);
            }
            move_uploaded_file($_FILES['avatar']['tmp_name'], $targetDir . $avatarName);
            $this->userModel->updateAvatar($id, $avatarName);
        }

        // Dados do perfil
        $this->userModel->updateFullProfile($id, [
            'firstname' => $_POST['firstname'] ?? null,
            'lastname' => $_POST['lastname'] ?? null,
            'gender' => $_POST['gender'] ?? null,
            'sexual_orientation' => $_POST['sexual_orientation'] ?? null,
            'birthdate' => $_POST['birthdate'] ?? null,
            'location' => $_POST['location'] ?? null,
            'bio' => $bio
        ]);

        // Tags
        $tagsRaw = trim($_POST['tags'] ?? '');
        $tags = array_filter(explode(' ', $tagsRaw), fn($tag) => !empty($tag));
        if (!empty($tags))
        {
            $cleanTags = array_unique(array_map(fn($t) => ltrim($t, '#'), $tags));
            $this->tagModel->updateUserTags($id, $cleanTags);
        }

        header("Location: index.php?controller=profile&action=index");
        exit;
    }
    public function view()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    
        if ($id <= 0 || $id === $_SESSION['user_id'])
        {
            $_SESSION['error'] = "Perfil inválido.";
            header("Location: index.php?controller=browse&action=index");
            exit;
        }
    
        $user = $this->userModel->getById($id);
        $tags = $this->tagModel->getTagsForUser($id);
    
        if (!$user)
        {
            $_SESSION['error'] = "Utilizador não encontrado.";
            header("Location: index.php?controller=browse&action=index");
            exit;
        }
    
        $hasLiked = $this->likeModel->alreadyLiked($_SESSION['user_id'], $id); // eu gostei dele
        $hasBeenLiked = $this->likeModel->alreadyLiked($id, $_SESSION['user_id']); // ele gostou de mim
        $isMatch = $hasLiked && $hasBeenLiked;
        
    
        // Marcar notificação de like como lida
        $notifModel = new NotificationModel();
        $notifModel->markAsReadFromUser($_SESSION['user_id'], $id, 'like');
    
        require_once VIEWS . 'profile/view.php';
    }
    

    public function like()
    {
        if (empty($_SESSION['user_id']))
        {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $likerId = $_SESSION['user_id'];
        $likedId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($likedId <= 0 || $likedId === $likerId)
        {
            $_SESSION['error'] = "Utilizador inválido.";
            header("Location: index.php?controller=browse&action=index");
            exit;
        }

        $this->likeModel->toggleLike($likerId, $likedId);

        header("Location: index.php?controller=profile&action=view&id=$likedId");
        exit;
    }
}
