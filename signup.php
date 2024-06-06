<?php
// Get the username and password from the POST request
$username = $_POST["username"];
$password = $_POST["password"];
// Check if the username and password are not empty
if ($username && $password) {
    // Read the users.json file and decode it into an array
    $file = file_get_contents("users.json");
    $data = json_decode($file, true);
    // Check if there is already a user with that username in the data array
    $found = false;
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]["username"] == $username) {
            $found = true;
            break;
        }
    }
    if ($found) {
        // Return an error response
        echo "error";
    } else {
        // Create a new array with the username and password properties
        $user = array(
            "username" => $username,
            "password" => $password
        );
        // Append the new array to the data array
        array_push($data, $user);
        // Encode the data array back into JSON format and write it to the users.json file
        $file = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents("users.json", $file);
        // Return a success response
        echo "success";
    }
} else {
    // Return an error response
    echo "error";
}
?>
