<?php
// app/views/cart/add.php
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add to Cart</h4>
                </div>
                <div class="card-body">
                    <form action="/project/public/index.php?action=addToCart" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Select User</label>
                            <select name="user_id" class="form-select" required>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <?php foreach ($items as $item): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <img src="<?= htmlspecialchars($item['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                                            <p class="card-text">$<?= number_format($item['price'], 2) ?></p>
                                            <div class="d-flex align-items-center">
    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
    <input type="number" name="quantity" value="1" min="1" class="form-control me-2" style="width: 80px">
    <button type="submit" class="btn btn-primary">Add to Cart</button>
</div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>