<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Delete Item</h4>
            </div>
            <div class="card-body">
                <!-- Updated form action path -->
                <form action="/project/public/index.php?action=delete" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Select Item to Delete</label>
                        <select class="form-select" name="item_name" required>
                            <option value="">Select an item...</option>
                            <?php foreach ($items as $item): ?>
                                <option value="<?php echo htmlspecialchars($item['name']); ?>">
                                    <?php echo htmlspecialchars($item['name']); ?> - $<?php echo htmlspecialchars($item['price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                        Delete Item
                    </button>
                </form>

                <!-- Display all items in a table -->
                <div class="mt-4">
                    <h5>Current Items</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Seller Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                        <td><?php echo htmlspecialchars($item['description']); ?></td>
                                        <td><?php echo htmlspecialchars($item['seller_contact']); ?></td>
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