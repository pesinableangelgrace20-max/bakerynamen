<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card edit-form-card">
    <h3>Product Details</h3>
    <form action="<?= base_url('admin/product/update/' . ($product['id'] ?? '')) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-stack">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= esc(old('name', $product['name'] ?? '')) ?>" required>

            <label>Price (₱)</label>
            <input type="number" step="0.01" name="price" value="<?= esc(old('price', $product['price'] ?? '')) ?>" required>

            <label>Current Stock</label>
            <input type="number" name="stock" value="<?= esc(old('stock', $product['stock'] ?? '')) ?>" required>

            <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Update Product</button>
            <a href="<?= base_url('admin/products') ?>" class="btn-link-muted">Cancel and go back</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
