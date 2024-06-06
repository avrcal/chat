<html>
<head>
    <title>Chat Website</title>
    <style>
        /* Add your CSS styles here */

        /* Use a dark background for the container */
        #container {
            background-color: #333;
            color: white;
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Use a scrollable box for the messages */
        #messages {
            height: 400px;
            overflow-y: scroll;
            border: 2px solid white;
        }

        /* Use a different background color for each message */
        .message {
            background-color: #444;
            margin: 10px;
            padding: 10px;
        }

        /* Use a lighter color for the name */
        .name {
            color: #ccc;
        }

        /* Use a rounded border for the input fields */
        #input input {
            border-radius: 10px;
        }

        /* Use a green button for the send button */
        #send {
            background-color: green;
            color: white;
            border-radius: 10px;
        }

        /* Hide the chat section by default */
        #chat {
            display: none;
        }

        /* Use a blue button for the signup and login buttons */
        #signup, #login {
            background-color: blue;
            color: white;
            border-radius: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="container">
        <div id="auth">
            <!-- Signup and login forms will be displayed here -->
            <div id="signup-form">
                <h2>Signup</h2>
                <input type="text" id="signup-username" placeholder="Enter your username">
                <input type="password" id="signup-password" placeholder="Enter your password">
                <button id="signup">انشاء حساب</button>
                <p>عندك حساب؟ <a href="#" id="show-login">سجل دخول</a></p>
            </div>
            <div id="login-form">
                <h2>سجل دخول</h2>
                <input type="text" id="login-username" placeholder="Enter your username">
                <input type="password" id="login-password" placeholder="Enter your password">
                <button id="login">سجل دخول</button>
                <p>ما عندك حساب؟ <a href="#" id="show-signup">انشاء حساب</a></p>
            </div>
        </div>
        <div id="chat">
            <!-- Chat section will be displayed here -->
            <div id="messages">
                <!-- Chat messages will be displayed here -->
            </div>
            <div id="input">
                <input type="text" id="name" placeholder="Enter your name">
                <input type="text" id="message" placeholder="Enter your message">
                <button id="send">Send</button>
            </div>
        </div>
    </div>
    <script>
        // Add your JavaScript code here
        $(document).ready(function() {
            
            // Hide the login form by default
            $("#login-form").hide();

            // Show the login form when the show-login link is clicked
            $("#show-login").click(function() {
                $("#signup-form").hide();
                $("#login-form").show();
            });

            // Show the signup form when the show-signup link is clicked
            $("#show-signup").click(function() {
                $("#login-form").hide();
                $("#signup-form").show();
            });

            // Signup a new user using PHP
            function signupUser(username, password) {
                // Create an object with the username and password properties
                var user = {
                    username: username,
                    password: password
                };
                // Send a POST request to the PHP script with the user object as data
                $.post("signup.php", user, function(response) {
                    // Check if the response is success
                    if (response == "success") {
                        // Display a success message
                        alert("You have signed up successfully. Please login to continue.");
                        // Show the login form
                        $("#signup-form").hide();
                        $("#login-form").show();
                    } else {
                        // Display an error message
                        alert("Something went wrong. Please try again.");
                    }
                });
            }

             // Login an existing user using PHP
             function loginUser(username, password) {
                // Create an object with the username and password properties
                var user = {
                    username: username,
                    password: password
                };
                // Send a POST request to the PHP script with the user object as data
                $.post("login.php", user, function(response) {
                    // Check if the response is success
                    if (response == "success") {
                        // Display a success message
                        alert("You have logged in successfully.");
                        // Hide the auth section and show the chat section
                        $("#auth").hide();
                        $("#chat").show();
                        // Set the name input field to the username
                        $("#name").val(username);
                        // Load the chat messages
                        loadMessages();
                    } else {
                        // Display an error message
                        alert("Invalid username or password. Please try again.");
                    }
                });
            }

            // Handle the click event of the signup button
            $("#signup").click(function() {
                // Get the username and password from the input fields
                var username = $("#signup-username").val();
                var password = $("#signup-password").val();
                // Check if the username and password are not empty
                if (username && password) {
                    // Call the signupUser function with the username and password as arguments
                    signupUser(username, password);
                } else {
                    // Display a warning message
                    alert("Please enter your username and password.");
                }
            });

            // Handle the click event of the login button
            $("#login").click(function() {
                // Get the username and password from the input fields
                var username = $("#login-username").val();
                var password = $("#login-password").val();
                // Check if the username and password are not empty
                if (username && password) {
                    // Call the loginUser function with the username and password as arguments
                    loginUser(username, password);
                } else {
                    // Display a warning message
                    alert("Please enter your username and password.");
                }
            });

            // Load the chat messages from the JSON file
            function loadMessages() {
                $.getJSON("chat.json", function(data) {
                    // Clear the messages div
                    $("#messages").empty();
                    // Loop through the data array
                    for (var i = 0; i < data.length; i++) {
                        // Create a message element
                        var message = $("<div class='message'></div>");
                        // Add the name and text to the message element
                        message.append("<p class='name'>" + data[i].name + "</p>");
                        message.append("<p class='text'>" + data[i].text + "</p>");
                        // Append the message element to the messages div
                        $("#messages").append(message);
                    }
                });
            }

            // Call the loadMessages function every 5 seconds
            setInterval(loadMessages, 5000);

            // Send a chat message to the JSON file using PHP
            function sendMessage(name, text) {
                // Create an object with the name and text properties
                var message = {
                    name: name,
                    text: text
                };
                // Send a POST request to the PHP script with the message object as data
                $.post("chat.php", message, function(response) {
                    // Check if the response is success
                    if (response == "success") {
                        // Clear the message input field
                        $("#message").val("");
                        // Reload the messages
                        loadMessages();
                    } else {
                        // Display an error message
                        alert("Something went wrong. Please try again.");
                    }
                });
            }

            // Handle the click event of the send button
            $("#send").click(function() {
                // Get the name and message from the input fields
                var name = $("#name").val();
                var message = $("#message").val();
                // Check if the name and message are not empty
                if (name && message) {
                    // Call the sendMessage function with the name and message as arguments
                    sendMessage(name, message);
                } else {
                    // Display a warning message
                    alert("Please enter your name and message.");
                }
            });
        });
    </script>
</body>
</html>
