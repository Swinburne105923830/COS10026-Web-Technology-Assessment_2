

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
?>

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
        <?php include "header.inc"; ?>
        <?php include "nav.inc"; ?>
    </head>
    <body>
        <main>
    
    <?php

                // If the webpage is accessed through posting an HTML form.
                if ($_SERVER["REQUEST_METHOD"] == "POST") { 

                    /* 
                    Created variables for each element in the form.
                    The clean_input function is added to all form elements that require text input from the user.
                    */
                    $firstname = clean_input($_POST["firstname"]); 
                    $lastname = clean_input($_POST["lastname"]);
                    $dob = ($_POST["dob"]);
                    $gender = ($_POST["gender"]);
                    $street_address = clean_input($_POST["address"]);
                    $suburb = clean_input($_POST["suburb"]);
                    $state = ($_POST["state"]);
                    $postcode = clean_input($_POST["postcode"]);
                    $email = clean_input($_POST["email"]);
                    $phone = clean_input($_POST["phone"]);
                    $job_reference = clean_input($_POST["job_reference"]);
                    $skills_list = isset($_POST["skills"]) ? $_POST["skills"] : []; //Made sure atleast one box needs to be selected
                    $other_selected = false;
                    $other_skills = clean_input($_POST["other_skills_text"]);

                    // "errors" array is created. This is used to determine how the page is presented if errors are present.
                    $errors = []; 
                    
                    // If the form element is empty, an error message will be added to the errors array.
                    if (empty($firstname)) 
                        $errors[] = "<p>First Name is required.</p>";
                    
                    //If the form element does not match the required format, an error message will be added to the array.
                    elseif (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) // Entry can only contain letters, white space and certain special characters (' and -).
                        $errors[] = "<p>First Name can only contain letters and white space.</p>";

                    // If the form element is outside of the character limit, an error message will be added to the array.
                    elseif (mb_strlen($firstname) > 20) // Entry must be 20 characters or less.
                        $errors[] = "<p>First Name must be 20 characters or less.<p>";
                    
                    if (empty($lastname)) 
                        $errors[] = "<p>Last Name is required.</p>";
                    elseif (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) // Entry can only contain letters, white space and certain special characters (' and -).
                        $errors[] = "<p>Last Name can only contain letters and white space.</p>";
                    elseif (mb_strlen($lastname) > 20) // Entry must be 20 characters or less.
                        $errors[] = "<p>Last Name must be 20 characters or less.<p>";
                    
                    if (empty($dob))
                        $errors[] = "<p>Date of Birth is required.</p>";

                    if (empty($gender))
                        $errors[] = "<p>Gender selection is required</p>";

                    if (empty($address))
                        $errors[] = "<p>Address entry is required</p>";
                    elseif (!preg_match("/^[a-zA-Z0-9-' ]*$/",$address)) // Entry can only contain letters, numbers, white space and cetrain special characters.
                        $errors[] = "<p>Address can only contain letters, numbers and white space.</p>";
                    elseif (mb_strlen($address) > 40) // Entry must be 40 characters or less.
                        $errors[] = "<p>Address must be 40 characters or less.<p>";

                    if (empty($suburb))
                        $errors[] = "<p>Suburb entry is required</p>";
                    elseif (!preg_match("/^[a-zA-Z ]*$/",$suburb)) // Entry can only contain letters and white space.
                        $errors[] = "<p>Suburb can only contain letters and white space.</p>";
                    elseif (mb_strlen($suburb) > 40) // Entry must be 20 characters or less.
                        $errors[] = "<p>Suburb must be 40 characters or less.<p>";

                    if (empty($state))
                        $errors[] = "<p>State selection is required</p>";

                    if (empty($postcode))
                        $errors[] = "<p>Postcode entry is required</p>";
                    elseif (!is_numeric($postcode)) // Entry can only contain numbers.
                        $errors[] = "<p>Postcode can only contain numbers.";
                    elseif (mb_strlen($postcode) > 4 || mb_strlen($postcode) < 4) // Entry must be 4 characters exactly.
                        $errors[] = "<p>Postcode must be 4 characters.<p>";

                    if (empty($email))
                        $errors[] = "<p>Email entry is required</p>";
                    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validates whether the user input is in a valid email format.
                        $errors[] = "<p>Email submitted in an invalid format</p>";

                    if (empty($phone))
                        $errors[] = "<p>Phone Number entry is required</p>";
                    elseif (!is_numeric($phone)) // Entry can only contain numbers.
                        $errors[] = "<p>Phone Number can only contain numbers.";
                    elseif (mb_strlen($phone) > 12 || mb_strlen($phone) < 8) // Entry must between 8 and 12 characters.
                        $errors[] = "<p>Phone Number must be between 8 and 12 characters.<p>";

                    if (empty($job_reference))
                        $errors[] = "<p>Job Reference Number is required</p>";
                    elseif (!preg_match("/^[a-zA-Z0-9]*$/",$job_reference)) // Entry can only contain letters and numbers.
                        $errors[] = "<p>Job Reference Number can only contain letters and numbers.</p>";
                    elseif (mb_strlen($job_reference) > 5 || mb_strlen($job_reference) < 5) // Entry must be 5 characters exactly.
                        $errors[] = "<p>Job Reference Number must be 5 characters.<p>";
                    
                    if (empty($skills))
                        $errors[] = "<p>Skills selection is required</p>";

                    // If the errors array is empty, the webpage will display the information that the user submitted via the form.
                    if (empty($errors)){

                        $sql = "INSERT INTO eoi (job_reference, first_name, last_name, dob, gender, street_address, suburb, state, postcode, email, phone_number, skill_list, other_skills) 
                        VALUES('$job_reference', '$first_name','$$last_name', '$dob', '$gender', '$street_address', 
                                '$suburb', '$state', '$postcode', '$email', '$phone_number', '$skill_list, '$other_skills')";

                        echo "<h2>Application Submission Successful</h2>";
                        echo "<p>Thank you for your application.</p>";
                        echo "<p>Before exiting, please confirm that the details you provided are correct.</p>";
                        echo "<hr>";
                        echo "<h3>Personal Details</h3>";
                        echo "<p id='infoname' class='inline-p'>First name:</p> <p class='inline-p'>$firstname</p><br>";
                        echo "<p id='infoname' class='inline-p'>Last name:</p>  <p class='inline-p'>$lastname</p><br>";
                        echo "<p id='infoname' class='inline-p'>Date of Birth:</p>  <p class='inline-p'>$dob</p><br>";
                        echo "<p id='infoname' class='inline-p'>Gender:</p>  <p class='inline-p'>$gender</p><br>";
                        echo "<p id='infoname' class='inline-p'>Address:</p>  <p class='inline-p'>$street_address</p><br>";
                        echo "<p id='infoname' class='inline-p'>Suburb:</p>  <p class='inline-p'>$suburb</p><br>";
                        echo "<p id='infoname' class='inline-p'>State:</p>  <p class='inline-p'>$state</p><br>";
                        echo "<p id='infoname' class='inline-p'>Postcode:</p>  <p class='inline-p'>$postcode</p><br>";
                        echo "<h3>Contact Details</h3>";
                        echo "<p id='infoname' class='inline-p'>Email:</p>  <p class='inline-p'>$email</p><br>";
                        echo "<p id='infoname' class='inline-p'>Phone Number:</p>  <p class='inline-p'>$phone_number</p><br>";
                        echo "<h3>Job Details</h3>";
                        echo "<p id='infoname' class='inline-p'>Job Reference Number:</p>  <p class='inline-p'>$job_reference</p><br>";
                        echo "<p id='infoname' class='inline-p'>Skills List:</p><br>";
                        echo "<ul><li>";
                        echo implode("<li>", $skills);
                        echo "</ul>";
                        echo "<p id='infoname' class='inline-p'>Other Skills:&nbsp;</p>";
                        if (empty($other_skills_text)){
                            echo "<p class='inline-p'>N/A</p><br>";
                        }
                        else {
                            echo "<p class='inline-p'>$other_skills</p><br>";
                        }
                        
                        echo "<hr>";
                        echo "<p>Any issues? Send us an email at <a href='mailto:info@hogwarts.com'>info@hogwarts.com</a> with your application number and any amendments you would like to make.</p>";
                    }
                        
                    
                    // If an error has been added to the array, the webpage will list the errors and urge the user to resubmit their application.
                    else {
                        echo "<h2>Submission Error</h2>";
                        echo "<p>The following errors have been found in your application:<p>";
                        echo "<hr>";
                        echo "<ul>";
                        foreach ($errors as $error)
                            echo "<li>$error</li>";
                        echo "</ul>";
                        echo "<hr>";
                        echo "<p>Please address these issues before resubmitting your application.";
                        echo "<p>Any issues? Send us an email at <a href='mailto:info@hogwarts.com'>info@hogwarts.com</a>.</p>";
                    }
                        
                } 
                else 
                    header('Location: apply.php') // If a user tries to access the webpage when not submitting a form, they will be redirected to apply.php instead.

            ?>
        
        </main>

        <?php include "footer.inc" ?>

    </body>
</html>