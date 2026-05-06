<?= $this->extend('admin/layout') ?>

<?= $this->section('head_extra') ?>
<style>
@media print {
    .sidebar, .top-nav, .flash-success, .flash-error, .no-print { display: none !important; }
    .main.admin-main { margin-left: 0 !important; }
    .content-body { padding: 20px !important; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card receipt-card">
    <h3 style="text-align:center;">Reah Bakery</h3>
    <p style="text-align:center; color: var(--text-muted); margin-top: 0;">Sale receipt</p>
    <table class="receipt-table">
        <tbody>
            <tr><td>Receipt #</td><td><?= esc($sale['id'] ?? '') ?></td></tr>
            <tr><td>Date</td><td><?= esc($sale['created_at'] ?? '') ?></td></tr>
            <tr><td>Item</td><td><?= esc($sale['product_name'] ?? '') ?></td></tr>
            <tr><td>Qty</td><td><?= esc($sale['quantity'] ?? '') ?></td></tr>
            <tr><td>Unit price</td><td>₱<?= number_format((float) ($sale['unit_price'] ?? 0), 2) ?></td></tr>
            <tr><td><strong>Total</strong></td><td><strong>₱<?= number_format((float) ($sale['total_price'] ?? 0), 2) ?></strong></td></tr>
        </tbody>
    </table>
    <p style="text-align:center; margin-top: 24px; color: var(--text-muted);">Thank you!</p>
    <div class="no-print" style="display:flex; gap:12px; justify-content:center; margin-top:20px;">
        <button type="button" class="btn-primary" onclick="window.print()">Print</button>
        <a href="<?= base_url('admin/sales') ?>" class="btn-secondary-outline">Back to Sales</a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
window.addEventListener('load', function () { window.print(); });
</script>
<?= $this->endSection() ?>
