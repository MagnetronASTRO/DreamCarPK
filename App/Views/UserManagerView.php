<script src='js/admin_users.js?v=<?= filemtime('js/admin_users.js') ?>'></script>
<div class="admin-wrapper">
    <h1>User Management</h1>
    <h2>Users:</h2>
    <form action="/admin=sedf" method="post">
        <table class="data-table">
            <thead>
            <tr>
                <th style="width: 20%;">Username</th>
                <th style="width: 40%;">Email</th>
                <th style="width: 120px;">Role</th>
                <th style="width:120px; ">Edit</th>
                <th style="width:120px; ">Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->username) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td><?= htmlspecialchars($user->role == 1 ? 'Admin' : 'Customer') ?></td>
                    <td class="center-td" >
                        <button
                                type="submit"
                                value="<?= htmlspecialchars($user->id) ?>"
                                name="showEditUserForm"
                                class="admin-table-button admin-blue-btn">EDIT</button>
                    </td>
                    <td class="center-td">
                        <button
                                type="button"
                                name="changeUserActivity"
                                value="<?= htmlspecialchars($user->id) ?>"
                                name="showEditUserForm"
                                class="changeUserActivity admin-table-button <?= htmlspecialchars($user->is_active === 0 ? 'admin-red-btn' : 'admin-green-btn') ?>">
                            <?= htmlspecialchars($user->is_active === 1 ? 'ACTIVE' : 'BLOCKED') ?>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </form>
    <div>
        <br/>
        <button onclick="window.location.href='/admin=sauf';" class="admin-form-button admin-green-btn">Add user</button>
    </div>
</div>