<?= view('admin/dashboard_header') ?>
<div style="background:white; padding:20px; margin-bottom:20px;">
    <h3>Record New Sale</h3>
    <form action="/admin/sales/store" method="post">
        <select name="product_id" required>
            <?php foreach($products as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['name'] ?> ($<?= $p['price'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantity" placeholder="Qty" required>
        <button type="submit" style="background:#27ae60; color:white; border:none; padding:5px 15px;">Sell</button>
    </form>
</div>
<table border="1" width="100%" style="border-collapse:collapse; background:white;">
    <tr style="background:#eee;"><th>Date</th><th>Product</th><th>Qty</th><th>Total</th></tr>
    <?php foreach($sales as $s): ?>
    <tr><td><?= $s['created_at'] ?></td><td><?= $s['product_name'] ?></td><td><?= $s['quantity'] ?></td><td>$<?= $s['total_price'] ?></td></tr>
    <?php endforeach; ?>
</table>