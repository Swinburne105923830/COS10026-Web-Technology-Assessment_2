<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === "Admin" && $password === "Admin") { 
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: manage.php");
        exit;
    } else {
        $error = "Invalid login.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="page_login">
    <?php include "header.inc"; ?>

    <main>
        <h2>Management Login:</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        
        <form action="login.php" method="post" novalidate="novalidate">
            <fieldset>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <br>
                <input type="submit" value="Login">
            </fieldset>
        </form>
    </main>

    <?php include "footer.inc"; ?>
</body>
</html>
