<?php

if (!function_exists('secure')) {
    function secure() {
        if (!isset($_SESSION['id'])) {
            set_message("Please log in to access this page.");
            header('Location: ./manage_posts.php');
            exit;
        }
    
        // If the page is for admin only, ensure the user is an admin
       
    }
        if ($adminOnly && (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1)) {
            set_message("You do not have permission to access this page.");
            header('Location: /dashboard.php'); // Redirect to dashboard if not admin
            exit;
        }
    }
    function secure($adminOnly = false) {
    
    
}

if (!function_exists('set_message')) {
    function set_message($message) {
        $_SESSION['message'] = $message;
    }
}

if (!function_exists('get_message')) {
    function get_message() {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            echo "<script type='text/javascript'> showToast('" . $message . "','top right' , 'success') </script>";
            unset($_SESSION['message']);
        }
    }
}


// Function to count total users
function count_users($conn) {
    $query = "SELECT COUNT(*) AS total_users FROM users";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        return $data['total_users'];
    }
    return 0; // Return 0 if query fails
}
// Function to count total blog posts
function count_posts($conn) {
    $query = "SELECT COUNT(*) AS total_posts FROM blog_posts";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        return $data['total_posts'];
    }
    return 0; // Return 0 if query fails
}
