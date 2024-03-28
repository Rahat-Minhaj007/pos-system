<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer
                <a href="customers-list.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php
            alertMessage();
            ?>

            <form action="code.php" method="POST">

                <?php
                $paramValue = checkParam('id');

                $customerData = getSingleData('customers', $paramValue);
                if ($customerData) {
                    if ($customerData['status'] == 200) {
                ?>
                        <input type="hidden" name="customerId" value="<?= $customerData['data']['id']; ?>">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Name *
                                </label>
                                <input type="text" name="name" value="<?= $customerData['data']['name']; ?>" required class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Email
                                </label>
                                <input type="text" name="email" value="<?= $customerData['data']['email']; ?>" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Phone
                                </label>
                                <input type="text" name="phone" value="<?= $customerData['data']['phone']; ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">
                                    Status (Unchecked=visible, Checked=Hidden)
                                </label>
                                <br>

                                <input type="checkbox" name="status" <?= $customerData['data']['status'] == true ? "checked" : ""; ?> style="width: 30px; height: 30px;">
                            </div>



                            <div class="col-md-6 mb-3 text-end">
                                <button type="submit" name="updateCustomer" class="btn btn-primary">UPDATE</button>
                            </div>

                        </div>
                <?php
                    } else {
                        echo '<h5>' . $customerData['message'] . '</h5>';
                    }
                } else {
                    echo 'Something went wrong!';
                    return false;
                }

                ?>
            </form>

        </div>
    </div>

</div>



<?php
include("includes/footer.php");
?>