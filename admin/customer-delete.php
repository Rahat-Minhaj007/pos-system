<?php

require 'config/function.php';


$paramResultId = checkParam('id');

if (is_numeric($paramResultId)) {
    $customerId = validate($paramResultId);
    $customer = getSingleData('customers', $customerId);
    if ($customer['status'] == 200) {
        $delete = deleteData('customers', $customerId);
        if ($delete) {
            redirect('customers-list.php', 'customer deleted successfully');
        } else {
            redirect('customers-list.php', 'customer not deleted');
        }
    } else {
        redirect('customers-list.php', 'customer not found');
    }
} else {
    redirect('customers-list.php', 'Invalid id');
}
