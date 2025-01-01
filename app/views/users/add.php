<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Add New User</h4>
            </div>
            <div class="card-body">
                <?php
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger"><ul class="mb-0">';
                    foreach ($errors as $error) {
                        echo '<li>' . htmlspecialchars($error) . '</li>';
                    }
                    echo '</ul></div>';
                }
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success">User created successfully!</div>';
                }
                ?>
                
                <form action="/project/public/index.php?action=addUser" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>