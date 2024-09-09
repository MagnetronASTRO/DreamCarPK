<script src='js/admin_users.js?v=<?= filemtime('js/admin_users.js') ?>'></script>
<div class="admin-wrapper">
    <div class="admin-form-wrapper">
        <h2>Edit User</h2>

        <form id="editUserForm" method="post" class="admin-add-form">
            <input type="hidden" id="userId" name="id" value="<?= $user->id ?>" required>

            <div class="admin-input-wrapper">
                <label for="edit_username">Username:</label>
                <input type="text" id="edit_username" name="username" value="<?= $user->username ?>">
            </div>
            <div class="admin-input-wrapper">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" value="<?= $user->email ?>">
            </div>
            <div class="admin-input-wrapper">
                <label for="edit_password">New password:</label>
                <input type="checkbox">
                <input type="password" id="edit_password" name="password">
            </div>
            <div class="admin-input-wrapper">
                <label for="edit_role">Role:</label>

                <select id="edit_role" name="role">
                    <?php foreach ($roles as $role): ?>
                        <?php if ($role['id'] === $user->role): ?>
                            <option value="<?= $role['id'] ?>" selected><?= $role['role_name'] ?></option>
                        <?php else: ?>
                            <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                        <?php endif;?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="admin-form-button-wrapper">
                <button type="button" id="goBack" class="admin-form-button admin-blue-btn">Go back</button>
                <button type="submit" class="admin-form-button admin-green-btn">Edit User</button>
            </div>
        </form>
    </div>
</div>