<?php
include("includes/header.php");
?>


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

    <?php
    if (isset($_SESSION['productItems']) && count($_SESSION['productItems']) > 0) {
    ?>
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">
                    Order Items
                </h4>
            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['productItems'] as $key => $productItem) {
                            $subtotal = $productItem['price'] * $productItem['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $productItem['name']; ?></td>
                                <td><?php echo $productItem['price']; ?></td>
                                <td><?php echo $productItem['quantity']; ?></td>
                                <td><?php echo $subtotal; ?></td>
                                <td>
                                    <a href="orders-code.php?removeItem=<?php echo $key; ?>" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4" class="text-end">Total</td>
                            <td><?php echo $total; ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <form action="orders-code.php" method="POST">
                    <input type="hidden" name="total" value="<?php echo $total; ?>" />
                    <button type="submit" name="createOrder" class="btn btn-primary">Create Order</button>
                </form>

            </div>
        </div>
    <?php
    }
    ?>

</div>



<?php
include("includes/footer.php");
?>