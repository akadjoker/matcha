<?php require_once ROOT_PATH . '/views/templates/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="box">
                    <h1 class="title has-text-centered">Entrar</h1>
                    
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="notification is-danger">
                            <?php echo $_SESSION['login_error']; ?>
                            <?php unset($_SESSION['login_error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="notification is-success">
                            <?php echo $_SESSION['success_message']; ?>
                            <?php unset($_SESSION['success_message']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=login" method="POST">
                        <div class="field">
                            <label class="label">Nome de Utilizador ou Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="login" placeholder="Nome de utilizador ou email" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
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
                            <div class="control">
                                <button class="button is-primary is-fullwidth" type="submit">Entrar</button>
                            </div>
                        </div>
                    </form>
                    
                    <p class="has-text-centered mt-4">
                        Não tens uma conta? <a href="index.php?controller=auth&action=showRegister">Regista-te aqui</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once ROOT_PATH . '/views/templates/footer.php'; ?>