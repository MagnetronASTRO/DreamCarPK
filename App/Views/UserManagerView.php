<div class="admin-wrapper">
<!--    <h1>User Management</h1>-->
<!---->
<!--    <h2>Add User</h2>-->
<!--    <form action="/add_user" method="post">-->
<!--        <label for="username">Username:</label>-->
<!--        <input type="text" id="username" name="username" required>-->
<!---->
<!--        <label for="email">Email:</label>-->
<!--        <input type="email" id="email" name="email" required>-->
<!---->
<!--        <label for="password">Password:</label>-->
<!--        <input type="password" id="password" name="password" required>-->
<!---->
<!--        <label for="role">Role:</label>-->
<!--        <select id="role" name="role" required>-->
<!--            <option value="1">Admin</option>-->
<!--            <option value="2">Customer</option>-->
<!--        </select>-->
<!---->
<!--        <button type="submit">Add User</button>-->
<!--    </form>-->
<!---->
<!--    <h2>Edit User</h2>-->
<!--    <form action="/edit_user" method="post">-->
<!--        <label for="edit_user_id">User ID:</label>-->
<!--        <input type="text" id="edit_user_id" name="id" required>-->
<!---->
<!--        <label for="edit_username">Username:</label>-->
<!--        <input type="text" id="edit_username" name="username">-->
<!---->
<!--        <label for="edit_email">Email:</label>-->
<!--        <input type="email" id="edit_email" name="email">-->
<!---->
<!--        <label for="edit_password">Password:</label>-->
<!--        <input type="password" id="edit_password" name="password">-->
<!---->
<!--        <label for="edit_role">Role:</label>-->
<!--        <select id="edit_role" name="role">-->
<!--            <option value="1">Admin</option>-->
<!--            <option value="2">Customer</option>-->
<!--        </select>-->
<!---->
<!--        <button type="submit">Edit User</button>-->
<!--    </form>-->

    <h2>Users</h2>
    <table class="data-table">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user->username) ?></td>
                <td><?= htmlspecialchars($user->email) ?></td>
                <td><?= htmlspecialchars($user->role == 1 ? 'Admin' : 'Customer') ?></td>
                <td><button type="submit" value="<?= htmlspecialchars($user->id) ?>" name="showEditUserForm">EDIT</button></td>
                <td><button type="submit" value="<?= htmlspecialchars($user->id) ?>" name="showEditUserForm">DELETE</button></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <br/>
        <button>Add user</button>
    </div>
</div>