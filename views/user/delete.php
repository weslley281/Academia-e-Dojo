<div class="container mt-5">
    <h1>Delete User</h1>
    <p>Are you sure you want to delete this user?</p>
    <form action="../../index.php?action=delete&id=<?= htmlspecialchars($user['id']) ?>" method="post">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="../../index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>