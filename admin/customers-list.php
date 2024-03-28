<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Customers List
                <a href="customer-create.php" class="btn btn-primary float-end">ADD CUSTOMER</a>
            </h4>
        </div>
        <div class="card-body">

            <!-- Alert -->
            <?php
            alertMessage();
            ?>
            <!-- Start -->
            <?php
            $customersData = getAllData('customers', null);
            if (!$customersData) {
                echo "h4 class='text-center mb-0'>Something Went Wrong</h4>";
                return false;
            }
            if (mysqli_num_rows($customersData) > 0) {
            ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    ID
                                </th>
                                <th class="text-center">
                                    Name
                                </th>
                                <th class="text-center">
                                    Email
                                </th>
                                <th class="text-center">
                                    Phone
                                </th>
                                <th class="text-center">
                                    Status
                                </th>
                                <th class="text-center">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>


                            <?php foreach ($customersData as $customerItem) :  ?>
                                <tr>
                                    <td class="text-center"><?= $customerItem['id'] ?></td>
                                    <td class="text-center"><?= $customerItem['name'] ?></td>
                                    <td class="text-center"><?= $customerItem['email'] ?></td>
                                    <td class="text-center"><?= $customerItem['phone'] ?></td>
                                    <td class="text-center">
                                        <?php

                                        if ($customerItem['status'] == 1) {
                                            echo "<span class='badge bg-danger'>Hidden</span>";
                                        } else {
                                            echo "<span class='badge bg-success'>Visible</span>";
                                        }

                                        ?>

                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="customer-edit.php?id=<?= $customerItem['id'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <a href="customer-delete.php?id=<?= $customerItem['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- End -->
            <?php
            } else {
            ?>

                <h4 class='text-center mb-0'>No data found</h4>

            <?php
            }
            ?>

        </div>
    </div>

</div>



<?php
include("includes/footer.php");
?>