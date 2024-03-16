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

// insert data into database using this function

function insert($tableName, $data)
{

    global $connect;

    $table = validate($tableName);

    $column = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $column);

    $finalValues = "'" . implode("', '", $values) . "'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($connect, $query);

    return $result;
}

// update data into database using this function

function update($tableName, $id, $data)
{
    global $connect;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";
    foreach ($data as $column => $value) {
        $updateDataString .= $column . '=' . "'$value',";
    }

    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id = $id";
    $result = mysqli_query($connect, $query);

    return $result;
}
