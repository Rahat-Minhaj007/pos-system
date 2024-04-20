<?php
include("includes/header.php");
?>

<!-- Modal -->

<div class="modal fade" id="customerAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">ADD CUSTOMER</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Enter Customer Name</label>
                    <input type="text" id="c_name" class="form-control" placeholder="Enter Customer Name">
                </div>
                <div class="mb-3">
                    <label>Enter Customer Phone</label>
                    <input type="number" id="c_phone" class="form-control" placeholder="Enter Customer Phone">
                </div>
                <div class="mb-3">
                    <label>Enter Customer Email (Optional)</label>
                    <input type="email" id="c_email" class="form-control" placeholder="Enter Customer Email">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-primary saveCustomer">SAVE</button>
            </div>
        </div>
    </div>
</div>

<!--  -->
<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">
                Create Order
                <a href="orders-list.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php
            alertMessage();
            ?>

            <form action="orders-code.php" method="POST">

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label for="">
                            Select Product
                        </label>

                        <select name="product_id" class="form-control mySelect2">
                            <option value="">-- Select Product --</option>
                            <?php
                            $products = getAllData('products', null);
                            foreach ($products as $product) {
                            ?>
                                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="">
                            Quantity
                        </label>

                        <input type="number" name="quantity" value="1" class="form-control" />
                    </div>


                    <div class="col-md-3 mb-3 text-end">
                        <br>
                        <button type="submit" name="addItem" class="btn btn-primary">ADD ITEM</button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    <!-- Display order products -->

    <div class="card my-5">
        <div class="card-header">
            <h4 class="mb-0">Order Products</h4>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['productItems']) && count($_SESSION['productItems']) > 0) {
                $seasonProducts = $_SESSION['productItems'];
            ?>
                <div id="productArea">
                    <div class="table-responsive mb-3" id="productContent">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($seasonProducts as $key => $product) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-center"><?= $product['name'] ?></td>
                                        <td class="text-center"><?= $product['price'] ?></td>
                                        <td class="text-center">
                                            <div class="input-group d-flex justify-content-center qtyBox">
                                                <input type="hidden" value="<?= $product['product_id'] ?>" class="productId" />
                                                <button class="input-group-text qtyDecrement">-</button>
                                                <input type="text" class="qty quantityInput text-center" value="<?= $product['quantity'] ?>" />
                                                <button class="input-group-text qtyIncrement">+</button>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <?= number_format($product['price'] * $product['quantity'], 0) ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">Remove</a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="mt-2">
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Select Payment Method</label>
                            <select id="payment_method" class="form-control">
                                <option value="">-- Select Payment --</option>
                                <option value="Cash Payment">Cash Payment</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Customer Phone Number</label>
                            <input type="number" id="cphone" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <br />
                            <button type="button" class="btn btn-warning w-100 proceedToPlace">Proceed to place order</button>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                echo "<h4 class='text-center'>No product added !</h4>";
            }
            ?>
        </div>
    </div>

</div>



<?php
include("includes/footer.php");
?>