<?php

include('config/function.php');


// create admin data
if (isset($_POST['saveAdmin'])) {

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($name != "" && $email != "" && $password != "") {
        $emailCheck = mysqli_query($connect, "SELECT * FROM admins WHERE email='$email'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect("admins-create.php", "Email already used by another user. ");
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);


        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];


        $result = insert('admins', $data);
        if ($result) {

            redirect("admins.php", "Admin created successfully!");
        } else {
            redirect("admins-create.php", "Something went wrong!");
        }
    } else {
        redirect("admins-create.php", "please fill required fields. ");
    }
}


// update admin data 
if (isset($_POST['updateAdmin'])) {

    $adminId = validate($_POST['adminId']);

    $adminData = getSingleData('admins', $adminId);

    if ($adminData['status'] != 200) {
        redirect("admins-edit.php?id=" . $adminId, "Data not found!");
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    $emailCheckQuery = "SELECT * FROM admins WHERE email='$email' AND id != '$adminId'";
    $emailCheck = mysqli_query($connect, $emailCheckQuery);
    if ($emailCheck) {
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect("admins-edit.php?id=" . $adminId, "Email already used by another user. ");
        }
    }


    if ($password != '') {
        $hashed_Password = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashed_Password = $adminData['data']['password'];
    }


    if ($name != "" && $email != "") {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashed_Password,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];


        $result = update('admins', $adminId, $data);
        if ($result) {

            redirect("admins-edit.php?id=" . $adminId, "Admin updated successfully!");
        } else {
            redirect("admins-edit.php?id=" . $adminId, "Something went wrong. ");
        }
    } else {
        redirect("admins-edit.php?id=" . $adminId, "please fill required fields. ");
    }
}

if (isset($_POST["saveCategory"])) {

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($name != "") {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status
        ];

        $result = insert('categories', $data);
        if ($result) {
            redirect("categories-list.php", "Category created successfully!");
        } else {
            redirect("create-category.php", "Something went wrong!");
        }
    } else {
        redirect("create-category.php", "Please fill required fields. ");
    }
}


if (isset($_POST['updateCategory'])) {


    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($name != "") {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status
        ];

        $result = update('categories', $categoryId, $data);
        if ($result) {
            redirect("categories-edit.php?id=" . $categoryId, "Category updated successfully!");
        } else {
            redirect("categories-edit.php?id=" . $categoryId, "Something went wrong!");
        }
    } else {
        redirect("categories-edit.php?id=" . $categoryId, "Please fill required fields. ");
    }
}


if (isset($_POST['saveProduct'])) {

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);

    if ($name != "" && $price != "" && $quantity != "" && $category_id != "") {


        if ($_FILES['image']['size'] > 0) {

            $path = '../assets/uploads/products';
            $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '.' . $image_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $fileName);

            $finalImage = "assets/uploads/products/" . $fileName;
        } else {
            $finalImage = "";
        }

        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $finalImage
        ];

        $result = insert('products', $data);
        if ($result) {
            redirect("products-list.php", "Product created successfully!");
        } else {
            redirect("products-category.php", "Something went wrong!");
        }
    } else {
        redirect("create-product.php", "Please fill required fields. ");
    }
}


if (isset($_POST['updateProduct'])) {

    $productId = validate($_POST['productId']);

    $productData = getSingleData('products', $productId);

    if (!$productData) {
        redirect("product-list.php", "No such a product found!");
    }

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);

    if ($name != "" && $price != "" && $quantity != "" && $category_id != "") {


        if ($_FILES['image']['size'] > 0) {

            $path = '../assets/uploads/products';
            $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '.' . $image_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $fileName);

            $finalImage = "assets/uploads/products/" . $fileName;

            $deleteImage = "../" . $productData['data']['image'];

            if (file_exists($deleteImage)) {
                unlink($deleteImage);
            }
        } else {
            $finalImage = $productData['data']['image'];
        }

        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $finalImage
        ];

        $result = update('products', $productId, $data);
        if ($result) {
            redirect("product-edit.php?id=" . $productId, "Product updated successfully!");
        } else {
            redirect("product-edit.php?id=" . $productId, "Something went wrong!");
        }
    } else {
        redirect("product-edit.php?id=" . $productId, "Please fill required fields. ");
    }
}

if (isset($_POST["saveCustomer"])) {

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($name != "") {

        $emailCheck = mysqli_query($connect, "SELECT * FROM customers WHERE email='$email'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect("customer-create.php", "Email already used by another user. ");
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];

        $result = insert('customers', $data);
        if ($result) {
            redirect("customers-list.php", "Customer created successfully!");
        } else {
            redirect("customer-create.php", "Something went wrong!");
        }
    } else {
        redirect("customer-create.php", "Please fill required fields. ");
    }
}


if (isset($_POST["updateCustomer"])) {

    $customerId = validate($_POST['customerId']);

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($name != "") {

        $emailCheck = mysqli_query($connect, "SELECT * FROM customers WHERE email='$email'AND id != '$customerId'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect("customer-edit.php?id=" . $customerId, "Email already used by another user. ");
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];

        $result = update('customers', $customerId, $data);
        if ($result) {
            redirect("customer-edit.php?id=" . $customerId, "Customer updated successfully!");
        } else {
            redirect("customer-edit.php?id=" . $customerId, "Something went wrong!");
        }
    } else {
        redirect("customer-edit.php?id=" . $customerId, "Please fill required fields. ");
    }
}
