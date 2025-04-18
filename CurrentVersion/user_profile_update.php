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
    if(isset($_POST['name']))
    {
        $sql='UPDATE customer SET Cname="'.$_POST['name'].'" ,Email="'.$_POST['email'].'" ,Cmobile="'.$_POST['mobile'].'" ,Address_line1="'.$_POST['address'].'" ,District="'.$_POST['district'].'" ,State="'.$_POST['state'].'" ,Pincode="'.$_POST['pincode'].'" WHERE Cid="'.$_SESSION['Id'].'"';
        if($pdo->exec($sql))
        {
            echo '<script>alert("Successfully updated!!");</script>';
            $_SESSION['Name']=$_POST['name'];
            header('Location:user_profile_view.php');
            return;
        }
        else{
            echo '<script>alert("Something Went Wrong!!");</script>';
            header('Location:user_profile_view.php');
            return;
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update User Profile</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="index.php">Home</a></div>
                <div><a href="user_profile_view.php">View Profile</a></div>
            </nav>
        </div>
    </header>

    <section class="reg_screen">
        <fieldset class="reg1">
            <legend>
                <h2>Update Profile</h2>
            </legend>
            <form name="update_form" method="post"><!--method="post"-->
                <label for="name">Username:</label>
                <input type="text" name="name" id="name" value=<?=htmlentities($results[0]['Cname'])?> required /><br /><br />
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email"value=<?=htmlentities($results[0]['Email'])?> required /><br /><br />
                <label for="mob">Mobile No.:</label>
                <input type="number" name="mobile" id="mob" value=<?=htmlentities($results[0]['Cmobile'])?> required /><br /><br />
                <label for="address">Address: </label>
                <textarea id="address"name="address" rows="5" ><?=htmlentities($results[0]['Address_line1'])?></textarea><br /><br />
                <label for="District">District:</label>
                <input type="text" name="district"id="District" value=<?=htmlentities($results[0]['District'])?> required /><br /><br />
                <label for="District">District:</label>
                <input type="text" name="pincode"id="pincode" value=<?=htmlentities($results[0]['Pincode'])?> required /><br /><br />
                <label for="State">State:</label>
                <input type="text" name="state"id="State" value=<?=htmlentities($results[0]['State'])?> required /><br /><br />
                <input type="submit" name="submit"value="Update" id="sub1" required />
                <input type="reset" id="sub1" />
            </form>
        </fieldset>
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
