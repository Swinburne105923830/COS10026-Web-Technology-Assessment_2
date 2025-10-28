<?php
require_once "settings.php";
session_start();

// ====== AUTH CHECK ======
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// ====== FUNCTIONS ======
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// ====== DATABASE CONNECTION ======
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
}

$feedback = ""; // store messages for the user

// ====== DELETE ACTION ======
if (isset($_POST['delete_ref'])) {
    $ref = clean_input($_POST['delete_ref']);
    $delete_query = "DELETE FROM eoi WHERE job_reference = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("s", $ref);
    $stmt->execute();
    $feedback = "<p class='feedback warning'>All EOIs for job reference <strong>$ref</strong> have been deleted.</p>";
}

// ====== UPDATE STATUS ACTION ======
if (isset($_POST['update_status_id'], $_POST['new_status'])) {
    $id = clean_input($_POST['update_status_id']);
    $status = clean_input($_POST['new_status']);
    $update_query = "UPDATE eoi SET status = ? WHERE applicant_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $feedback = "<p class='feedback success'>EOI #$id status updated to <strong>$status</strong>.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EOI Management</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        /* Add some user-friendly touches directly here */
        .feedback {
            margin: 20px auto;
            padding: 10px 15px;
            width: fit-content;
            border-radius: 8px;
            font-weight: bold;
        }
        .feedback.success { background-color: #d7f8d7; color: #007000; border: 1px solid #007000; }
        .feedback.warning { background-color: #ffe1e1; color: #a00000; border: 1px solid #a00000; }
        form.inline { display: inline; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fdf6e3;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #002248;
            color: #fff;
        }
        tr:nth-child(even) { background: #f2f2f2; }
        tr:hover { background: #e9f7ff; }
        select, input[type="text"], input[type="submit"] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        #logout {
            color: #ffd66e;
            text-decoration: none;
            background-color: #002248;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        #logout:hover { background-color: #b4820c; color: white; }
    </style>
</head>
<body class="page_manage">

<?php include "header.inc"; ?>

<header>
    <h2 style="color: gold">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p><a href="logout.php" id="logout">Logout</a></p>
</header>

<main>
    <h2>EOI Management Dashboard</h2>

    <!-- ====== SEARCH FORM ====== -->
    <form action="manage.php" method="get" novalidate>
        <fieldset>
            <legend>Search Options</legend>

            <label>Search Type:</label>
            <select name="search_type">
                <option value="all">List All EOIs</option>
                <option value="job_ref">By Job Reference</option>
                <option value="name">By Applicant Name</option>
            </select>

            <br><br>

            <label>Job Reference:</label>
            <input type="text" name="job_ref" placeholder="e.g. JOB123">

            <br>

            <label>First Name:</label>
            <input type="text" name="firstname">
            <br>
            <label>Last Name:</label>
            <input type="text" name="lastname">

            <br><br>

            <label>Sort By:</label>
            <select name="sort_by">
                <option value="applicant_id">ID</option>
                <option value="job_reference">Job Reference</option>
                <option value="firstname">First Name</option>
                <option value="lastname">Last Name</option>
                <option value="status">Status</option>
            </select>

            <input type="submit" value="Search">
        </fieldset>
    </form>

    <!-- ====== FEEDBACK MESSAGES ====== -->
    <?php if (!empty($feedback)) echo $feedback; ?>

    <hr>

<?php
// ====== BUILD QUERY ======
$query = "SELECT * FROM eoi";
$conditions = [];
$params = [];
$types = "";

if (isset($_GET['search_type'])) {
    $search_type = $_GET['search_type'];

    if ($search_type === "job_ref" && !empty($_GET['job_ref'])) {
        $conditions[] = "job_reference = ?";
        $params[] = clean_input($_GET['job_ref']);
        $types .= "s";
    } elseif ($search_type === "name") {
        if (!empty($_GET['firstname'])) {
            $conditions[] = "firstname LIKE ?";
            $params[] = "%" . clean_input($_GET['firstname']) . "%";
            $types .= "s";
        }
        if (!empty($_GET['lastname'])) {
            $conditions[] = "lastname LIKE ?";
            $params[] = "%" . clean_input($_GET['lastname']) . "%";
            $types .= "s";
        }
    }
}

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$allowed_sort_fields = ['applicant_id','job_reference','firstname','lastname','status'];
$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $allowed_sort_fields)
    ? $_GET['sort_by'] : 'applicant_id';
$query .= " ORDER BY $sort_by ASC";

$stmt = $conn->prepare($query);
if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// ====== DISPLAY RESULTS ======
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Job Ref</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Change Status</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['applicant_id']}</td>
                <td>{$row['job_reference']}</td>
                <td>{$row['firstname']} {$row['lastname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone_number']}</td>
                <td><strong>{$row['status']}</strong></td>
                <td>
                    <form class='inline' action='manage.php' method='post'>
                        <input type='hidden' name='update_status_id' value='{$row['applicant_id']}'>
                        <select name='new_status'>
                            <option value='New'>New</option>
                            <option value='Reviewed'>Reviewed</option>
                            <option value='Shortlisted'>Shortlisted</option>
                            <option value='Hired'>Hired</option>
                        </select>
                        <input type='submit' value='Update'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center; margin-top:20px;'>No EOIs found matching your criteria.</p>";
}
?>

    <hr>
    <h3>Delete EOIs by Job Reference</h3>
    <form action="manage.php" method="post">
        <label>Job Reference:</label>
        <input type="text" name="delete_ref" required placeholder="e.g. JOB123">
        <input type="submit" value="Delete All EOIs for Job">
    </form>
</main>

<?php include "footer.inc"; ?>
</body>
</html>
