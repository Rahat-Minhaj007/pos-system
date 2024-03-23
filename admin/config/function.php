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

// get all data from database using this function

function getAllData($tableName, $status)
{
    global $connect;

    $table = validate($tableName);
    $status = validate($status);

    if ($status == "status") {
        $query = "SELECT * FROM $table WHERE status = '0'";
    } else {
        $query = "SELECT * FROM $table";
    }

    $result = mysqli_query($connect, $query);

    return $result;
}

// get single data from database using this function

function getSingleData($tableName, $id)
{
    global $connect;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($connect, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Data found',
            ];
            return $response;
        } else {
            $response = [
                'status' => 404,
                'message' => 'Data not found'
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 500,
            'message' => 'Something went wrong'
        ];
        return $response;
    }
}

// delete data from database using this function

function deleteData($tableName, $id)
{
    global $connect;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id = '$id'";
    $result = mysqli_query($connect, $query);

    return $result;
}

// check parameter is set or not

function checkParam($type)
{
    if (isset($_GET[$type])) {
        if ($_GET[$type] != '') {
            return $_GET[$type];
        } else {
            return '<h5>No id found!</h5>';
        }
    } else {
        return '<h5>No id given!</h5>';
    }
}


function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}
