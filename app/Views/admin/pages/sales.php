<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card" id="sales-form-card">
    <div class="card-head-row">
        <h3 style="margin:0;">Record New Sale</h3>
        <button type="button" class="btn-icon-close" title="Close" aria-label="Close sales form"
            onclick="document.getElementById('sales-form-card').style.display='none';document.getElementById('sales-form-toggle').style.display='block';">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <form action="<?= base_url('admin/sales/store') ?>" method="post" class="form-row">
        <?= csrf_field() ?>
        <select name="product_id" style="flex:3;" required>
            <option value="" disabled selected>Select Product...</option>
            <?php foreach ($products ?? [] as $p): ?>
                <option value="<?= esc($p['id'] ?? '') ?>"><?= esc($p['name'] ?? '') ?> (In Stock: <?= esc($p['stock'] ?? 0) ?>)</option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantity" placeholder="Qty" required style="flex:1;" min="1" value="<?= esc(old('quantity') ?? '') ?>">
        <button type="submit" class="btn-primary">Complete Sale</button>
    </form>
</div>

<div id="sales-form-toggle" class="sales-toggle" style="display:none;">
    <button type="button" class="btn-primary"
        onclick="document.getElementById('sales-form-card').style.display='block';document.getElementById('sales-form-toggle').style.display='none';">
        Record New Sale
    </button>
</div>

<form method="get" action="<?= base_url('admin/sales') ?>" class="toolbar-search">
    <div style="display:flex; align-items:center; gap:16px;">
        <div>
            <label for="sale-date">Filter by date</label>
            <input type="date" id="sale-date" name="date" value="<?= esc($filter_dt ?? '') ?>">
        </div>
        <div style="display:flex; align-items:center; gap:6px;">
            <input type="checkbox" id="voided-check" name="voided" value="1" <?= ($is_voided ?? false) ? 'checked' : '' ?> onchange="this.form.submit()">
            <label for="voided-check" style="margin:0; cursor:pointer;">Show Voided Sales</label>
        </div>
        <button type="submit" class="btn-primary">Apply</button>
        <?php if (($filter_dt ?? '') !== '' || ($is_voided ?? false)): ?>
            <a href="<?= base_url('admin/sales') ?>" class="btn-link-muted">Clear</a>
        <?php endif; ?>
    </div>
</form>

<div class="card">
    <h3><?= ($is_voided ?? false) ? 'Voided Transactions' : 'Transactions' ?></h3>
    <table>
        <thead>
            <tr>
                <th>Bread</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Total Paid</th>
                <th>When</th>
                <th style="text-align: right;"><?= ($is_voided ?? false) ? 'Action' : '&nbsp;' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales ?? [] as $s): ?>
                <tr>
                    <td><?= esc($s['product_name'] ?? '') ?></td>
                    <td><?= esc($s['quantity'] ?? 0) ?></td>
                    <td>₱<?= number_format((float) ($s['unit_price'] ?? 0), 2) ?></td>
                    <td style="font-weight: 600;">₱<?= number_format((float) ($s['total_price'] ?? 0), 2) ?></td>
                    <td style="color: var(--text-muted); font-size: 13px;"><?= esc($s['created_at'] ?? '') ?></td>
                    <td style="text-align: right;">
                        <?php if ($is_voided ?? false): ?>
                            <a href="<?= base_url('admin/sales/restore/' . ($s['id'] ?? '')) ?>" 
                               class="btn-action btn-edit" 
                               title="Restore Sale">
                                <i class="fas fa-undo"></i> Restore
                            </a>
                        <?php else: ?>
                            <a
                                href="<?= base_url('admin/sales/delete/' . ($s['id'] ?? '')) ?>"
                                class="btn-action btn-delete"
                                data-confirm-delete
                                data-confirm-message="Void this sale record? (Stock will be returned)"
                                title="Void Sale"
                                aria-label="Void sale record"
                            >
                                <i class="fas fa-times"></i> Void
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($sales)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 20px; color: var(--text-muted);">
                        No <?= ($is_voided ?? false) ? 'voided' : '' ?> transactions found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
