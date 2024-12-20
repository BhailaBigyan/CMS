<?php
require("../includes/database.php");
require("../includes/functions.php");
session_start();

// Secure admin access
secure();

if (!$_SESSION['is_admin']) {
    set_message("Access Denied! You are not authorized to view this page.");
    header("Location: /");
    exit;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $user_id = $_POST['id'];
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // If password is provided, hash it. Otherwise, keep the old password.
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password', is_admin = '$role' WHERE id = '$user_id'";
    } else {
        // Update without changing the password
        $query = "UPDATE users SET username = '$username', email = '$email', is_admin = '$role' WHERE id = '$user_id'";
    }

    // Execute the query
    $result = mysqli_query($connect, $query);

    if ($result) {
        set_message("User updated successfully.");
    } else {
        set_message("Error updating user: " . mysqli_error($connect));
    }

    // Redirect to the manage users page
    header("Location: manage_users.php");
    exit;
}
// Assuming you have a function to display messages (like flash messages)
function set_message($message) {
    $_SESSION['message'] = $message;
}

function display_message() {
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
}

?>
