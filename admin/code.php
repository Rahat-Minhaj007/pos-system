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
