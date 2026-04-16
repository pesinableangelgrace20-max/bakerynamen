<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reah Bakery Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #f4f7fa; display: flex; height: 100vh; }
        .sidebar { width: 250px; background: #2c3e50; color: white; display: flex; flex-direction: column; }
        .sidebar h2 { text-align: center; padding: 20px; background: #1a252f; margin: 0; }
        .sidebar a { padding: 15px 20px; color: #adb5bd; text-decoration: none; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
        .sidebar a.active, .sidebar a:hover { background: #34495e; color: white; border-left: 4px solid #3498db; }
        .main { flex: 1; overflow-y: auto; padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        .btn { padding: 8px 15px; border-radius: 5px; cursor: pointer; border: none; color: white; background: #27ae60; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Reah Bakery</h2>
        <a href="<?= base_url('admin') ?>" class="<?= ($page ?? '') == 'products' ? 'active' : '' ?>"><i class="fas fa-box"></i> Products</a>
        <a href="<?= base_url('admin/stock') ?>" class="<?= ($page ?? '') == 'stock' ? 'active' : '' ?>"><i class="fas fa-warehouse"></i> Stock</a>
        <a href="<?= base_url('admin/sales') ?>" class="<?= ($page ?? '') == 'sales' ? 'active' : '' ?>"><i class="fas fa-shopping-cart"></i> Sales</a>
        <a href="<?= base_url('admin/reports') ?>" class="<?= ($page ?? '') == 'reports' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Reports</a>
        <a href="<?= base_url('admin/users') ?>" class="<?= ($page ?? '') == 'users' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users</a>
        <a href="<?= base_url('logout') ?>" style="margin-top:auto; color: #ff7675;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <h1>Welcome, <?= session()->get('name') ?? 'Admin' ?></h1>

        <!-- 1. PRODUCTS SECTION -->
        <?php if(($page ?? '') == 'products'): ?>
            <!-- Add Product Form -->
            <div class="card">
                <h3>Add Product</h3>
                <form action="<?= base_url('admin/product/store') ?>" method="post" style="display:flex; gap:10px;">
                    <input type="text" name="name" placeholder="Name" required style="padding:10px; flex:1;">
                    <input type="number" name="price" placeholder="Price" required style="padding:10px; width:100px;">
                    <input type="number" name="stock" placeholder="Stock" required style="padding:10px; width:100px;">
                    <button type="submit" class="btn">Save</button>
                </form>
            </div>

            <!-- Unified Products Table -->
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products ?? [] as $p): ?>
                            <tr>
                                <td><?= esc($p['name'] ?? '') ?></td>
                                <td>$<?= number_format($p['price'] ?? 0, 2) ?></td>
                                <td><?= esc($p['stock'] ?? 0) ?></td>
                                <td style="display: flex; gap: 5px;">
                                    <!-- EDIT BUTTON -->
                                    <a href="<?= base_url('admin/product/edit/'.($p['id'] ?? '')) ?>" 
                                       style="background:#f39c12; color:white; padding:5px 10px; border-radius:5px; text-decoration:none; font-size:12px;">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <!-- DELETE BUTTON -->
                                    <a href="<?= base_url('admin/product/delete/'.($p['id'] ?? '')) ?>" 
                                       onclick="return confirm('Are you sure you want to delete this?')"
                                       style="background:#e74c3c; color:white; padding:5px 10px; border-radius:5px; text-decoration:none; font-size:12px;">
                                       <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <!-- Show this if there are no products yet -->
                        <?php if(empty($products)): ?>
                            <tr><td colspan="4" style="text-align:center;">No products found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <!-- 2. STOCK SECTION -->
        <?php elseif(($page ?? '') == 'stock'): ?>
            <div class="card">
                <h3>Stock Inventory</h3>
                <table>
                    <tr><th>Product Name</th><th>Current Stock</th></tr>
                    <?php foreach($products ?? [] as $p): ?>
                        <tr><td><?= esc($p['name'] ?? '') ?></td><td><?= esc($p['stock'] ?? 0) ?> units</td></tr>
                    <?php endforeach; ?>
                    <?php if(empty($products)): ?>
                        <tr><td colspan="2" style="text-align:center;">No stock data available.</td></tr>
                    <?php endif; ?>
                </table>
            </div>

        <!-- 3. SALES SECTION -->
        <?php elseif(($page ?? '') == 'sales'): ?>
            <div class="card">
                <h3>New Sale</h3>
                <!-- Fixed Action using base_url and matching Routes.php -->
                <form action="<?= base_url('admin/sales/store') ?>" method="post" style="display:flex; gap:10px;">
                    <select name="product_id" style="padding:10px; flex:1;" required>
                        <option value="" disabled selected>Select a product...</option>
                        <?php foreach($products ?? [] as $p): ?>
                            <option value="<?= esc($p['id'] ?? '') ?>"><?= esc($p['name'] ?? '') ?> (Stock: <?= $p['stock'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="quantity" placeholder="Qty" required style="padding:10px; width:80px;">
                    <button type="submit" class="btn">Sell</button>
                </form>
            </div>
            
            <div class="card">
                <table>
                    <thead>
                        <tr><th>Product</th><th>Qty</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($sales ?? [] as $s): ?>
                            <tr>
                                <td><?= esc($s['product_name'] ?? '') ?></td>
                                <td><?= esc($s['quantity'] ?? 0) ?></td>
                                <td>$<?= number_format($s['total_price'] ?? 0, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($sales)): ?>
                            <tr><td colspan="3" style="text-align:center; color:#7f8c8d;">No sales recorded yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <!-- 4. REPORTS SECTION -->
        <?php elseif(($page ?? '') == 'reports'): ?>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div class="card"><h2>$<?= number_format($revenue ?? 0, 2) ?></h2><p>Revenue</p></div>
                <div class="card"><h2><?= esc($items_sold ?? 0) ?></h2><p>Items Sold</p></div>
            </div>

        <!-- 5. USERS SECTION -->
        <?php elseif(($page ?? '') == 'users'): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr><th>Name</th><th>Email</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($users ?? [] as $u): ?>
                            <tr><td><?= esc($u['name'] ?? '') ?></td><td><?= esc($u['email'] ?? '') ?></td></tr>
                        <?php endforeach; ?>
                        <?php if(empty($users)): ?>
                            <tr><td colspan="2" style="text-align:center;">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
</body>
</html>