<?php
session_start();
require('includes/database.php');
include './includes/header.php';

function setSessionInHeader($sessionData)
{
    header('Session-Data: ' . json_encode($sessionData));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $connect->prepare("SELECT id, username, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            setSessionInHeader($_SESSION);

                header("Location: admin/dashboard.php");
            } else {
                $_SESSION['id'] = $user['id'];
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
?>

<div class="login-form">
    <h2>Login</h2>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
    </form>
</div>

<?php include './includes/footer.php'; ?>