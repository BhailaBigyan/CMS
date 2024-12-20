<?php
session_start();
require('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['message'] = "Password reset instructions sent to your email.";
        // Here, you would send a reset link (implement email functionality).
    } else {
        $error = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($_SESSION['message'])) echo "<p style='color:green;'>{$_SESSION['message']}</p>"; unset($_SESSION['message']); ?>
    <form method="POST" action="forget.php">
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
