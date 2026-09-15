<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Test' ?></title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome untuk Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="<?= base_url('dashboard') ?>">Test App</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3"><i class="fas fa-user-circle"></i> Logged in as: <strong>User #1</strong></span>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse border-end min-vh-100 p-3">
                <h6 class="sidebar-heading text-muted text-uppercase fs-7 fw-bold mb-2">Menu Utama</h6>
                <ul class="nav flex-column">
                    <li class="nav-item mb-1">
                        <a href="<?= base_url('users') ?>" class="nav-link text-dark rounded <?= (uri_string() == 'dashboard') ? 'active bg-primary text-white' : '' ?>">
                            <i class="fas fa-user me-2"></i> User/Customer
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="<?= base_url('products') ?>" class="nav-link text-dark rounded <?= (strpos(uri_string(), 'products') !== false) ? 'active bg-primary text-white' : '' ?>">
                            <i class="fas fa-box me-2"></i> Product
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="<?= base_url('transactions') ?>" class="nav-link text-dark rounded <?= (strpos(uri_string(), 'transactions') !== false) ? 'active bg-primary text-white' : '' ?>">
                            <i class="fas fa-shopping-cart me-2"></i> Transaksi
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Konten Utama -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>