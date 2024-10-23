<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= ROOT ?>/admin/dashboard">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- users dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                        <li><a class="dropdown-item" href="<?= ROOT ?>/admin/users">View All Users</a></li>
                        <li><a class="dropdown-item" href="<?= ROOT ?>/admin/users/create">Add New User</a></li>
                    </ul>
                </li>

                <!-- properties dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="propertiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-house"></i> Properties
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="propertiesDropdown">
                        <li><a class="dropdown-item" href="<?= ROOT ?>/admin/properties">View All Properties</a></li>
                        <li><a class="dropdown-item" href="<?= ROOT ?>/admin/properties/create">Add New Property</a></li>
                    </ul>
                </li>

                <!-- reservations dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reservationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-calendar-check"></i> Reservations
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="reservationsDropdown">
                        <li><a class="dropdown-item" href="<?= ROOT ?>/admin/reservations">View All Reservations</a></li>
                        <li><a class="dropdown-item" href="<?= ROOT ?>/admin/reservations/create">Add New Reservation</a></li>
                    </ul>
                </li>
            </ul>

            <!-- logout button -->
            <form action="<?= ROOT ?>/admin/logout" method="POST" class="d-flex align-items-center">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">