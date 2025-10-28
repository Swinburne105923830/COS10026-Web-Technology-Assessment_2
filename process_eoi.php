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
        .inline-p { display: inline-block; }
        #infoname { font-weight: bold; }
    </style>
</head>
<body>
<?php include "header.inc"; ?>
<main>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Sanitize inputs
    $firstname = clean_input($_POST["firstname"]); 
    $lastname = clean_input($_POST["lastname"]);
    $dob = ($_POST["dob"]);
    $gender = ($_POST["gender"]);
    $address = clean_input($_POST["address"]);
    $suburb = clean_input($_POST["suburb"]);
    $state = ($_POST["state"]);
    $postcode = clean_input($_POST["postcode"]);
    $email = clean_input($_POST["email"]);
    $phone_number = clean_input($_POST["phone"]);
    $job_reference = clean_input($_POST["job_reference"]);

    // Convert checkbox array to string
    $skills = isset($_POST["skills"]) ? implode(", ", array_map('clean_input', $_POST["skills"])) : "";

    $errors = [];

    // Validation
    if (empty($firstname))
        $errors[] = "<p>First Name is required.</p>";
    elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstname))
        $errors[] = "<p>First Name can only contain letters and white space.</p>";
    elseif (mb_strlen($firstname) > 20)
        $errors[] = "<p>First Name must be 20 characters or less.</p>";

    if (empty($lastname))
        $errors[] = "<p>Last Name is required.</p>";
    elseif (!preg_match("/^[a-zA-Z-' ]*$/", $lastname))
        $errors[] = "<p>Last Name can only contain letters and white space.</p>";
    elseif (mb_strlen($lastname) > 20)
        $errors[] = "<p>Last Name must be 20 characters or less.</p>";

    if (empty($dob))
        $errors[] = "<p>Date of Birth is required.</p>";

    if (empty($gender))
        $errors[] = "<p>Gender selection is required.</p>";

    if (empty($address))
        $errors[] = "<p>Address entry is required.</p>";
    elseif (!preg_match("/^[a-zA-Z0-9\s,'-]*$/", $address))
        $errors[] = "<p>Address can only contain letters, numbers, spaces, commas, and hyphens.</p>";
    elseif (mb_strlen($address) > 40)
        $errors[] = "<p>Address must be 40 characters or less.</p>";

    if (empty($suburb))
        $errors[] = "<p>Suburb entry is required.</p>";
    elseif (!preg_match("/^[a-zA-Z\s'-]*$/", $suburb))
        $errors[] = "<p>Suburb can only contain letters, spaces, apostrophes, and hyphens.</p>";
    elseif (mb_strlen($suburb) > 40)
        $errors[] = "<p>Suburb must be 40 characters or less.</p>";

    if (empty($state))
        $errors[] = "<p>State selection is required.</p>";

    if (empty($postcode))
        $errors[] = "<p>Postcode entry is required.</p>";
    elseif (!is_numeric($postcode))
        $errors[] = "<p>Postcode can only contain numbers.</p>";
    elseif (mb_strlen($postcode) != 4)
        $errors[] = "<p>Postcode must be exactly 4 digits.</p>";

    if (empty($email))
        $errors[] = "<p>Email entry is required.</p>";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "<p>Email is not in a valid format.</p>";

    if (empty($phone_number))
        $errors[] = "<p>Phone Number entry is required.</p>";
    elseif (!is_numeric($phone_number))
        $errors[] = "<p>Phone Number can only contain numbers.</p>";
    elseif (mb_strlen($phone_number) < 8 || mb_strlen($phone_number) > 12)
        $errors[] = "<p>Phone Number must be between 8 and 12 digits.</p>";

    // --- JOB REFERENCE VALIDATION (INCLUDING FOREIGN KEY CHECK) ---
    if (empty($job_reference))
        $errors[] = "<p>Job Reference Number is required.</p>";
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $job_reference))
        $errors[] = "<p>Job Reference Number can only contain letters and numbers.</p>";
    elseif (mb_strlen($job_reference) != 5)
        $errors[] = "<p>Job Reference Number must be 5 characters.</p>";
    else {
        // Check if job reference exists in the jobs table
        $query = "SELECT reference_no FROM jobs WHERE reference_no = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $job_reference);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) == 0) {
            $errors[] = "<p>Invalid Job Reference Number. Please enter a valid reference from an existing job listing.</p>";
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($skills))
        $errors[] = "<p>Please select at least one skill.</p>";

    // --- If No Errors ---
    if (empty($errors)) {
        $sql = "INSERT INTO eoi (job_reference, firstname, lastname, dob, gender, address, suburb, state, postcode, email, phone_number, skills)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssssss", 
            $job_reference, $firstname, $lastname, $dob, $gender, 
            $address, $suburb, $state, $postcode, $email, $phone_number, $skills);

        if (mysqli_stmt_execute($stmt)) {
            echo "<h2>Application Submission Successful</h2>";
            echo "<p>Thank you for your application.</p>";
            echo "<p>Please confirm that the details you provided are correct.</p>";
            echo "<hr>";
            echo "<h3>Personal Details</h3>";
            echo "<p id='infoname' class='inline-p'>First name:</p> <p class='inline-p'>" . htmlspecialchars($firstname) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Last name:</p> <p class='inline-p'>" . htmlspecialchars($lastname) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Date of Birth:</p> <p class='inline-p'>" . htmlspecialchars($dob) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Gender:</p> <p class='inline-p'>" . htmlspecialchars($gender) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Address:</p> <p class='inline-p'>" . htmlspecialchars($address) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Suburb:</p> <p class='inline-p'>" . htmlspecialchars($suburb) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>State:</p> <p class='inline-p'>" . htmlspecialchars($state) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Postcode:</p> <p class='inline-p'>" . htmlspecialchars($postcode) . "</p><br>";
            echo "<h3>Contact Details</h3>";
            echo "<p id='infoname' class='inline-p'>Email:</p> <p class='inline-p'>" . htmlspecialchars($email) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Phone Number:</p> <p class='inline-p'>" . htmlspecialchars($phone_number) . "</p><br>";
            echo "<h3>Job Details</h3>";
            echo "<p id='infoname' class='inline-p'>Job Reference Number:</p> <p class='inline-p'>" . htmlspecialchars($job_reference) . "</p><br>";
            echo "<p id='infoname' class='inline-p'>Skills:</p> <p class='inline-p'>" . htmlspecialchars($skills) . "</p><br>";
            echo "<hr>";
            echo "<p>Any issues? Email us at <a href='mailto:info@hogwarts.com'>info@hogwarts.com</a>.</p>";
        } else {
            echo "<p>Database error: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        // --- If Errors Exist ---
        echo "<h2>Submission Error</h2>";
        echo "<p>The following errors were found:</p>";
        echo "<hr><ul>";
        foreach ($errors as $error) echo "<li>$error</li>";
        echo "</ul><hr>";
        echo "<p>Please fix the above and resubmit your application.</p>";
    }
} else {
    header('Location: apply.php');
    exit();
}

mysqli_close($conn);
?>

</main>
<?php include "footer.inc"; ?>
</body>
</html>
