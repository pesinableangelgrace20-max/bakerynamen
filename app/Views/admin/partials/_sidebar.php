<?php
$page = $page ?? 'dashboard';
?>
<div class="sidebar">
    <h2>Reah Bakery</h2>
    <nav>
        <a href="<?= base_url('admin') ?>" class="<?= $page === 'dashboard' ? 'active' : '' ?>"><i class="fas fa-gauge-high"></i> Dashboard</a>
        <a href="<?= base_url('admin/products') ?>" class="<?= $page === 'products' ? 'active' : '' ?>"><i class="fas fa-box"></i> Products</a>
        <a href="<?= base_url('admin/stock') ?>" class="<?= $page === 'stock' ? 'active' : '' ?>"><i class="fas fa-warehouse"></i> Stock</a>
        <a href="<?= base_url('admin/sales') ?>" class="<?= $page === 'sales' ? 'active' : '' ?>"><i class="fas fa-shopping-cart"></i> Sales</a>
        <a href="<?= base_url('admin/reports') ?>" class="<?= $page === 'reports' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Reports</a>
        <a href="<?= base_url('admin/users') ?>" class="<?= $page === 'users' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a>
    </nav>
    <a href="<?= base_url('logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
