<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - NBA Stats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="posts.php">Posts</a></li>
            <li><a href="create_post.php">New Post</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user); ?>!</h1>
        <p>This is your profile page.</p>
    </header>

    <section>
        <h2>Your Account Details</h2>
        <p>Name: <?php echo htmlspecialchars($user); ?></p>
        <p></p>
    </section>

    <footer>
        <p><a href="logout.php">Logout</a></p>
    </footer>

</body>
</html>
