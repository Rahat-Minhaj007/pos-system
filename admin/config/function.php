<?php

session_start();

require "dbcon.php";

//input filed validation
function validate($inputData)
{
    global $connect;
    $validateData = mysqli_real_escape_string($connect, $inputData);

    return trim($validateData);
}


// redirect to 1 page to another page with the message (status)

function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header("Location: " . $url);
    exit(0);
}

// display message or status after any process

function alertMessage()
{
    if (isset($_SESSION['status'])) {

        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <h6>' . $_SESSION['status'] . '</h6>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

        unset($_SESSION['status']);
    }
}
