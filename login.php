<?php
// Get the username and password from the POST request
$username = $_POST["username"];
$password = $_POST["password"];
// Check if the username and password are not empty
if ($username && $password) {
    // Read the users.json file and decode it into an array
    $file = file_get_contents("users.json");
    $data = json_decode($file, true);
    // Check if there is a user with that username and password in the data array
    $found = false;
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]["username"] == $username && $data[$i]["password"] == $password) {
            $found = true;
            break;
        }
    }
    if ($found) {
        // Return a success response
        echo "success";
    } else {
        // Return an error response
        echo "error";
    }
} else {
    // Return an error response
    echo "error";
}
?>
