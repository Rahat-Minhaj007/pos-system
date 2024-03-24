<?php

require 'config/function.php';


$paramResultId = checkParam('id');

if (is_numeric($paramResultId)) {
    $categoryId = validate($paramResultId);
    $category = getSingleData('categories', $categoryId);
    if ($category['status'] == 200) {
        $delete = deleteData('categories', $categoryId);
        if ($delete) {
            redirect('categories-list.php', 'Category deleted successfully');
        } else {
            redirect('categories-list.php', 'Category not deleted');
        }
    } else {
        redirect('categories-list.php', 'Category not found');
    }
} else {
    redirect('categories-list.php', 'Invalid id');
}
