<?php
include("includes/header.php");
if (!isset($_SESSION['productItems'])) {
    echo '<script> window.location.href="order-create.php";  </script>';
}
?>

<!-- Modal -->
<div class="modal fade" id="orderPlaceSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <h5 id="orderPlaceSuccessMessage"></h5>
                </div>
                <a href="orders-list.php" class="btn btn-secondary">CLOSE</a>
                <button type="button" class="btn btn-danger">PRINT</button>
                <button type="button" class="btn btn-warning">DOWNLOAD PDF</button>
            </div>
        </div>
    </div>
</div>
<!--  -->
<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">
                Order Summary
                <a href="order-create.php" class="btn btn-danger float-end">Back to create order</a>
            </h4>
        </div>
        <div class="card-body">

            <?php
            alertMessage();
            ?>

            <div id="myBillingArea">

                <?php
                if (isset($_SESSION['cphone'])) {
                    $phone = validate($_SESSION['cphone']);
                    $invoiceNo = validate($_SESSION['invoice_no']);

                    $customQuery = "SELECT * FROM customers WHERE phone='$phone' LIMIT 1";
                    $checkCustomer = mysqli_query($connect, $customQuery);
                    if ($checkCustomer) {
                        if (mysqli_num_rows($checkCustomer) > 0) {
                            $customer = mysqli_fetch_assoc($checkCustomer);
                ?>
                            <table style="width:100%; margin-bottom:30px;">
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;" colspan="2">
                                            <h5 style="font-size:22px; line-height:30px; margin:2px;padding:0;">Company XYZ</h5>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Address: 123, ABC Road, XYZ City</p>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Phone: 1234567890</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4 style="font-size:20px; line-height:30px; margin:2px;padding:0;">Customer Details</h4>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Name: <?= $customer['name']; ?></p>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Phone: <?= $customer['phone']; ?></p>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Email: <?= $customer['email']; ?></p>
                                        </td>
                                        <td align="end">
                                            <h4 style="font-size:20px; line-height:30px; margin:2px;padding:0;">Invoice Details</h4>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Invoice No: <?= $invoiceNo; ?></p>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Date: <?= date('d-m-Y'); ?></p>
                                            <p style="font-size:14px; line-height:20px; margin:2px;padding:0;">Address: 123, ABC Road, XYZ City</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                <?php
                        }
                    } else {
                        echo "h5 class='text-danger'>Customer not found</h5>";
                        return;
                    }
                }
                ?>

                <?php
                if (isset($_SESSION['productItems']) && count($_SESSION['productItems']) > 0) {
                    $addProducts = $_SESSION['productItems'];
                ?>
                    <div class="table-responsive mb-3">
                        <table style="width:100%" cellPadding="5">
                            <thead>
                                <tr>
                                    <th align="start" style="border-bottom:1px solid #ccc;text-align:center;" width="5%">ID</th>
                                    <th align="start" style="border-bottom:1px solid #ccc;text-align:center;">Product Name</th>
                                    <th align="start" style="border-bottom:1px solid #ccc;text-align:center;" width="10%">Price</th>
                                    <th align="start" style="border-bottom:1px solid #ccc;text-align:center;" width="10%">Quantity</th>
                                    <th align="start" style="border-bottom:1px solid #ccc;text-align:center;" width="15%">Total Price</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                $totalAmount = 0;
                                foreach ($addProducts as $key => $row) :
                                    $totalAmount += $row['price'] * $row['quantity'];

                                ?>
                                    <tr>
                                        <td style="border-bottom:1px solid #ccc;text-align:center;"><?= $i++ ?></td>
                                        <td style="border-bottom:1px solid #ccc;text-align:center;"><?= $row['name'] ?></td>
                                        <td style="border-bottom:1px solid #ccc;text-align:center;"><?= number_format($row['price'], 0) ?></td>
                                        <td style="border-bottom:1px solid #ccc;text-align:center;"><?= $row['quantity'] ?></td>
                                        <td style="border-bottom:1px solid #ccc;text-align:center;" class="fw-bold"><?= number_format($row['price'] * $row['quantity'], 0) ?></td>

                                    </tr>

                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #ccc;" align="end" class="fw-bold">Total Amount</td>
                                    <td colspan="1" style="border-bottom:1px solid #ccc;text-align:center;" class="fw-bold"><?= number_format($totalAmount, 0) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="fw-bold">Payment Mode: <?= $_SESSION["payment_method"] ?></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                <?php
                } else {
                    echo "<h5 class='text-danger'>No product found</h5>";
                    return;
                }
                ?>

            </div>

            <?php if (isset($_SESSION['productItems'])) : ?>
                <div class="mt-4 mb-3 text-end">
                    <button type="button" class="btn btn-primary px-4 mx-1" id="saveOrder">SAVE</button>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>