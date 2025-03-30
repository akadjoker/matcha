<?php

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findByToken(string $token): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE token = :token LIMIT 1");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password, token, active, created_at)
            VALUES (:username, :email, :password, :token, FALSE, NOW())
        ");

        return $stmt->execute([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'token'    => $data['token']
        ]);
    }

    public function activateUser(string $token): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET active = TRUE, token = NULL WHERE token = :token");
        return $stmt->execute(['token' => $token]);
    }

    public function validateLogin(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password']) && $user['active'])
        {
            return $user;
        }

        return null;
    }

    //new 
    
   
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, avatar, bio FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, avatar, bio, firstname, lastname, gender, sexual_orientation, birthdate, location FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

public function updateFullProfile($id, $data)
{
    $stmt = $this->pdo->prepare("
        UPDATE users SET
            firstname = :firstname,
            lastname = :lastname,
            gender = :gender,
            sexual_orientation = :sexual_orientation,
            birthdate = :birthdate,
            location = :location,
            bio = :bio
        WHERE id = :id
    ");

    return $stmt->execute([
        'firstname' => $data['firstname'] ?? null,
        'lastname' => $data['lastname'] ?? null,
        'gender' => $data['gender'] ?? null,
        'sexual_orientation' => $data['sexual_orientation'] ?? null,
        'birthdate' => $data['birthdate'] ?? null,
        'location' => $data['location'] ?? null,
        'bio' => $data['bio'] ?? null,
        'id' => $id
    ]);
}

    
    //new 2 
    public function updateAvatar($id, $avatar)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->execute([$avatar, $id]);
        $_SESSION['avatar'] = $avatar;
    }

    public function updateBio($id, $bio)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
        $stmt->execute([$bio, $id]);
    }

    public function getUserTags($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT t.name
            FROM tags t
            JOIN user_tags ut ON ut.tag_id = t.id
            WHERE ut.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    public function updateUserTags($userId, $tags)
    {
        // Limpar tags antigas, muito IMPORTANTE BUG BUG BUG
        $this->pdo->prepare("DELETE FROM user_tags WHERE user_id = ?")->execute([$userId]);

        // Filtrar e limpar
        $tags = array_map(fn($t) => strtolower(trim($t)), $tags);
        $tags = array_filter($tags);                     // Remove vazios
        $tags = array_unique($tags);                     // Remove duplicados

        foreach ($tags as $tagName)
        {
            // 1. Criar tag se não existir
            $stmt = $this->pdo->prepare("INSERT INTO tags (name) VALUES (?) ON CONFLICT (name) DO NOTHING");
            $stmt->execute([$tagName]);

            // 2. Obter ID da tag
            $stmt = $this->pdo->prepare("SELECT id FROM tags WHERE name = ?");
            $stmt->execute([$tagName]);
            $tagId = $stmt->fetchColumn();

            // 3. Adicionar relação user ↔ tag (ignora conflito se já existir) BUG BUG ;)
            if ($tagId) 
            {
                $stmt = $this->pdo->prepare("
                    INSERT INTO user_tags (user_id, tag_id)
                    VALUES (?, ?)
                    ON CONFLICT DO NOTHING
                ");
                $stmt->execute([$userId, $tagId]);
            }
        }
    }

    //new
    public function searchUsers(int $excludeId, array $filters = []): array
    {
        $sql = "SELECT DISTINCT u.id, u.username, u.avatar, u.bio, u.birthdate, u.location
                FROM users u
                LEFT JOIN user_tags ut ON u.id = ut.user_id
                LEFT JOIN tags t ON t.id = ut.tag_id
                WHERE u.id != :id";
        $params = ['id' => $excludeId];
    
        // Género
        if (!empty($filters['gender'])) {
            $sql .= " AND u.gender = :gender";
            $params['gender'] = $filters['gender'];
        }
    
        // Orientação sexual
        if (!empty($filters['orientation'])) {
            $sql .= " AND u.sexual_orientation = :orientation";
            $params['orientation'] = $filters['orientation'];
        }
    
        // Localização
        if (!empty($filters['location'])) {
            $sql .= " AND u.location ILIKE :location";
            $params['location'] = '%' . $filters['location'] . '%';
        }
    
        // Idade mínima/máxima
        if (!empty($filters['min_age']) || !empty($filters['max_age'])) {
            $today = new DateTime();
            
            if (!empty($filters['min_age'])) {
                $minDate = $today->modify('-' . (int)$filters['min_age'] . ' years')->format('Y-m-d');
                $sql .= " AND u.birthdate <= :min_birthdate";
                $params['min_birthdate'] = $minDate;
                $today = new DateTime(); // reset
            }
    
            if (!empty($filters['max_age'])) {
                $maxDate = $today->modify('-' . (int)$filters['max_age'] . ' years')->format('Y-m-d');
                $sql .= " AND u.birthdate >= :max_birthdate";
                $params['max_birthdate'] = $maxDate;
            }
        }
    
        // Tags (interesses)
        if (!empty($filters['tags']) && is_array($filters['tags'])) {
            $placeholders = [];
            foreach ($filters['tags'] as $i => $tag) {
                $key = ":tag$i";
                $placeholders[] = $key;
                $params[$key] = $tag;
            }
            $sql .= " AND t.name IN (" . implode(',', $placeholders) . ")";
        }
    
        // ???ORDER BY futuro (score, etc.)
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    

    public function getAllTags(): array
    {
        $stmt = $this->pdo->query("SELECT name FROM tags ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


}
