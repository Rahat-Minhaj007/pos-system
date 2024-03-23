<nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">POS SYSTEM</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">HOME</a>
                </li>
                <?php if (isset($_SESSION['loggedIn'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?= $_SESSION['loggedInUser']['name']; ?> </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">LOGOUT</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-dark" href="login.php">LOGIN</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>