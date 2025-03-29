<footer class="footer">
        <div class="content has-text-centered">
            <p>
                <strong>Web Matcha</strong> - Porque o amor, também, pode ser industrializado.
                <br>
                &copy; <?php echo date('Y'); ?> Web Matcha
            </p>
        </div>
    </footer>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => 
    {
        // Função para o burger menu em telas pequenas
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
        
        if ($navbarBurgers.length > 0) 
        {
            $navbarBurgers.forEach(el => 
            {
                el.addEventListener('click', () => 
                {
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);
                    
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');
                });
            });
        }
        
        // Auto-fechar notificações após 5 segundos
        const $notifications = document.querySelectorAll('.notification');
        $notifications.forEach($notification => 
        {
            setTimeout(() => 
            {
                $notification.style.display = 'none';
            }, 5000);
        });
    });
    </script>
</body>
</html>