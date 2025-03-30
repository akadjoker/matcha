<?php require_once VIEWS . 'layout/header.php'; ?>

<section class="hero is-dark is-bold is-medium">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-vcentered">
                <div class="column is-6">
                    <h1 class="title is-1">
                        Encontra a tua correspondência perfeita
                    </h1>
                    <h2 class="subtitle is-4 has-text-light">
                        Porque o amor, também, pode ser industrializado.
                    </h2>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <div class="buttons mt-5">
                            <a href="index.php?controller=auth&action=showRegister" class="button is-primary is-inverted is-large">
                                <strong>Começar Agora</strong>
                            </a>
                            <a href="index.php?controller=auth&action=showLogin" class="button is-link is-light is-large">
                                Já tenho conta
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="buttons mt-5">
                            <a href="index.php?controller=browse&action=index" class="button is-success is-light is-large">
                                <strong>Explorar Perfis</strong>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="column is-6">
                    <figure class="image">
                    <img src="/images/2.jpeg" style="width: 600px; height: 400px;" alt="Placeholder 600x400 image">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section has-background-dark">
    <div class="container">
        <h2 class="title has-text-centered has-text-light mb-6">Como funciona</h2>
        
        <div class="columns is-multiline">
            <div class="column is-4">
            <div class="box has-text-centered has-background-black-ter has-text-light box-hover" style="height: 100%;">

                    <span class="icon is-large">
                        <i class="fas fa-user-plus fa-3x"></i>
                    </span>
                    <h3 class="title is-4 mt-4">Cria o teu perfil</h3>
                    <p class="has-text-grey-light">Adiciona as tuas melhores fotos e informações sobre ti</p>
                </div>
            </div>
            
            <div class="column is-4">
            <div class="box has-text-centered has-background-black-ter has-text-light box-hover" style="height: 100%;">

                    <span class="icon is-large">
                        <i class="fas fa-search fa-3x"></i>
                    </span>
                    <h3 class="title is-4 mt-4">Descobre pessoas</h3>
                    <p class="has-text-grey-light">Encontra pessoas com interesses semelhantes perto de ti</p>
                </div>
            </div>
            
            <div class="column is-4">
            <div class="box has-text-centered has-background-black-ter has-text-light box-hover" style="height: 100%;">

                    <span class="icon is-large">
                        <i class="fas fa-comments fa-3x"></i>
                    </span>
                    <h3 class="title is-4 mt-4">Conecta-te</h3>
                    <p class="has-text-grey-light">Conversa e conhece pessoas que partilham os teus interesses</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section has-background-dark">
    <div class="container">
        <h2 class="title has-text-centered mb-6">Porquê escolher o Web Matcha?</h2>
        
        <div class="columns">
            <div class="column is-6">
                <div class="content">
                    <ul>
                        <li><strong>Localização inteligente</strong> - Encontra pessoas perto de ti</li>
                        <li><strong>Correspondência por interesses</strong> - Conecta-te com pessoas que partilham os teus gostos</li>
                        <li><strong>Interface fácil de usar</strong> - Experiência simples e intuitiva</li>
                        <li><strong>Chat em tempo real</strong> - Comunica instantaneamente com os teus matches</li>
                        <li><strong>Notificações</strong> - Mantém-te informado sobre novas interações</li>
                    </ul>
                </div>
            </div>
            
            <div class="column is-6">
                <figure class="image">
                    <img src="/images/1.jpeg" style="width: 440px; height: 300px;" alt="Placeholder 600x300 image">
                </figure>
            </div>
        </div>
    </div>
</section>

<?php require_once VIEWS . 'layout/footer.php'; ?>
