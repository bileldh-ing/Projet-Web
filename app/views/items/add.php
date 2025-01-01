<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Add New Item</h4>
            </div>
            <div class="card-body">
                <!-- Updated form action path -->
                <form action="/project/public/index.php?action=add" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seller Contact</label>
                        <input type="tel" class="form-control" name="seller_contact" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>