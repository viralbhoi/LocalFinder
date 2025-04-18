<?php
    require_once "pdo.php";
    session_start();
    if(!isset($_SESSION['Name']))
    {
        header('Location:index.php');
        return;
    }
    $stmt=$pdo->query('SELECT * FROM customer WHERE Cid="'.$_SESSION['Id'].'"');
    $results=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="index.php">Home</a></div>
                <div><a href="user_profile_update.php">Edit Profile</a></div>
            </nav>
        </div>
    </header>

    <section class="user-profile">
        <h2>User Profile</h2>

        <div class="profile-details">
            <?php //print_r($results);?>
            <p><strong>Username:</strong><?=$results[0]['Cname'];?></p>
            <p><strong>Email:</strong> <?=$results[0]['Email'];?></p>
            <p><strong>Mobile:</strong> <?=$results[0]['Cmobile'];?></p>
            <p><strong>Address:</strong> <?=$results[0]['Address_line1'];?></p>
            <p><strong>District:</strong> <?=$results[0]['District'];?></p>
            <p><strong>State:</strong> <?=$results[0]['State'];?></p>
        </div>
    </section>

    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="copyright">
            &copy; 2025 LocalFinder. All rights reserved.
        </div>
    </footer>
</body>

</html>
