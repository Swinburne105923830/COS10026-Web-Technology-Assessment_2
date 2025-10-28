<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Job application webpage for our website.">
        <meta name="keywords" content="University jobs, tech jobs, hogwarts jobs, hogwarts">
        <meta name="author" content="Lachlan Andrews">
        <title>Hogwarts University Digital Learning Jobs</title>
        <link rel="stylesheet" href="styles/style.css">
        <style>
            aside {
                float: right;
                border: 4px inset #ffd66e;
                margin: 0.7em;
                padding: 0.85em;
                width: 40%;
                background: radial-gradient(#2c364d, #001a35);
                color: white;
            }

            #asidehead {
                text-align: center;
                font-size: 1.15em;
                font-family: var(--heading-font-family);
                color: #ffd66e;
            }
        </style>
    </head>

    <body class="page_jobs">
        
        <?php include "header.inc" ?>

        <main>


            <h2>Digital Learning Jobs at Hogwarts University</h2>

            <p>Browse the current Digital Learning job vacancies at Hogwarts University. Digital Learning jobs at Hogwarts aim to help kickstart the beginning of a new digital age of teaching, learning and research at our schools.</p>

            <aside>
                <h3 id="asidehead">Attention:</h3>
                <p>All job vacancies across Hogwrats campuses and departments are still accepting written/printed applications via owl delivery. Address all applications to Sir Geoffery Grimace, Hogwarts Castle, Eastmost Tower.</p>
            </aside>

            <h3>Available Digital Learning Jobs:</h3>
            <hr>

            <?php include "settings.php";
            $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
            if ($dbconn) { //If the database connects...
                $query = "SELECT * FROM jobs"; //Get all columns from the jobs table.
                $result = mysqli_query($dbconn, $query);
                if (!$result) { //Display if there are no entries.
                    echo "<p>There are no jobs to display.";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) { //If there are entries, display each job in this format.
                        echo "<section id=" . $row['reference_no'] . ">";
                        echo "<h4>" . $row['title'] . "</h4>";
                        echo "<p><strong>Job Reference No. - " . $row['reference_no'] ."</strong></p>";
                        echo "<p><strong>&#163;" . $row['pay_min'] ." - &#163;" . $row['pay_max'] . " a year.</strong></p>";
                        echo "<p>" . $row['description'] . "</p>";
                        echo "<p><strong>Key Responsibilities</strong></p>";
                        echo "<p>" . $row['responsibility'] . "</p>";
                        echo "<ol>";
                        
                        $responsibilities = json_decode($row['responsibility_list'], true);

                        //Allows the job responsibilities to be displayed dynamically for any job.
                        if (is_array($responsibilities)) { //If the responsibilities column is stored as an array...
                            foreach ($responsibilities as $item) { //Store each array item as $item.
                                echo "<li>" . htmlspecialchars($item) . "</li>"; //List each responsibility.
                            }
                        } else {
                            echo "<li>No responsibilities listed.</li>";
                        }

                        echo "</ol>";
                        echo "<p><strong>Qualifications</strong></p>";
                        echo "<p>In order to be considered for the role, you must have the following:</p>";
                        echo "<ul>";

                        $qualifications = json_decode($row['qualifications_list'], true);

                        //Displays qualifications dynamically.
                        if (is_array($qualifications)) {
                            foreach ($qualifications as $item) {
                                echo "<li>" . htmlspecialchars($item) . "</li>";
                            }
                        } else {
                            echo "<li>No qualifications listed.</li>";
                        }

                        echo "</ul>";
                        echo "<p>Some skills that are not required, but are desirable include:</p>";
                        echo "<ul>";

                        $desired_skills = json_decode($row['desired_skills_list'], true);

                        //Displays desired skills dynamically.
                        if (is_array($desired_skills)) {
                            foreach ($desired_skills as $item) {
                                echo "<li>" . htmlspecialchars($item) . "</li>";
                            }
                        } else {
                            echo "<li>No desired skills listed.</li>";
                        }

                        echo "</ul>";
                        echo "<p><strong>Reporting Line</strong></p>";
                        echo "<p>Reports to: </p>";
                        echo '<ul>';


                        $report_line = json_decode($row['report_line_list'], true);

                        //Displays report line dynamically.
                        if (is_array($report_line)) {
                            foreach ($report_line as $item) {
                                echo "<li>" . htmlspecialchars($item) . "</li>";
                            }
                        } else {
                            echo "<li>No report line listed.</li>";
                        }

                        echo '</ul>';
                        echo "</section>";
                        echo "<hr>";
                    }
                    
                }
                mysqli_close($dbconn);
            } else {
                echo "<p>Unable to connect to to the db.</p>";
            }
            ?>

        </main>

        <?php include "footer.inc" ?>

    </body>

</html>