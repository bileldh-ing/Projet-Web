<?php
// app/views/cart/view.php
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Shopping Cart</h4>
                    <form action="/project/public/index.php?action=clearCart" method="POST" class="m-0">
                        <input type="hidden" name="user_id" value="<?= $userId ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Clear Cart</button>
                    </form>
                </div>
                <div class="card-body">
                    <?php if (empty($cartItems)): ?>
                        <p class="text-center">Your cart is empty</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 50px; height: 50px; object-fit: cover" class="me-2">
                                                    <?= htmlspecialchars($item['name']) ?>
                                                </div>
                                            </td>
                                            <td>$<?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <form action="/project/public/index.php?action=updateQuantity" method="POST" class="d-flex align-items-center">
                                                    <input type="hidden" name="user_id" value="<?= $userId ?>">
                                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 80px">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Update</button>
                                                </form>
                                            </td>
                                            <td>$<?= number_format($item['total_price'], 2) ?></td>
                                            <td>
                                                <form action="/project/public/index.php?action=removeFromCart" method="POST">
                                                    <input type="hidden" name="user_id" value="<?= $userId ?>">
                                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td colspan="2"><strong>$<?= number_format($totalPrice, 2) ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>