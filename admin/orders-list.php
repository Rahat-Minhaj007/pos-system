<?php
include("includes/header.php");
?>
<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Orders List
                <!-- <a href="products-list.php" class="btn btn-primary float-end">Back</a> -->
            </h4>
        </div>
        <div class="card-body">
            <?php
            $query = "SELECT o.*, c.* FROM orders o, customers c WHERE o.customer_id=c.id ORDER BY o.id DESC";
            $orders = mysqli_query($connect, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
            ?>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th class="text-center">Tracking No</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Customer phone</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Order Status</th>
                                <th class="text-center">Payment Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem) : ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $orderItem['tracking_no'] ?></td>
                                    <td class="text-center"><?= $orderItem['name'] ?></td>
                                    <td class="text-center"><?= $orderItem['phone'] ?></td>
                                    <td class="text-center"><?= date('d/m/y', strtotime($orderItem['order_date'])) ?></td>
                                    <td class="text-center"><?= $orderItem['order_status'] ?></td>
                                    <td class="text-center"><?= $orderItem['payment_method'] ?></td>
                                    <td class="text-center">
                                        <a href="order-view.php?track=<?= $orderItem['tracking_no'] ?>" class="btn btn-info mb-0 px-2 btn-sm fw-semibold">VIEW</a>
                                        <a href="" class="btn btn-primary mb-0 px-2 btn-sm fw-semibold">PRINT</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tbody>

                        </tbody>
                    </table>
            <?php
                } else {
                    echo "<h4>No orders found</h4>";
                }
            } else {

                echo "<h4>Something went wrong</h4>";
            }

            ?>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>