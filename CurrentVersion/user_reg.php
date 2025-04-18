<?php
require_once "pdo.php";
session_start();

if (isset($_SESSION['Name'])) {
    header('Location:index1.php');
    return;
}

if (isset($_POST['submit'])) {
    // Check if passwords match

    if ($_POST['pass1'] !== $_POST['pass2']) {
        echo "Passwords do not match.";
        return;
    }
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customer WHERE Email = :email");
        $stmt->execute([':email' => $_POST['email']]);
        if ($stmt->fetchColumn() > 0) {
            echo "Email exists.";
            return;
        }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customer WHERE Cname = :username");
        $stmt->execute([':username' => $_POST['name']]);
        if ($stmt->fetchColumn() > 0) {
            echo "username exists.";
            return;
        }

    try {
        // Get the last Cid from the database
        $sqlc = 'SELECT MAX(Cid) AS maxCid FROM customer';
        $stmt = $pdo->query($sqlc);
        $row = $stmt->fetch();

        // If there are no records, start with C101
        if ($row['maxCid'] === null) {
            $newCid = 'C101';
        } else {
            // Extract the numeric part and increment it
            $numericPart = (int) substr($row['maxCid'], 1);
            $newCid = 'C' . str_pad($numericPart + 1, 3, '0', STR_PAD_LEFT);
        }

        // Prepare and execute the INSERT query
        $sql = 'INSERT INTO customer (`Cid`, `Cname`, `Cmobile`, `Address_line1`, `District`, `State`, `Email`, `Pass`, `Pincode`) 
                VALUES (:Cid, :Cname, :Cmobile, :Address_line1, :District, :State, :Email, :Pass, :Pin)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':Cid' => $newCid,
            ':Cname' => $_POST['name'],
            ':Cmobile' => $_POST['mobile'],
            ':Address_line1' => $_POST['address'],
            ':District' => $_POST['district'],
            ':State' => $_POST['state'],
            ':Email' => $_POST['email'],
            ':Pass' => $_POST['pass1'],
            ':Pin' => $_POST['pincode']
        ]);

        echo "User added successfully.";
        header('Location:login.php');
    } catch (PDOException $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Website Title</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    

</head>
<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div class="before_login"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>
                <div><a href="discuss.php"><i class="fas fa-comments"></i> Discuss</a></div>
            </nav>
            <div class="set-location">
            </div>
            <div id="Left">

                <select name="locate" id="locate">
                    <option value="Anand">Anand</option>
                </select>
                <div id="search_box">
                    <i class="fas fa-search"></i>
                  <input type="text" id="search" placeholder="Search..." />
                </div>
            </div>
        </div>
    </header>
    <section class="reg_screen">
        <fieldset class="reg1">
            <legend><h2>Register</h2></legend>
            <form name="reg_form" id="reg_form" method="post">
    <label for="name">Username:</label>
    <input type="text" name="name" id="name" required/><br/><br/>
    <label for="pass1">Password : </label>
    <input type="password" name="pass1" id="pass1" required/><br/><br/>
    <label for="pass2"> Confirm Password : </label>
    <input type="password" name="pass2" id="pass2" required/><br/><br/>
    <label for="mob">Mobile No.:</label>
    <input type="number" name="mobile" id="mob" required/><br/><br/>
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required/><br/><br/>
    <label for="address">Address: </label>
    <textarea id="address" name="address" rows="5"></textarea><br/><br/>
    <label for="District">District:</label>
    <input type="text" name="district" id="District" required/><br/><br/>
    <label for="pincode">Pincode:</label>
    <input type="text" name="pincode" id="pincode" required/><br/><br/>
    <label for="State">State:</label>
    <input type="text" name="state" id="State" required/><br/><br/>
    <input type="submit" name="submit" value="Register" id="sub1" required/>
    <input type="reset" id="sub1" required/>
</form>

        </fieldset>
        <center>
            <p>Already have account ? <a href="login.php">Log In</a></p>
        </center>
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
    <script src="scripts/userFromCheck.js" type="text/javascript"></script>
    <script src="scripts/app.js" type="text/javascript"></script>
</body>
</html>

