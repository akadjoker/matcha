## 🔐 Segurança e Estrutura do UserModel

Esta secção documenta a classe `UserModel`, que é responsável por toda a gestão de utilizadores no projeto.

---

### ✅ Funcionalidades

| Método                  | Descrição                                            |
|-------------------------|------------------------------------------------------|
| `__construct()`         | Liga à base de dados usando PDO                      |
| `findByEmail()`         | Procura utilizador pelo email                        |
| `findByUsername()`      | Procura utilizador pelo nome de utilizador           |
| `findByToken()`         | Procura utilizador pelo token de ativação            |
| `create()`              | Cria um novo utilizador (com hash de password)       |
| `activateUser()`        | Ativa a conta do utilizador após validação por token |
| `validateLogin()`       | Valida login com verificação de password e estado    |

---

### 🔐 Segurança

#### 1. SQL Injection

Todas as queries usam `prepare()` e `execute()`, protegendo contra SQL Injection:
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
```

#### 2. Hash de Passwords

As passwords são encriptadas com `password_hash()`:
```php
password_hash($data['password'], PASSWORD_DEFAULT);
```
E verificadas com:
```php
password_verify($password, $user['password']);
```

#### 3. Validação de Login

Só é possível iniciar sessão se:
- A conta existir
- A password for correta
- A conta estiver ativa (email verificado)

#### 4. Ativação com Token

O utilizador recebe um `token` por email no registo. A conta só fica ativa após validação:
```php
UPDATE users SET active = TRUE, token = NULL WHERE token = :token
```

---

### ⚠️ A melhorar futuramente

| Funcionalidade         | Motivo                                |
|------------------------|----------------------------------------|
| Validação de inputs    | Será tratada no controlador            |
| Rate limiting          | Pode ser adicionado contra brute-force |
| Logs de acesso         | Extensível para auditoria              |

---

A classe `UserModel` está preparada para produção com foco em segurança, clareza e boas práticas.
