<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="create-category.php" class="btn btn-primary float-end">ADD CATEGORY</a>
            </h4>
        </div>
        <div class="card-body">

            <!-- Alert -->
            <?php
            alertMessage();
            ?>
            <!-- Start -->
            <?php
            $categories = getAllData('categories', null);
            if (!$categories) {
                echo "h4 class='text-center mb-0'>Something Went Wrong</h4>";
                return false;
            }
            if (mysqli_num_rows($categories) > 0) {
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
                                    Status
                                </th>
                                <th class="text-center">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>


                            <?php foreach ($categories as $categoryItem) :  ?>
                                <tr>
                                    <td class="text-center"><?= $categoryItem['id'] ?></td>
                                    <td class="text-center"><?= $categoryItem['name'] ?></td>
                                    <td class="text-center">
                                        <?php

                                        if ($categoryItem['status'] == 1) {
                                            echo "<span class='badge bg-danger'>Hidden</span>";
                                        } else {
                                            echo "<span class='badge bg-success'>Visible</span>";
                                        }

                                        ?>

                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="categories-edit.php?id=<?= $categoryItem['id'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <a href="categories-delete.php?id=<?= $categoryItem['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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