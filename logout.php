<?php

require('admin/config/function.php');

if (isset($_SESSION['loggedIn'])) {

    logoutSession();
    redirect('login.php', 'Successfully logged out!');
}
