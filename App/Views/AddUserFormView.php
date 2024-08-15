<script src='js/admin_users.js?v=<?= filemtime('js/admin_users.js') ?>'></script>
<div class="admin-wrapper">
    <div class="admin-form-wrapper">
        <h2>Add User</h2>
        <form id="addUserForm" method="post" class="admin-add-form">
            <div class="admin-input-wrapper">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="admin-input-wrapper">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="admin-input-wrapper">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="admin-input-wrapper">
                <label for="role">Role:</label>
                <br/>
                <select id="role" name="role" required>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                <?php endforeach; ?>
                </select>
            </div>

            <div class="admin-form-button-wrapper">
                <button type="submit" id="addUser" class="admin-form-button admin-green-btn">Add User</button>
            </div>
        </form>
    </div>
</div>

