<?php
// Include database connection
require("./includes/config.php");

$connect = mysqli_connect('localhost', 'root', '', 'php_cms');

// Fetch the latest banner (adjust the query based on your structure)
$query = "SELECT banner_image, description FROM banners ORDER BY created_at DESC LIMIT 1";
$result = mysqli_query($connect, $query);
$banner = mysqli_fetch_assoc($result);
?>

<div class="banner">
    <img src="images/<?php echo $banner['banner_image']; ?>" class="img-fluid" alt="Banner Image">
    <p><?php echo htmlspecialchars($banner['description']); ?></p>
</div>
