<?php
// Get the name and text from the POST request
$name = $_POST["name"];
$text = $_POST["text"];
// Check if the name and text are not empty
if ($name && $text) {
    // Read the chat.json file and decode it into an array
    $file = file_get_contents("chat.json");
    $data = json_decode($file, true);
    // Create a new array with the name and text properties
    $message = array(
        "name" => $name,
        "text" => $text
    );
    // Append the new array to the data array
    array_push($data, $message);
    // Encode the data array back into JSON format and write it to the chat.json file
    $file = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents("chat.json", $file);
    // Return a success response
    echo "success";
} else {
    // Return an error response
    echo "error";
}
?>
