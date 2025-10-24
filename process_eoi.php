<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = clean_input($_POST["username"]);
    $email = clean_input($_POST["email"]);

    if (empty($username)) {
      echo "Name is required.<br>";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email format.<br>";
    }
  }

  function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
