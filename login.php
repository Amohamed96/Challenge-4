<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $usersFile = "users.json";
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    $foundUser = null;
    foreach ($users as $user) {
        if ($user["email"] === $email && password_verify($password, $user["password"])) {
            $foundUser = $user;
            break;
        }
    }

    if ($foundUser) {
        $_SESSION["user"] = $foundUser["first_name"];
        header("Location: profile.php"); // Redirect to profile
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <?php if ($error) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="remember"> Remember Me</label>
        <button type="submit">Login</button>
    </form>
    <p><a href="login.php">Forgot Password?</a></p>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>
