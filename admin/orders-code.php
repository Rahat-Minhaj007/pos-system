<?php

include('config/function.php');

// add item to order

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}

if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

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