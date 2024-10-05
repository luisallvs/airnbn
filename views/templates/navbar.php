<?php
/* Start session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <ul>
        <li><a href="<?= ROOT ?>/">Home</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Links to show when the user is logged in -->
            <li><a href="<?= ROOT ?>/profile">Profile</a></li>
            <li><a href="<?= ROOT ?>/logout">Logout</a></li>
            <li>Logged in as: <?= $_SESSION['user_id'] ?></li>
        <?php else: ?>
            <!-- Links to show when the user is not logged in -->
            <li><a href="<?= ROOT ?>/login">Login</a></li>
            <li><a href="<?= ROOT ?>/register">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>