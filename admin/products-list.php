<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Product List
                <a href="create-product.php" class="btn btn-primary float-end">ADD PRODUCT</a>
            </h4>
        </div>
        <div class="card-body">

            <!-- Alert -->
            <?php
            alertMessage();
            ?>
            <!-- Start -->
            <?php
            $products = getAllData('products', null);
            if (!$products) {
                echo "h4 class='text-center mb-0'>Something Went Wrong</h4>";
                return false;
            }
            if (mysqli_num_rows($products) > 0) {
            ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    ID
                                </th>
                                <th class="text-center">
                                    Image
                                </th>
                                <th class="text-center">
                                    Name
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


                            <?php foreach ($products as $productItem) :  ?>
                                <tr>
                                    <td class="text-center"><?= $productItem['id']; ?></td>
                                    <td class="text-center">
                                        <img src="../<?= $productItem['image']; ?>" alt="ProductImage" style="width:50px;height:50px;object-fit: contain;">
                                    </td>
                                    <td class="text-center"><?= $productItem['name']; ?></td>
                                    <td class="text-center">
                                        <?php

                                        if ($productItem['status'] == 1) {
                                            echo "<span class='badge bg-danger'>Hidden</span>";
                                        } else {
                                            echo "<span class='badge bg-success'>Visible</span>";
                                        }

                                        ?>

                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="categories-edit.php?id=<?= $productItem['id'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <a href="categories-delete.php?id=<?= $productItem['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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