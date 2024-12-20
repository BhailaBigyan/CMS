<?php
require("../includes/database.php");
$connect = mysqli_connect('localhost', 'root', '', 'php_cms');
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $content = mysqli_real_escape_string($connect, $_POST['content']);

    // Validate required fields
    if (empty($title) || empty($author) || empty($category) || empty($content)) {
        die("All fields are required!");
    }

    // Insert into database
    $query = "INSERT INTO blog_posts (title, author, category, content, created_at) 
              VALUES ('$title', '$author', '$category', '$content', NOW())";

    if (mysqli_query($connect, $query)) {
        header("Location: manage_posts.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
