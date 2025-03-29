-- Utilizadores
CREATE TABLE utilizadores (
    id SERIAL PRIMARY KEY,
    nome_utilizador VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    palavra_passe VARCHAR(255) NOT NULL,
    primeiro_nome VARCHAR(100) NOT NULL,
    apelido VARCHAR(100) NOT NULL,
    genero VARCHAR(20),
    preferencia_sexual VARCHAR(20),
    biografia TEXT,
    data_nascimento DATE,
    ultima_ligacao TIMESTAMP,
    online BOOLEAN DEFAULT FALSE,
    pontuacao_fama INTEGER DEFAULT 0,
    verificado BOOLEAN DEFAULT FALSE,
    token_verificacao VARCHAR(255),
    token_recuperacao VARCHAR(255),
    latitude FLOAT,
    longitude FLOAT,
    nome_localizacao VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Imagens de perfil
CREATE TABLE imagens_perfil (
    id SERIAL PRIMARY KEY,
    id_utilizador INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    caminho_imagem VARCHAR(255) NOT NULL,
    perfil_principal BOOLEAN DEFAULT FALSE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Etiquetas/Interesses
CREATE TABLE etiquetas (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) UNIQUE NOT NULL
);

-- Relação utilizador-etiquetas
CREATE TABLE utilizador_etiquetas (
    id_utilizador INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    id_etiqueta INTEGER REFERENCES etiquetas(id) ON DELETE CASCADE,
    PRIMARY KEY (id_utilizador, id_etiqueta)
);

-- Gostos ("Likes")
CREATE TABLE gostos (
    id SERIAL PRIMARY KEY,
    id_gostador INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    id_gostado INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(id_gostador, id_gostado)
);

-- Visitas de perfil
CREATE TABLE visitas_perfil (
    id SERIAL PRIMARY KEY,
    id_visitante INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    id_visitado INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bloqueios
CREATE TABLE bloqueios (
    id SERIAL PRIMARY KEY,
    id_bloqueador INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    id_bloqueado INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(id_bloqueador, id_bloqueado)
);

-- Denúncias de contas falsas
CREATE TABLE denuncias (
    id SERIAL PRIMARY KEY,
    id_denunciante INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    id_denunciado INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    motivo TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Mensagens de chat
CREATE TABLE mensagens (
    id SERIAL PRIMARY KEY,
    id_remetente INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    id_destinatario INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    conteudo TEXT NOT NULL,
    lida BOOLEAN DEFAULT FALSE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Notificações
CREATE TABLE notificacoes (
    id SERIAL PRIMARY KEY,
    id_utilizador INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    tipo VARCHAR(50) NOT NULL, -- 'gosto', 'visita', 'mensagem', 'correspondencia', 'remover_gosto'
    id_origem INTEGER REFERENCES utilizadores(id) ON DELETE CASCADE,
    lida BOOLEAN DEFAULT FALSE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
