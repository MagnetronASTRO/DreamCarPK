<script src='js/admin_users.js?v=<?= filemtime('js/admin_users.js') ?>'></script>
<div class="admin-wrapper">
    <h2>User Management</h2>
    <form action="/admin=sedf" method="post">
        <div class="data-grid-headers">
            <!-- Header row (hidden on mobile) -->
            <div class="grid-header">Username</div>
            <div class="grid-header hidden-on-mobile">Email</div>
            <div class="grid-header hidden-on-mobile">Role</div>
            <div class="grid-header hidden-on-mobile">Edit</div>
            <div class="grid-header hidden-on-mobile">Status</div>
        </div>
        <div class="data-grid">
            <!-- Data rows generated dynamically -->
            <?php foreach ($users as $user): ?>
                <div class="grid-cell username" data-label="Username" onclick="toggleExpand(this)">
                    <span class="spanArrow">V</span>
                    <?= htmlspecialchars($user->username) ?>
                </div>
                <div class="grid-cell hidden-content" data-label="Email">
                    <span class="rowName">Email:</span> <?= htmlspecialchars($user->email) ?>
                </div>
                <div class="grid-cell hidden-content" data-label="Role">
                    <span class="rowName">Role:</span>
                    <?= htmlspecialchars($user->role == 1 ? 'Admin' : 'Customer') ?>
                </div>
                <div class="grid-cell hidden-content center-td" data-label="Edit">
                    <button type="submit" value="<?= htmlspecialchars($user->id) ?>" name="showEditUserForm" class="admin-table-button admin-blue-btn">EDIT</button>
                </div>
                <div class="grid-cell hidden-content center-td" data-label="Status">
                    <button type="button" name="changeUserActivity" value="<?= htmlspecialchars($user->id) ?>" class="changeUserActivity admin-table-button <?= htmlspecialchars($user->is_active === 0 ? 'admin-red-btn' : 'admin-green-btn') ?>">
                        <?= htmlspecialchars($user->is_active === 1 ? 'ACTIVE' : 'BLOCKED') ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </form>

    <div>
        <br/>
        <button onclick="window.location.href='/admin=sauf';" class="admin-form-button admin-green-btn">Add user</button>
    </div>
</div>