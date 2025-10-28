<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Page for Hogwarts School of WitchCraft & Wizardry">
    <meta name="keywords" content="HTML, About, Hogwarts">
    <meta name="author" content="Jacob Grant">
    <title>About Page</title>
    <link rel="icon" type="image/x-icon" href="/images/Hogwarts-Crest.png">
</head>
<body class="page_about">
    
  <?php include "header.inc" ?>

  <main>
      <h2>About Us</h2>
      <p>From day one, Hogwarts has been a one-of-a-kind school, 
            embracing the magic within our very special students. Hogwarts prides itself on 
            being a safe place for young wizards and witches to learn and harness their magic without fear,
        judgement or danger. Ranging from hundreds of high quality dorm rooms and student facilities to the
        largest Quidditch Pitch in the world, Hogwarts ensures all bases are covered. Having the highest combined 
        wizarding and academic results of any other school you can be sure your young witch or wizard will 
        be in good hands. With a high caliber teaching staff and a passion for learning, Hogwarts continues to be
        top of its class in wizarding education.
      </p>
      <hr>
        <h3 class="about_heading"><em>Meet the team!</em></h3>

        <div id="team_pic"></div>
        <aside><p>Secret: (click and hold image to add more magic)</p></aside>

        <br>
        <h4><strong>Group Details:</strong></h4>
        <ul>
          <li>Group Name: The Chicken Jockeys
            <ul>
              <li>Class time: Tuesday 12:30pm</li>
            </ul>
          </li>
        </ul>
        <br>

        <div class="profile-container">
          <?php 
          require_once "settings.php";
    
            try {
              $pdo = new PDO("mysql:host=$host;dbname=$sql_db", $user, $pwd);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              
              $stmt = $pdo->query("SELECT * FROM member_contributions ORDER BY name");
              $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
              
              if(count($members) > 0) { //If the number of members is greater than zero...
                  foreach($members as $member) { //For each member entry, add member info (profile image, name, ID, contributions)
                      echo '
                      <div class="profile">
                        <img src="images/' . htmlspecialchars($member['profile_image']) . '" alt="profile_pic_' . htmlspecialchars($member['name']) . '" class="profile_pic">
                        <h4>' . htmlspecialchars($member['name']) . '</h4>
                        <p><strong>Student ID:</strong> ' . htmlspecialchars($member['student_id']) . '</p>
                        <p><strong>Contributions:</strong></p>
                        <dl>
                          <dt>Project 1</dt>
                          <dd>' . htmlspecialchars($member['project1_contributions']) . '</dd>
                          <dt>Project 2</dt>
                          <dd>' . htmlspecialchars($member['project2_contributions']) . '</dd>
                        </dl>
                      </div>';
                  }
              } else {
                  echo '<p>No team members found in database.</p>'; //Display if no team members found.
              }
          } catch(PDOException $e) {
              echo "<p>Error loading team members: " . $e->getMessage() . "</p>"; //Display if there is an error fetching data.
          }
          ?>
        </div>

      <table>
        <caption><strong>Team Fun Facts</strong></caption>
        <thead>
          <tr>
            <th>Team Member Name</th>
            <th>Fun Fact</th>
          </tr>
        </thead>

        <tbody>
          <?php
          // Display fun facts from database
          try {
              $stmt = $pdo->query("SELECT name, fun_fact FROM member_contributions ORDER BY name"); //Takes the name and fun fact from 'member_contributions' table and orders by name.
              $hasData = false;
              while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //If it finds the rows, hasData is set to true, names and fun facts are displayed in a table.
                  $hasData = true;
                  echo '
                  <tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['fun_fact']) . '</td>
                  </tr>';
              }
              if(!$hasData) { //If has data is false, display table with no fun facts.
                  echo '<tr><td colspan="2">No fun facts available</td></tr>';
              }
          } catch(PDOException $e) {
              echo "<tr><td colspan='2'>Error loading fun facts: " . $e->getMessage() . "</td></tr>";
          }
          ?>
        </tbody>
      </table>

    </main>

    <?php include "footer.inc" ?>
    <?php if(isset($pdo)) { $pdo = null; } // Close connection ?>

  </body>
</html>