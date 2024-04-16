<?php
require 'config/function.php';

$paramResultId = checkParam('index');

if (is_numeric($paramResultId)) {
    $indexValue = validate($paramResultId);

    if (isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])) {
        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);
        redirect('order-create.php', 'Product removed successfully !');
    } else {
        redirect('order-create.php', 'Product not found');
    }
} else {
    redirect('order-create.php', 'param not numeric');
}
