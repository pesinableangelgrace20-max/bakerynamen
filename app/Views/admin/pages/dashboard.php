<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="stats-grid">
    <div class="stat-card">
        <p>Today's Revenue</p>
        <h2 style="color: #10b981;">₱<?= number_format($today_revenue ?? 0, 2) ?></h2>
    </div>
    <div class="stat-card">
        <p>Today's Items Sold</p>
        <h2 style="color: var(--primary);"><?= esc($today_items_sold ?? 0) ?></h2>
    </div>
    <div class="stat-card">
        <p>Total Revenue (all time)</p>
        <h2 style="color: #10b981;">₱<?= number_format($revenue ?? 0, 2) ?></h2>
    </div>
    <div class="stat-card">
        <p>Total Items Sold</p>
        <h2 style="color: var(--primary);"><?= esc($items_sold ?? 0) ?></h2>
    </div>
    <div class="stat-card">
        <p>Products</p>
        <h2><?= esc($product_count ?? 0) ?></h2>
    </div>
    <div class="stat-card">
        <p>Low Stock (&lt; 10)</p>
        <h2 style="color: #ef4444;"><?= esc($low_stock_count ?? 0) ?></h2>
    </div>
</div>

<?php if (! empty($low_stock_items)): ?>
    <div class="alert-banner alert-low-stock">
        <strong>Low stock alert:</strong>
        <?php foreach ($low_stock_items as $p): ?>
            <span class="alert-chip"><?= esc($p['name'] ?? '') ?> (<?= esc($p['stock'] ?? 0) ?>)</span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="dashboard-two-col">
    <div class="card">
        <h3>Last 7 days sales (₱)</h3>
        <canvas id="salesChart" height="120"></canvas>
    </div>
    <div class="card">
        <h3>Top 5 best sellers</h3>
        <table>
            <thead>
                <tr><th>Product</th><th>Qty sold</th></tr>
            </thead>
            <tbody>
                <?php foreach ($top_sellers ?? [] as $row): ?>
                    <tr>
                        <td><?= esc($row['product_name'] ?? '') ?></td>
                        <td><strong><?= esc($row['qty'] ?? 0) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($top_sellers)): ?>
                    <tr><td colspan="2" style="color: var(--text-muted);">No sales yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h3>Recent Transactions</h3>
    <table>
        <thead><tr><th>Bread</th><th>Quantity</th><th>Total Paid</th><th>When</th></tr></thead>
        <tbody>
            <?php foreach ($recent_sales ?? [] as $s): ?>
                <tr>
                    <td><?= esc($s['product_name'] ?? '') ?></td>
                    <td><?= esc($s['quantity'] ?? 0) ?></td>
                    <td style="font-weight: 600;">₱<?= number_format($s['total_price'] ?? 0, 2) ?></td>
                    <td style="color: var(--text-muted); font-size: 13px;"><?= esc($s['created_at'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    var labels = <?= json_encode($chart_labels ?? []) ?>;
    var values = <?= json_encode($chart_values ?? []) ?>;
    var ctx = document.getElementById('salesChart');
    if (!ctx || typeof Chart === 'undefined') return;
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₱)',
                data: values,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.15)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
})();
</script>
<?= $this->endSection() ?>
