# Web Matcha - Projeto PHP

Este projeto é uma plataforma de encontros desenvolvida com PHP puro, PostgreSQL e Docker. Inclui funcionalidades como registo, login, perfis, likes, chat entre utilizadores e verificação por email.

---

## 📦 Stack Tecnológica

- PHP 8.2 (modo Apache)
- PostgreSQL 14
- MailHog (para simular envio de emails)
- pgAdmin (gestão da base de dados)
- Docker Compose

---

## ▶️ Como correr o projeto

### 1. Clonar o repositório

```bash
git clone <repo>
cd matcha
```

### 2. Construir e iniciar o ambiente

```bash
make setup
make up
```

A app ficará acessível em:  
👉 [`http://localhost:8000`](http://localhost:8000)

---

## 🛠️ Serviços disponíveis

| Serviço     | URL                        | Acesso                           |
|-------------|----------------------------|----------------------------------|
| App         | `http://localhost:8000`    | Interface do utilizador          |
| pgAdmin     | `http://localhost:8888`    | user: `admin@matcha.com`, pass: `admin123` |
| MailHog     | `http://localhost:8025`    | Visualização dos emails enviados |

---

## 📁 Estrutura do projeto

```
app/
├── public/             # Pasta pública (index.php, assets)
├── src/                # Código-fonte da app
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── config/
│   └── router.php
├── docker/             # Dockerfile, php.ini, init.sql
├── .env
├── Makefile
└── docker-compose.yml
```

---

## 🧪 Base de dados

A base de dados é inicializada automaticamente na primeira execução (`init.sql`) e fica persistente no volume `db_data`.

A tabela principal é:

- `users` – registo, login, avatar, token
- `messages` – envio de mensagens
- `likes` – relação entre utilizadores
- `tags`, `user_tags` – interesses

---

## 🧩 A fazer

- [ ] Sistema de registo com verificação por email
- [ ] Login e sessão
- [ ] Upload de imagem de perfil
- [ ] Like e Match
- [ ] Chat entre utilizadores
- [ ] Notificações básicas

---



## Tests
http://localhost:8000/test/TestEmail.php
http://localhost:8000/test/TestUpload.php
http://localhost:8000/test/TestBD.php

## 🧾 Licença

Este projeto foi criado para fins educativos (42 School).