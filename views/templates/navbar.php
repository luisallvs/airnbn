<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= ROOT ?>/">
            <i class="bi bi-house-door-fill"></i> Airbnb
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Profile link for logged-in users -->
                    <li class="nav-item">
                        <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/profile' ? 'active' : '' ?>" href="<?= ROOT ?>/profile">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </li>

                    <?php if ($_SESSION['user_role'] === 'host'): ?>
                        <!-- Host Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="propertiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-building"></i> Properties
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="propertiesDropdown">
                                <li><a class="dropdown-item" href="<?= ROOT ?>/properties/create"><i class="bi bi-plus-circle"></i> Create Property</a></li>
                                <li><a class="dropdown-item" href="<?= ROOT ?>/properties/manage"><i class="bi bi-list-check"></i> Manage Properties</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/reservations/manage' ? 'active' : '' ?>" href="<?= ROOT ?>/reservations/manage">
                                <i class="bi bi-calendar-check"></i> Manage Reservations
                            </a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] === 'guest'): ?>
                        <!-- Guest Navigation -->
                        <li class="nav-item">
                            <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/properties/' ? 'active' : '' ?>" href="<?= ROOT ?>/properties/">
                                <i class="bi bi-search"></i> Properties List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/reservations' ? 'active' : '' ?>" href="<?= ROOT ?>/reservations">
                                <i class="bi bi-calendar2-check"></i> My Reservations
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Logout and Welcome message -->
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="<?= ROOT ?>/logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="navbar-text ms-2 d-flex align-items-center">
                            Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!
                            <span class="badge bg-info text-dark ms-2"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
                        </span>
                    </li>
                <?php else: ?>
                    <!-- Links for non-logged-in users -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/properties/">
                            <i class="bi bi-search"></i> Properties List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/login">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>/register">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">