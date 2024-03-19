<?php

require 'config/function.php';


$paramResultId = checkParam('id');

if (is_numeric($paramResultId)) {
    $adminId = validate($paramResultId);
    $admin = getSingleData('admins', $adminId);
    if ($admin['status'] == 200) {
        $delete = deleteData('admins', $adminId);
        if ($delete) {
            redirect('admins.php', 'Admin deleted successfully');
        } else {
            redirect('admins.php', 'Admin not deleted');
        }
    } else {
        redirect('admins.php', 'Admin not found');
    }
} else {
    redirect('admins.php', 'Invalid id');
}
