<?php
require("../includes/database.php");
require("../includes/functions.php");

// Secure admin access
secure();



if (isset($_GET['id'])) {
    // Get the post ID
    $id = $_GET['id'];

    // Delete the post from the database
    $query = "DELETE FROM blog_posts WHERE id = '$id'";

    if (mysqli_query($connect, $query)) {
        set_message("Post deleted successfully!");
    } else {
        set_message("Error deleting post. Please try again.");
    }

    header("Location: manage_posts.php");
    exit;
} else {
    set_message("Invalid request.");
    header("Location: manage_posts.php");
    exit;
}
?>
