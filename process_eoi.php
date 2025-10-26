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
                session_start();

                function clean_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                }

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
                    $address = clean_input($_POST["address"]);
                    $suburb = clean_input($_POST["suburb"]);
                    $state = ($_POST["state"]);
                    $postcode = clean_input($_POST["postcode"]);
                    $email = clean_input($_POST["email"]);
                    $phone = clean_input($_POST["phone"]);
                    $job_reference = clean_input($_POST["job_reference"]);
                    $skills = ($_POST["skills"]);
                    $other_selected = false;
                    $other_skills_text = clean_input($_POST["other_skills_text"]);

                    // "errors" array is created. This is used to determine how the page is presented if errors are present.
                    $errors = []; 
                    
                    // If the form element is empty, an error message will be added to the errors array.
                    if (empty($firstname)) 
                        $errors[] = "<p>First Name is required.</p>";
                    
                    if (empty($lastname)) 
                        $errors[] = "<p>Last Name is required.</p>";
                    
                    if (empty($dob))
                        $errors[] = "<p>Date of Birth is required.</p>";

                    if (empty($gender))
                        $errors[] = "<p>Gender selection is required</p>";

                    if (empty($address))
                        $errors[] = "<p>Address entry is required</p>";

                    if (empty($suburb))
                        $errors[] = "<p>Suburb entry is required</p>";

                    if (empty($state))
                        $errors[] = "<p>State selection is required</p>";

                    if (empty($postcode))
                        $errors[] = "<p>Postcode entry is required</p>";

                    if (empty($email))
                        $errors[] = "<p>Email entry is required</p>";

                    if (empty($phone))
                        $errors[] = "<p>Phone number entry is required</p>";

                    if (empty($job_reference))
                        $errors[] = "<p>Job Reference Number is required</p>";

                    if (empty($skills))
                        $errors[] = "<p>Skills selection is required</p>";

                    // If the errors array is empty, the webpage will display the information that the user submitted via the form.
                    if (empty($errors)) {
                        echo "<h2>Application Submission Successful</h2>";
                        echo "<p>Thank you for your application.</p>";
                        echo "<p>Before exiting, please confirm that the details you provided are correct.</p>";
                        echo "<hr>";
                        echo "<h3>Personal Details</h3>";
                        echo "<p id='infoname' class='inline-p'>First name:</p> <p class='inline-p'>$firstname</p><br>";
                        echo "<p id='infoname' class='inline-p'>Last name:</p>  <p class='inline-p'>$lastname</p><br>";
                        echo "<p id='infoname' class='inline-p'>Date of Birth:</p>  <p class='inline-p'>$dob</p><br>";
                        echo "<p id='infoname' class='inline-p'>Gender:</p>  <p class='inline-p'>$gender</p><br>";
                        echo "<p id='infoname' class='inline-p'>Address:</p>  <p class='inline-p'>$address</p><br>";
                        echo "<p id='infoname' class='inline-p'>Suburb:</p>  <p class='inline-p'>$suburb</p><br>";
                        echo "<p id='infoname' class='inline-p'>State:</p>  <p class='inline-p'>$state</p><br>";
                        echo "<p id='infoname' class='inline-p'>Postcode:</p>  <p class='inline-p'>$postcode</p><br>";
                        echo "<p id='infoname' class='inline-p'>Contact Email:</p>  <p class='inline-p'>$email</p><br>";
                        echo "<p id='infoname' class='inline-p'>Phone Number:</p>  <p class='inline-p'>$phone</p><br>";
                        echo "<h3>Job Details</h3>";
                        echo "<p id='infoname' class='inline-p'>Job Reference Number:</p>  <p class='inline-p'>$job_reference</p><br>";
                        echo "<p id='infoname' class='inline-p'>Skills List:</p><br>";
                        echo "<ul><li>";
                        echo implode("<li>", $skills);
                        echo "</ul>";
                        echo "<p id='infoname' class='inline-p'>Other Skills:</p>  <p class='inline-p'>$other_skills_text</p><br>";
                        echo "<hr>";
                        echo "<p>Any issues? Send us an email at <a href='mailto:info@hogwarts.com'>info@hogwarts.com</a> with your application number and any amendments you would like to make.</p>";
                    
                    // If an error has been added to the array, the webpage will list the errors and urge the user to resubmit their application.
                    } else
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
                else 
                    header('Location: apply.php') // If a user tries to access the webpage when not submitting a form, they will be redirected to apply.php instead.

            ?>
        
        </main>

        <?php include "footer.inc" ?>

    </body>
</html>