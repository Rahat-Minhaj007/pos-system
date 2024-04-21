<?php

include('config/function.php');

// add item to order

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}

if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}



// add item to order
if (isset($_POST['addItem'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $query = "SELECT * FROM products WHERE id='$productId' LIMIT 1";

    $checkProduct = mysqli_query($connect, $query);

    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) {
            $product = mysqli_fetch_assoc($checkProduct);

            if ($product['quantity'] < $quantity) {
                redirect('order-create.php', 'Only' . $product['quantity'] . 'quantity available');
            }
            $productData = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']

            ];

            if (!in_array($product['id'], $_SESSION['productItemIds'])) {
                array_push($_SESSION['productItemIds'], $product['id']);
                array_push($_SESSION['productItems'], $productData);
            } else {

                foreach ($_SESSION['productItems'] as $key => $productSessionItem) {
                    if ($productSessionItem['product_id'] == $product['id']) {

                        $newQuantity = $productSessionItem['quantity'] + $quantity;

                        $productData = [
                            'product_id' => $product['id'],
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'quantity' => $newQuantity,
                            'image' => $product['image']
                        ];

                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }

            redirect('order-create.php', 'Item added ' . $product['name']);
        } else {
            redirect('order-create.php', 'Product not found');
        }
    } else {
        redirect('order-create.php', 'Something went wrong');
    }
}


// product  quantity increase or decrease
if (isset($_POST['productIncDec'])) {

    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    error_log("Product ID: " . $productId);
    error_log("Quantity: " . $quantity);

    $flag = false;

    foreach ($_SESSION['productItems'] as $key => $productItem) {

        if ($productItem['product_id'] == $productId) {
            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if ($flag) {
        jsonResponse(200, 'success', 'Quantity updated');
    } else {
        jsonResponse(500, 'error', 'Something went wrong, please try again');
    }
}

// proceed to place order
if (isset($_POST['proceedToPlaceBtn'])) {

    $phone = validate($_POST['cphone']);
    $payment_method = validate($_POST['payment_method']);

    // checking customer

    $query = "SELECT * FROM customers WHERE phone='$phone' LIMIT 1";

    $checkCustomer = mysqli_query($connect, $query);

    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = 'INV' . rand(100000, 999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_method'] = $payment_method;

            jsonResponse(200, 'success', 'Customer found, please proceed to place order');
        } else {
            $_SESSION['cphone'] = $phone;

            jsonResponse(404, 'warning', 'Customer not found, please add customer details');
        }
    } else {
        jsonResponse(500, 'error', 'Something went wrong, please try again');
    }
}


if (isset($_POST['saveCustomerBtn'])) {
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    if ($name != "" && $phone != "") {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email

        ];

        $result = insert("customers", $data);
        if ($result) {
            jsonResponse(200, 'success', 'Customer added successfully');
        } else {
            jsonResponse(500, 'error', 'Something went wrong, please try again');
        }
    } else {
        jsonResponse(422, 'error', 'Please fill all fields');
    }
}
