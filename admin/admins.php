<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/Staff
                <a href="admins-create.php" class="btn btn-primary float-end">ADD ADMIN</a>
            </h4>
        </div>
        <div class="card-body">

            <!-- Alert -->
            <?php
            alertMessage();
            ?>
            <!-- Start -->
            <?php
            $admins = getAllData('admins', null);
            if (!$admins) {
                echo "h4 class='text-center mb-0'>Something Went Wrong</h4>";
                return false;
            }
            if (mysqli_num_rows($admins) > 0) {
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
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>


                            <?php foreach ($admins as $adminItem) :  ?>
                                <tr>
                                    <td class="text-center"><?= $adminItem['id'] ?></td>
                                    <td class="text-center"><?= $adminItem['name'] ?></td>
                                    <td class="text-center"><?= $adminItem['email'] ?></td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="admins-edit.php?id=<?= $adminItem['id'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <a href="admins-delete.php" class="btn btn-danger btn-sm">Delete</a>
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