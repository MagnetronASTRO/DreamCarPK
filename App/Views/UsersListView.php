<!DOCTYPE html>
<html>
<head>
    <title>DreamCar - Users List</title>
</head>
<body>
<h1>Users List</h1>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
                <?= htmlspecialchars($user->getUsername()) ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
