<?php
require_once "settings.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    session_destroy();
    header('Location: login.php');
    exit;
}

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle delete action
if (isset($_POST['delete_ref'])) {
    $ref = clean_input($_POST['delete_ref']);
    $delete_query = "DELETE FROM eoi WHERE job_reference = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("s", $ref);
    $stmt->execute();
    echo "<p style='color:red;'>All EOIs for job reference <strong>$ref</strong> have been deleted.</p>";
}

// Handle update status action
if (isset($_POST['update_status_id']) && isset($_POST['new_status'])) {
    $id = clean_input($_POST['update_status_id']);
    $status = clean_input($_POST['new_status']);
    $update_query = "UPDATE eoi SET status = ? WHERE applicant_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    echo "<p style='color:green;'>EOI #$id status updated to <strong>$status</strong>.</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Management</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<?php include "header.inc"; ?>
<h2> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
<p><a href="logout.php" id="logout"> Logout</a></p>

<main>
    <h2>EOI Management</h2>

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
            <input type="text" name="job_ref">
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

    <hr>

<?php
// Build query dynamically
$query = "SELECT * FROM eoi";
$conditions = [];
$params = [];
$types = "";

// Search filters
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

// Sorting
$allowed_sort_fields = ['applicant_id','job_reference','firstname','lastname','status'];
$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $allowed_sort_fields)
    ? $_GET['sort_by'] : 'applicant_id';
$query .= " ORDER BY $sort_by ASC";

// Prepare and execute
$stmt = $conn->prepare($query);
if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Display results
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>ID</th>
            <th>Job Reference</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Change Status</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['applicant_id']}</td>";
        echo "<td>{$row['job_reference']}</td>";
        echo "<td>{$row['firstname']}</td>";
        echo "<td>{$row['lastname']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['phone_number']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "<td>
                <form action='manage.php' method='post' style='display:inline;'>
                    <input type='hidden' name='update_status_id' value='{$row['applicant_id']}'>
                    <select name='new_status'>
                        <option value='New'>New</option>
                        <option value='Reviewed'>Reviewed</option>
                        <option value='Shortlisted'>Shortlisted</option>
                        <option value='Hired'>Hired</option>
                    </select>
                    <input type='submit' value='Update'>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}

// Delete form
?>
    <hr>
    <h3>Delete EOIs by Job Reference</h3>
    <form action="manage.php" method="post">
        <label>Job Reference:</label>
        <input type="text" name="delete_ref" required>
        <input type="submit" value="Delete All EOIs for Job">
    </form>

</main>

<?php include "footer.inc"; ?>
</body>
</html>
