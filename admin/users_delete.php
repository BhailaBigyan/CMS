<?php
require("../includes/database.php");
require("../includes/functions.php");
secure(true); // Ensures only authenticated users can access this page

// Check if user_id is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Fetch the user to ensure they exist
    $userCheckQuery = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($connect, $userCheckQuery);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // User exists, proceed with deletion
        $deleteQuery = "DELETE FROM users WHERE id = ?";
        $deleteStmt = mysqli_prepare($connect, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $user_id);

        if (mysqli_stmt_execute($deleteStmt)) {
            set_message("User has been successfully deleted.");
        } else {
            set_message("Failed to delete the user. Please try again.");
        }
    } else {
        set_message("User not found.");
    }
    mysqli_stmt_close($stmt);
} else {
    set_message("Invalid user ID.");
}

// Redirect to manage_users.php
header("Location: manage_users.php");
exit;
?>
