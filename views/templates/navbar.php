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
            <!-- Links for logged-in users -->
            <li><a href="<?= ROOT ?>/profile">Profile</a></li>
            <li><a href="<?= ROOT ?>/logout">Logout</a></li>

            <?php if ($_SESSION['user_role'] === 'host'): ?>
                <!-- Link for hosts to create a property -->
                <li><a href="<?= ROOT ?>/properties/create">Create Property</a></li>
            <?php endif; ?>

            <?php if ($_SESSION['user_role'] === 'guest'): ?>
                <!-- Link for guests to view properties list -->
                <li><a href="<?= ROOT ?>/properties">Properties List</a></li>
            <?php endif; ?>

            <li>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>! (<?= htmlspecialchars($_SESSION['user_role']) ?>)</li>
        <?php else: ?>
            <!-- Links for non-logged-in users -->
            <li><a href="<?= ROOT ?>/login">Login</a></li>
            <li><a href="<?= ROOT ?>/register">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>