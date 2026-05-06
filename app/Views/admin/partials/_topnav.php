<header class="top-nav">
    <h1><?= esc($title ?? 'Dashboard') ?></h1>
    <div class="user-info">
        <span>Welcome, <strong><?= esc(session()->get('name') ?? 'Admin') ?></strong></span>
        <div class="user-avatar"><?= esc(substr((string) (session()->get('name') ?? 'A'), 0, 1)) ?></div>
    </div>
</header>
