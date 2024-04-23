<?php include '../partials/header.php'; ?>

<div class="container mt-5">
    <h1>Update User</h1>
    <form action="../../index.php?action=update&id=<?= htmlspecialchars($user['id']) ?>" method="post" class="form-group">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>