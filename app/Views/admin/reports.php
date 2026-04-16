<?= view('admin/dashboard_header') ?>
<div style="display:flex; gap:20px;">
    <div style="background:white; padding:30px; flex:1; text-align:center; border-radius:10px;">
        <h1>$<?= number_format($revenue, 2) ?></h1>
        <p>Total Revenue</p>
    </div>
    <div style="background:white; padding:30px; flex:1; text-align:center; border-radius:10px;">
        <h1><?= $items_sold ?></h1>
        <p>Total Items Sold</p>
    </div>
</div>