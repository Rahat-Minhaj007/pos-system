<?php
include("includes/header.php");
?>


<div class="container-fluid px-4">

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="products-list.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php
            alertMessage();
            ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">
                <?php
                $paramValue = checkParam('id');
                $productData = getSingleData('products', $paramValue);
                if ($productData) {
                    if ($productData['status'] == 200) {

                ?>
                        <input type="hidden" name="productId" value="<?= $productData['data']['id']; ?>">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Select Category *
                                </label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = getAllData('categories', null);
                                    if ($categories) {
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $categoryItem) {
                                                $is_selected = $productData['data']['category_id'] == $categoryItem['id'] ? "selected" : "";
                                                echo '<option value="' . $categoryItem['id'] . '" ' . $is_selected . '>' . $categoryItem['name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No Category Found</option>';
                                        }
                                    } else {
                                        echo '<option value="">Something went wrong!</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Product Name *
                                </label>
                                <input type="text" name="name" value="<?= $productData['data']['name']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">
                                    Price *
                                </label>
                                <input type="text" name="price" value="<?= $productData['data']['price']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">
                                    Quantity *
                                </label>
                                <input type="text" name="quantity" value="<?= $productData['data']['quantity']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">
                                    Image *
                                </label>
                                <input type="file" name="image" class="form-control">
                                <br>
                                <img src="../<?= $productData['data']['image']; ?>" alt="ProductImage" style="width:150px;height:150px;object-fit: contain;">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">
                                    Description
                                </label>

                                <textarea name="description" class="form-control" rows="3"><?= $productData['data']['description']; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="">
                                    Status (Unchecked=visible, Checked=Hidden)
                                </label>
                                <br>

                                <input type="checkbox" name="status" <?= $productData['data']['status'] == true ? "checked" : ""; ?> style="width: 30px; height: 30px;">
                            </div>



                            <div class="col-md-6 mb-3 text-end">
                                <button type="submit" name="updateProduct" class="btn btn-primary">UPDATE</button>
                            </div>

                        </div>

                <?php
                    } else {
                        echo '<h5>' . $productData['message'] . '</h5>';
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