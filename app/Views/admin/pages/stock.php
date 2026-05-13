<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card">
    <h3 style="color: #10b981;">Active Stock</h3>
    <table>
        <thead><tr><th>Bread Name</th><th>Available Stock</th><th>Expiration Date</th></tr></thead>
        <tbody>
            <?php foreach ($active_products ?? [] as $p): ?>
                <tr>
                    <td style="font-weight: 500;"><?= esc($p['name'] ?? '') ?></td>
                    <td>
                        <strong style="color: <?= ($p['stock'] < 10) ? '#ef4444' : '#10b981' ?>;">
                            <?= esc($p['stock'] ?? 0) ?> units
                        </strong>
                    </td>
                    <td style="color: var(--text-muted); font-size: 14px;">
                        <?= $p['expiry_date'] ? esc($p['expiry_date']) : 'N/A' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($active_products)): ?>
                <tr><td colspan="3" style="text-align:center; padding: 20px; color: var(--text-muted);">No active stock found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="card" style="margin-top: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <h3 style="color: #ef4444; margin: 0;">Expired Stock</h3>
        <?php if (!empty($expired_products)): ?>
            <a href="<?= base_url('admin/stock/clear-expired') ?>" 
               class="btn-action btn-delete" 
               style="padding: 8px 16px; font-size: 13px;"
               data-confirm-delete
               data-confirm-message="Remove all expired products from inventory?">
                <i class="fas fa-trash-alt"></i> Clear All Expired
            </a>
        <?php endif; ?>
    </div>
    <table>
        <thead><tr><th>Bread Name</th><th>Available Stock</th><th>Expiration Date</th><th style="text-align: right;">Action</th></tr></thead>
        <tbody>
            <?php foreach ($expired_products ?? [] as $p): ?>
                <tr>
                    <td style="font-weight: 500;"><?= esc($p['name'] ?? '') ?></td>
                    <td>
                        <strong style="color: #ef4444;">
                            <?= esc($p['stock'] ?? 0) ?> units
                        </strong>
                    </td>
                    <td style="color: #ef4444; font-size: 14px; font-weight: 600;">
                        <?= esc($p['expiry_date'] ?? '') ?> (Expired)
                    </td>
                    <td style="text-align: right;">
                        <a href="<?= base_url('admin/product/delete/' . ($p['id'] ?? '')) ?>" 
                           class="btn-action btn-delete" 
                           data-confirm-delete 
                           data-confirm-message="Remove this expired product?">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($expired_products)): ?>
                <tr><td colspan="4" style="text-align:center; padding: 20px; color: var(--text-muted);">No expired stock found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
