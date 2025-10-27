<?php
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Webpage for managing database tables.">
        <meta name="keywords" content="University jobs, tech jobs, hogwarts jobs, hogwarts">
        <meta name="author" content="Lachlan Andrews">
        <title>Management</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        
        <?php include "header.inc"; ?>
        
        <main>
            <h2>Management Login:</h2>
            <form action="manage.php" method="post" novalidate="novalidate">
                <fieldset>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <br>
                <input type='submit' value='Login'>
                </fieldset>
            </form>
            <br>
            <br>
            <br>
            <br>
            
            <?php

            ?>
        </main>
        <?php include "footer.inc"; ?>
    </body>
</html>