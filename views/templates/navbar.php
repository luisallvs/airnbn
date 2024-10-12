<nav>
    <ul>
        <li><a href="<?= ROOT ?>/">Home</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Links for logged-in users -->
            <li><a href="<?= ROOT ?>/profile">Profile</a></li>
            <li><a href="<?= ROOT ?>/logout">Logout</a></li>

            <?php if ($_SESSION['user_role'] === 'host'): ?>
                <!-- Links for host users -->
                <li><a href="<?= ROOT ?>/properties/create">Create Property</a></li>
                <li><a href="<?= ROOT ?>/reservations/manage">Manage Reservations</a></li>
                <li><a href="<?= ROOT ?>/properties/manage">My Properties</a></li>

            <?php elseif ($_SESSION['user_role'] === 'guest'): ?>
                <!-- Links for guest users -->
                <li><a href="<?= ROOT ?>/properties/">Properties List</a></li>
                <li><a href="<?= ROOT ?>/reservations">My Reservations</a></li>
            <?php endif; ?>

            <li>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>! (<?= htmlspecialchars($_SESSION['user_role']) ?>)</li>
        <?php else: ?>
            <!-- Links for non-logged-in users -->
            <li><a href="<?= ROOT ?>/login">Login</a></li>
            <li><a href="<?= ROOT ?>/register">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>