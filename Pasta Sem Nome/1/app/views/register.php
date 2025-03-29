<?php require_once ROOT_PATH . '/views/templates/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="box">
                    <h1 class="title has-text-centered">Registo</h1>
                    
                    <?php if (isset($_SESSION['register_errors'])): ?>
                        <div class="notification is-danger">
                            <ul>
                                <?php foreach ($_SESSION['register_errors'] as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['register_errors']); ?>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=register" method="POST">
                        <div class="field">
                            <label class="label">Nome de Utilizador</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="username" placeholder="Nome de utilizador" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="email" name="email" placeholder="Email" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Primeiro Nome</label>
                                    <div class="control">
                                        <input class="input" type="text" name="first_name" placeholder="Primeiro nome" required>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Apelido</label>
                                    <div class="control">
                                        <input class="input" type="text" name="last_name" placeholder="Apelido" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Palavra-passe</label>
                            <div class="control has-icons-left">
                                <input class="input" type="password" name="password" placeholder="Palavra-passe" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Confirmar Palavra-passe</label>
                            <div class="control has-icons-left">
                                <input class="input" type="password" name="confirm_password" placeholder="Confirmar palavra-passe" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button class="button is-primary is-fullwidth" type="submit">Registar</button>
                            </div>
                        </div>
                    </form>
                    
                    <p class="has-text-centered mt-4">
                        Já tens uma conta? <a href="index.php?controller=auth&action=showLogin">Entra aqui</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once ROOT_PATH . '/views/templates/footer.php'; ?>