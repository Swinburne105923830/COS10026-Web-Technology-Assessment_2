<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Home Page for Hogwarts School of WitchCraft & Wizardry">
    <meta name="keywords" content="HTML, Home, Hogwarts">
    <meta name="author" content="Jacob Grant">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>  
        .slogan {
            font-family: 'Italianno', cursive;
            font-size: 1.8rem;
            color: #ffd66e;
            text-align: center;
            margin-top: 5px;
            text-shadow: 0 0 5px #000000;
        }
    </style>
</head>
<body>
    
    <?php include "header.inc" ?>

    <main>
        <section class="company-details">
        <h2>Join in the Magic</h2>
        <p>Welcome to Hogwarts School of Witchcraft and Wizardry, the premier institution for magical education. 
            Founded over a thousand years ago, Hogwarts has been the training ground for some of the most powerful witches and wizards in history. 
            Our mission is to nurture young magical talent and prepare them for a life of adventure and discovery in the wizarding world.</p>
        <p>At Hogwarts, we provide world-class magical education and training
                to young witches and wizards. Our mission is to nurture talent,
                promote creativity, and prepare students for the magical challenges
                of tomorrow.</p>
        <img src="images/hogwarts.jpg" alt="Hogwarts Castle" class="castle-image">
        </section>

        <section class="announcements">
            <h3>Announcements:</h3>
            <h4>Now Hiring!</h4>
            <p>We are excited to announce that we are hiring. Check out our jobs page to see a list of available roles or the apply page to register your application!</p>
            <h5><a href="apply.php">Click Here to Apply Now</a></h5>
        </section>
    </main>

    <?php include "footer.inc" ?>

</body>
</html>