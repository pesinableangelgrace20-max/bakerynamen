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
    <label for="sale-date">Filter by date</label>
    <input type="date" id="sale-date" name="date" value="<?= esc($filter_dt ?? '') ?>">
    <button type="submit" class="btn-primary">Apply</button>
    <?php if (($filter_dt ?? '') !== ''): ?>
        <a href="<?= base_url('admin/sales') ?>" class="btn-link-muted">Clear</a>
    <?php endif; ?>
</form>

<div class="card">
    <h3>Transactions</h3>
    <table>
        <thead>
            <tr>
                <th>Bread</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Total Paid</th>
                <th>When</th>
                <th style="text-align: right;">&nbsp;</th>
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
                        <a
                            href="<?= base_url('admin/sales/delete/' . ($s['id'] ?? '')) ?>"
                            class="btn-action btn-delete"
                            data-confirm-delete
                            data-confirm-message="Remove this sale record?"
                            title="Remove"
                            aria-label="Remove sale record"
                        >
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($pager) && $pager): ?>
    <div class="pager-wrap">
        <?= $pager->only(['date' => $filter_dt ?? ''])->links('default', 'default_full') ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
