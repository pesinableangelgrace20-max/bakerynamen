<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card">
    <h3>Add New Bread</h3>
    <form action="<?= base_url('admin/product/store') ?>" method="post" class="form-row">
        <?= csrf_field() ?>
        <input type="text" name="name" placeholder="Product Name" required style="flex:2;" value="<?= esc(old('name') ?? '') ?>">
        <input type="number" step="0.01" name="price" placeholder="Price (₱)" required style="flex:1;" value="<?= esc(old('price') ?? '') ?>">
        <input type="number" name="stock" placeholder="Initial Stock" required style="flex:1;" value="<?= esc(old('stock') ?? '') ?>">
        <div style="flex:1; display:flex; flex-direction:column;">
            <label style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px;">Expiry Date</label>
            <input type="date" name="expiry_date" value="<?= esc(old('expiry_date') ?? '') ?>">
        </div>
        <button type="submit" class="btn-primary">Add Product</button>
    </form>
</div>

<form method="get" action="<?= base_url('admin/products') ?>" class="toolbar-search">
    <input type="search" name="q" placeholder="Search by name..." value="<?= esc($search_q ?? '') ?>">
    <button type="submit" class="btn-primary">Search</button>
    <?php if (($search_q ?? '') !== ''): ?>
        <a href="<?= base_url('admin/products') ?>" class="btn-link-muted">Clear</a>
    <?php endif; ?>
</form>

<table>
    <thead>
        <tr>
            <th>Bread Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Expiry Date</th>
            <th style="text-align: right;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products ?? [] as $p): ?>
            <tr>
                <td style="font-weight: 500;"><?= esc($p['name'] ?? '') ?></td>
                <td>₱<?= number_format((float) ($p['price'] ?? 0), 2) ?></td>
                <td>
                    <span class="stock-pill"><?= esc($p['stock'] ?? 0) ?> units</span>
                </td>
                <td style="font-size: 14px; color: var(--text-muted);">
                    <?= $p['expiry_date'] ? esc($p['expiry_date']) : '<span style="font-style:italic;">N/A</span>' ?>
                </td>
                <td style="text-align: right;">
                    <a href="<?= base_url('admin/product/edit/' . ($p['id'] ?? '')) ?>" class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?= base_url('admin/product/delete/' . ($p['id'] ?? '')) ?>"
                       class="btn-action btn-delete"
                       data-confirm-delete
                       data-confirm-message="Delete this product?">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
