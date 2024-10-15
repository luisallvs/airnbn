<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= ROOT ?>/">Airnbn</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Links for logged-in users -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/profile">Profile</a>
                    </li>


                    <?php if ($_SESSION['user_role'] === 'host'): ?>
                        <!-- Links for host users -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="propertiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Properties
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="propertiesDropdown">
                                <li><a class="dropdown-item" href="<?= ROOT ?>/properties/create">Create Property</a></li>
                                <li><a class="dropdown-item" href="<?= ROOT ?>/properties/manage">My Properties</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/reservations/manage">Manage Reservations</a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] === 'guest'): ?>
                        <!-- Links for guest users -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/properties/">Properties List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= ROOT ?>/reservations">My Reservations</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/logout">Logout</a>
                    </li>
                    <li class="nav-item">
                        <span class="navbar-text">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>! (<?= htmlspecialchars($_SESSION['user_role']) ?>)</span>
                    </li>
                <?php else: ?>
                    <!-- Links for non-logged-in users -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/properties/">Properties List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>