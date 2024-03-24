<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Category
                <a href="categories-list.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php
            alertMessage();
            ?>

            <form action="code.php" method="POST">

                <?php
                $paramValue = checkParam('id');

                $categoryData = getSingleData('categories', $paramValue);
                if ($categoryData) {
                    if ($categoryData['status'] == 200) {
                ?>
                        <input type="hidden" name="categoryId" value="<?= $categoryData['data']['id']; ?>">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Name *
                                </label>
                                <input type="text" name="name" value="<?= $categoryData['data']['name']; ?>" required class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Description
                                </label>

                                <textarea name="description" class="form-control" rows="3"><?= $categoryData['data']['description']; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="">
                                    Status (Unchecked=visible, Checked=Hidden)
                                </label>
                                <br>

                                <input type="checkbox" name="status" <?= $categoryData['data']['status'] == true ? "checked" : ""; ?> style="width: 30px; height: 30px;">
                            </div>



                            <div class="col-md-6 mb-3 text-end">
                                <button type="submit" name="updateCategory" class="btn btn-primary">UPDATE</button>
                            </div>

                        </div>
                <?php
                    } else {
                        echo '<h5>' . $adminData['message'] . '</h5>';
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