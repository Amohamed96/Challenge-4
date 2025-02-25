<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Save user data to a JSON file
        $usersFile = "users.json";
        $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

        // Check if email already exists
        foreach ($users as $user) {
            if ($user["email"] === $email) {
                $error = "Email already registered!";
                break;
            }
        }

        if (!$error) {
            $users[] = ["first_name" => $firstName, "last_name" => $lastName, "email" => $email, "password" => $hashedPassword];
            file_put_contents($usersFile, json_encode($users));

            $_SESSION["user"] = $firstName; // Store user session
            header("Location: profile.php"); // Redirect to profile
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Signup</h2>
    <?php if ($error) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
