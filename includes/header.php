<?php
include_once './includes/database.php';
session_start();
?>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>
                <li class="nav-item"><a class="nav-link" href="education.php">Education</a></li>
                <li class="nav-item"><a class="nav-link" href="culture.php">Culture</a></li>
                <li class="nav-item"><a class="nav-link" href="travels.php">Travels</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </li>
                    <?php if($_SESSION['is_admin'] == 1): ?>
                        <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
