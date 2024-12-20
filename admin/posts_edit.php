<?php
require("../includes/database.php");
require("../includes/functions.php");

// Secure admin access
secure();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $id = $_POST['id']; // Post ID
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $content = mysqli_real_escape_string($connect, $_POST['description']);

    // Validate inputs
    if (empty($title) || empty($author) || empty($category) || empty($content)) {
        set_message("All fields are required!");
        header("Location: manage_posts.php");
        exit;
    }

    // Update the post in the database
    $query = "UPDATE blog_posts SET title = '$title', author = '$author', category = '$category', description = '$description' WHERE id = '$id'";

    if (mysqli_query($connect, $query)) {
        set_message("Post updated successfully!");
    } else {
        set_message("Error updating post. Please try again.");
    }

    header("Location: manage_posts.php");
    exit;
}
?>
