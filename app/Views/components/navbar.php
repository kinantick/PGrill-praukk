<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">
            Sistem Peminjaman Alat
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>" href="/dashboard">
                         Dashboard
                    </a>
                </li>
                
                <?php if (session()->get('role') === 'Peminjam'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active ?? '') === 'alat-tersedia' ? 'active' : '' ?>" href="/alat/tersedia">
                             Alat Tersedia
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active ?? '') === 'alat' ? 'active' : '' ?>" href="/alat">
                             Alat
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active ?? '') === 'user' ? 'active' : '' ?>" href="/user">
                             User
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active ?? '') === 'activity-log' ? 'active' : '' ?>" href="/activity-log">
                             Activity Log
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link <?= ($active ?? '') === 'peminjaman' ? 'active' : '' ?>" href="/peminjaman">
                         Peminjaman
                    </a>
                </li>

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?= session()->get('nama') ?? session()->get('email') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <h6 class="dropdown-header">
                                <i class="bi bi-person"></i> <?= session()->get('nama') ?? session()->get('email') ?>
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="/profile">
                                <i class="bi bi-person-badge"></i> Profile Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="/logout">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
