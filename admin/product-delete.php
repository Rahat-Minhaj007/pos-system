<?php

require 'config/function.php';


$paramResultId = checkParam('id');

if (is_numeric($paramResultId)) {
    $productId = validate($paramResultId);
    $product = getSingleData('products', $productId);
    if ($product['status'] == 200) {
        $delete = deleteData('products', $productId);
        if ($delete) {
            $deleteImage = $product['data']['image'];
            if (file_exists($deleteImage)) {
                unlink('../' . $deleteImage);
            }
            redirect('products-list.php', 'Product deleted successfully');
        } else {
            redirect('products-list.php', 'Product not deleted');
        }
    } else {
        redirect('products-list.php', 'Product not found');
    }
} else {
    redirect('products-list.php', 'Invalid id');
}
