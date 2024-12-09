<nav class="nav">
    <?php if (isset($_SESSION["id"])) { ?>
        <a href="/" class="nav__link">
            <p class="nav__text">Inicio</p>
        </a>
        <a href="/cerrar" class="nav__link">
            <p class="nav__text">Cerrar sesión</p>
        </a>
        <a href="/base" class="nav__link">
            <p class="nav__text">Creación de base de datos</p>
        </a>
        <a href="/usuario/<?php echo $_SESSION["id"] ?>" class="nav__link">
            <p class="nav__text">Tus datos</p>
        </a>
        <a href="/gestion" class="nav__link">
            <p class="nav__text">Gestión usuarios</p>
        </a>
    <?php } else { ?>
        <a href="/" class="nav__link">
            <p class="nav__text">Inicio</p>
        </a>
        <a href="base" class="nav__link">
            <p class="nav__text">Creación de base de datos</p>
        </a>
    <?php } ?>
</nav>