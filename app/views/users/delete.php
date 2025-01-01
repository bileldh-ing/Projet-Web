<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Delete User</h4>
            </div>
            <div class="card-body">
                <?php if (isset($message)) echo $message; ?>
                
                <form action="/project/public/index.php?action=deleteUser" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Select User to Delete</label>
                        <select class="form-select" name="username" required>
                            <option value="">Select a user...</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user['username']); ?>">
                                    <?php echo htmlspecialchars($user['username']); ?> - 
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                        Delete User
                    </button>
                </form>

                <!-- Display all users in a table -->
                <div class="mt-4">
                    <h5>Current Users</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>