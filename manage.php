<?php
    require_once "settings.php";
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        //if not logged in, destory the session and redirect to the login page
        session_destroy();
        header('Location: login.php');
        exit;
    }

    function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
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
            
    
            <?php

             function run_manage() {
                echo "<h2>Management Search</h2>";
                echo "<form action='manage.php' method='get' novalidate='novalidate'>";
                echo "<fieldset>";
                echo "<legend>EOI Search</legend>";
                echo "<select name='search>";
                echo "<option value=''>List by...</option>";
                echo "<option value='list_all'>All EOIs</option>";
                echo "<option value='list_ref'>Job Reference Number</option>";
                echo "<option value='list_name'>Applicant Name</option>";
                echo "</select>";
                echo "<br>";
                echo "<input type='submit' value='Search'>";
                echo "</fieldset>";
                echo "</form>";
             }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = clean_input($_POST['username']);
                $password = clean_input($_POST['password']);

                if ($username === "Admin" && $password === "Admin")
                    run_manage();
                else 
                    header('Location: login.php');

            } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
                run_manage();
            } 
            else {
                header('Location: login.php');
            }
                

            ?>

        </main>

        <?php include "footer.inc" ?>

    </body>
</html>