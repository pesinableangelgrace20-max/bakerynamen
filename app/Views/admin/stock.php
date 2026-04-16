<?= view('admin/dashboard_header') ?>
<h3><i class="fas fa-warehouse"></i> Inventory / Stock</h3>
<table border="1" width="100%" style="border-collapse:collapse; background:white;">
    <tr style="background:#eee;"><th>Product</th><th>Stock Quantity</th><th>Status</th></tr>
    <?php foreach($products as $p): ?>
    <tr>
        <td><?= $p['name'] ?></td>
        <td><?= $p['stock'] ?> units</td>
        <td><?= $p['stock'] < 10 ? '<span style="color:red">Low Stock</span>' : '<span style="color:green">Available</span>' ?></td>
    </tr>
    <?php endforeach; ?>
</table>