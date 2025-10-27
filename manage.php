<?php
    require_once "settings.php";
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        //if not logged in, destory the session and redirect to the login page
        session_destroy();
        header('Location: login.php');
        exit;
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

                require_once "settings.php";
                session_start();

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

            
                    $query = "SELECT * FROM eoi";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0){
                        echo "<table border='1' cellpadding='5'>";
                        echo "<tr><th>ID</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Date Of Birth</th><th>Gender</th><th>Street Address</th><th>Suburb</th<th>Postcode</th><th>Email</th><th>Phone Number</th><th>Skill List</th><th>Other Skillsder</th></tr>";
                        while ($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>" . $row['applicant_id'] . "</td>";
                            echo "<td>" . $row['job_reference'] . "</td>";
                            echo "<td>" . $row['first_name'] . "</td>";
                            echo "<td>" . $row['last_name'] . "</td>";
                            echo "<td>" . $row['dob'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['street_address'] . "</td>";
                            echo "<td>" . $row['suburb'] . "</td>";
                            echo "<td>" . $row['postcode'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone_number'] . "</td>";
                            echo "<td>" . $row['skills_list'] . "</td>";
                            echo "<td>" . $row['other_skills'] . "</td>";
                            echo "</tr>";  
                       }
                       echo "</table>";
                    } else {
                        echo "<p>Zero results found</p>";
                    }
                

            ?>

        </main>

        <?php include "footer.inc" ?>

    </body>
</html>