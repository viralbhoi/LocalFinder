<?php
session_start();
require_once "pdo.php";

if (isset($_POST['name']) && isset($_POST['pass1'])) {
    $name = $_POST['name'];
    $password = $_POST['pass1'];

    $queries = [
        'Admin' => 'SELECT * FROM admin_staff_login WHERE Aname = :name AND Apass = :password',
        'Customer' => 'SELECT * FROM customer WHERE Cname = :name AND Pass = :password',
        'Vendor' => 'SELECT * FROM vendor WHERE Vname = :name AND Pass = :password'
    ];

    foreach ($queries as $role => $sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':name' => $name, ':password' => $password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Set session variables
            $_SESSION['role'] = $role;
            $_SESSION['Id'] = ($role === 'Admin') ? $result['Aid'] :
                              (($role === 'Customer') ? $result['Cid'] : $result['Vid']);
            $_SESSION['Name'] = ($role === 'Admin') ? $result['Aname'] :
                                (($role === 'Customer') ? $result['Cname'] : $result['Vname']);

            // Redirect based on role
            if ($role === 'Admin') {
                header('Location: ./admin_dashboard.php');
            } elseif ($role === 'Customer') {
                header('Location: ./index.php');
            } elseif ($role === 'Vendor') {  // Correct condition for Vendor
                header('Location: ./vendor_dashboard.php');
            }
            exit; // Ensure no further code is executed after redirect
        }
    }
    echo "<script>alert('Invalid username or password!');</script>";
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Website Title</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/loginCheck.js" type="text/javascript"></script>
    <script src="scripts/app.js" type="text/javascript"></script>

</head>
<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div class="before_login"><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
                <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>
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
    <section class="login_screen">
        <fieldset class="login1">
            <legend><h2>Log In</h2></legend>
            <form name="login_form"  method="post"><!--method="post"-->
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" required/><br/><br/>
                <label for="pass1">Password: </label>
                <input type="password" id="pass1" name="pass1" required/><br/><br/>
                <input type="submit" value="Log In"id="sub1" required/>
                <input type="reset" id="sub1" required/>
                <p><a href="forgot_password.php">Forgot Password?</a></p>
            </form>
        </fieldset>
        <center>
            <h2>OR</h2>
        </center>
        <a href="user_reg.php" id="new_account">Create New Account</a>
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

