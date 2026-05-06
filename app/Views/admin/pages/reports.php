<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<form method="get" action="<?= base_url('admin/reports') ?>" class="reports-filters">
    <div>
        <label>From</label>
        <input type="date" name="from" value="<?= esc($from ?? '') ?>">
    </div>
    <div>
        <label>To</label>
        <input type="date" name="to" value="<?= esc($to ?? '') ?>">
    </div>
    <div>
        <label>Group by</label>
        <select name="group">
            <option value="day" <?= ($group ?? '') === 'day' ? 'selected' : '' ?>>Day</option>
            <option value="week" <?= ($group ?? '') === 'week' ? 'selected' : '' ?>>Week</option>
            <option value="month" <?= ($group ?? '') === 'month' ? 'selected' : '' ?>>Month</option>
        </select>
    </div>
    <button type="submit" class="btn-primary">Apply</button>
    <a href="<?= base_url('admin/reports/export?from=' . urlencode($from ?? '') . '&to=' . urlencode($to ?? '')) ?>" class="btn-secondary-outline">Export CSV</a>
</form>

<div class="stats-grid">
    <div class="stat-card">
        <p>Total Revenue (range)</p>
        <h2 style="color: #10b981;">₱<?= number_format($revenue ?? 0, 2) ?></h2>
    </div>
    <div class="stat-card">
        <p>Total Items Sold (range)</p>
        <h2 style="color: var(--primary);"><?= esc($items_sold ?? 0) ?></h2>
    </div>
</div>

<div class="card">
    <h3>Sales by period</h3>
    <table>
        <thead>
            <tr><th>Period</th><th>Revenue</th><th>Items</th></tr>
        </thead>
        <tbody>
            <?php foreach ($series ?? [] as $row): ?>
                <tr>
                    <td><?= esc($row['period'] ?? '') ?></td>
                    <td>₱<?= number_format((float) ($row['revenue'] ?? 0), 2) ?></td>
                    <td><?= esc($row['items'] ?? 0) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($series)): ?>
                <tr><td colspan="3" style="color: var(--text-muted);">No data in this range.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h3>By product</h3>
    <table>
        <thead>
            <tr><th>Product</th><th>Qty</th><th>Revenue</th></tr>
        </thead>
        <tbody>
            <?php foreach ($by_product ?? [] as $row): ?>
                <tr>
                    <td><?= esc($row['product_name'] ?? '') ?></td>
                    <td><?= esc($row['total_qty'] ?? 0) ?></td>
                    <td>₱<?= number_format((float) ($row['total_rev'] ?? 0), 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
