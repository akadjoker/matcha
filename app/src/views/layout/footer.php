<footer class="footer has-text-light" style="background-color:rgb(29, 41, 39);">
    <div class="content has-text-centered">
        <p>
            <strong>Matcha</strong> &copy; <?= date('Y') ?>. Todos os direitos reservados.
        </p>
        <p>
            <a class="has-text-light" href="index.php?controller=contact&action=index">Contacto</a> |
            <a class="has-text-light" href="#">Sobre</a>
        </p>
    </div>
</footer>

</div> <!-- Fecha .container da section -->
</section>

<!-- Burger Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.navbar-burger');
    const menu = document.getElementById('navMenu');

    if (burger && menu) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    }
});
</script>
</body>
</html>
