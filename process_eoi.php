<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Webpage for apply.php results.">
        <meta name="keywords" content="University jobs, tech jobs, hogwarts jobs, hogwarts">
        <meta name="author" content="Lachlan Andrews">
        <title>Application Submitted</title>
        <link rel="stylesheet" href="styles/style.css">
        <style>
            .inline-p {
                display: inline-block;
            }

            #infoname {
                font-weight: bold;
            }
        </style>
    </head>

    <body>

        <?php include "header.inc" ?>

        <main>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") { // 
                    $firstname = ($_POST["firstname"]);
                    $lastname = ($_POST["lastname"]);
                    $dob = ($_POST["dob"]);
                    $gender = ($_POST["gender"]);
                    $address = ($_POST["address"]);
                    $suburb = ($_POST["suburb"]);
                    $state = ($_POST["state"]);
                    $postcode = ($_POST["postcode"]);
                    $email = ($_POST["email"]);
                    $phone = ($_POST["phone"]);
                    $job_reference = ($_POST["job_reference"]);
                    $skills = ($_POST["skills"]);
                    $other_skills_text = ($_POST["other_skills_text"]);
                    
                    echo "<h2>Application Confirmation</h2>";
                    echo "<p>Thank you for your application.</p>";
                    echo "<p>Before exiting, please confirm that the details you provided are correct.</p>";
                    echo "<hr>";
                    echo "<h3>Personal Details</h3>";

                    if (empty($firstname)) {
                        echo "<p class='inline-p'>First Name is required.</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>First name:</p> <p class='inline-p'>$firstname</p><br>";
                        }

                    if (empty($lastname)) {
                        echo "<p>Last Name is required.</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Last name:</p>  <p class='inline-p'>$lastname</p><br>";
                        }
                    
                        if (empty($dob)) {
                        echo "<p>Date of birth is required.</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Date of Birth:</p>  <p class='inline-p'>$dob</p><br>";
                        }

                    if (empty($gender)) {
                        echo "<p>Gender selection is required.</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Gender:</p>  <p class='inline-p'>$gender</p><br>";
                        }

                    if (empty($address)) {
                        echo "<p>Address entry is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Address:</p>  <p class='inline-p'>$address</p><br>";
                    }

                    if (empty($suburb)) {
                        echo "<p>Suburb entry is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Suburb:</p>  <p class='inline-p'>$suburb</p><br>";
                    }

                    if (empty($state)) {
                        echo "<p>State selection is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>State:</p>  <p class='inline-p'>$state</p><br>";
                    }

                    if (empty($postcode)) {
                        echo "<p>Postcode entry is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Postcode:</p>  <p class='inline-p'>$postcode</p><br>";
                    }

                    if (empty($email)) {
                        echo "<p>Email entry is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Contact Email:</p>  <p class='inline-p'>$email</p><br>";
                    }

                    if (empty($phone)) {
                        echo "<p>Phone number is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Phone Number:</p>  <p class='inline-p'>$phone</p><br>";
                    }

                    echo "<h3>Job Details</h3>";

                    if (empty($job_reference)) {
                        echo "<p>Job reference number is required</p>";
                    }
                    else {
                            echo "<p id='infoname' class='inline-p'>Job Reference Number:</p>  <p class='inline-p'>$job_reference</p><br>";
                    }

                    echo "<p id='infoname' class='inline-p'>Skills List:</p><br>";

                    echo "<ul><li>";
                    echo implode("<li>", $skills);

                    echo "</ul>";

                    echo "<p id='infoname' class='inline-p'>Other Skills:</p>  <p class='inline-p'>$other_skills_text</p><br>";
                }   

            ?>
        
            <hr>

            <p>Any issues? Send us an email at <a href="mailto:info@hogwarts.com">info@hogwarts.com</a> with your application number and any amendments you would like to make.</p>
        
        </main>

        <?php include "footer.inc" ?>

    </body>
</html>