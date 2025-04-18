<?php
require_once "pdo.php";
$stmt = $pdo->query('SELECT * FROM product LIMIT 3');
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
session_start();

// if (isset($_SESSION['Name'])) {
//     echo "Session Name: " . $_SESSION['Name'];
// } else {
//     echo "Session Name is not set.";
// }
?>

<!DOCTYPE html>
<html>

<head>
    <title>LocalFinder</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/app.js" type="text/javascript"></script>
    <style>
        .recommendations {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            width: 300px;
        }

        #right-top-dropdown {
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 12px 16px;
            z-index: 1;
            right: 0;
            top: 25px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        #right-top-dropdown:hover .dropdown-content {
            display: block;
        }

        #right-top-dropdown:hover #log1 {
            color: blue;
        }
    </style>
    <script>
        

        function performSearch() {
            const searchTerm = document.getElementById("search").value.toLowerCase();
            alert(`Searching for: ${searchTerm} (This is just a prototype)`);
        }

        document.addEventListener("DOMContentLoaded", function () {
            //console.log("DOM Content Loaded");
            let before_login = document.getElementsByClassName('before_login');
            let after_login = document.getElementsByClassName('after_login');
            document.getElementById("right-top-dropdown").addEventListener("click", function () {
            var dropdownContent = document.getElementById("dropdown-content");
            var rect = this.getBoundingClientRect();
            var viewportHeight = window.innerHeight;

            if (rect.bottom + dropdownContent.offsetHeight > viewportHeight) {
                dropdownContent.style.top = -dropdownContent.offsetHeight + 'px';
            } else {
                dropdownContent.style.top = '25px';
            }

            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });

        let logged_in = <?php echo isset($_SESSION['Name']) ? 'true' : 'false'; ?>;
        console.log(logged_in);
            Array.from(before_login).forEach(element => {
                if (logged_in) {
                    element.style.display = "none";
                    element.style.visibility = "hidden";
                } else {
                    element.style.display = "block";
                    element.style.visibility = "visible";
                }
            });

            Array.from(after_login).forEach(element => {
                if (logged_in) {
                    element.style.display = "block";
                    element.style.visibility = "visible";
                } else {
                    element.style.display = "none";
                    element.style.visibility = "hidden";
                }
            });

            const searchInput = document.getElementById("search");
            if (searchInput) {
                searchInput.addEventListener("keypress", function (event) {
                    if (event.key === "Enter") {
                        performSearch();
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div class="before_login"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                <div class="before_login"><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
                <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>
            </nav>
            <div class="set-location"></div>
            <div id="Left">
                <select name="locate" id="locate">
                    <option value="Anand">Anand</option>
                </select>
                <div id="search_box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" placeholder="Search..." />
                </div>
            </div>
            <?php
            if (isset($_SESSION['Name'])) {
                echo '<div id="right-top-avatar" style="margin-top:3px;margin-left:1px;background-color:white;width:20px;height:20px; border-radius:50%; display:inline-block;">' . htmlspecialchars($_SESSION['Name'][0]) . '</div>';
                echo '<div id="right-top-dropdown" style="display:inline-block; margin-left:5px; position:relative;">';
                echo '<i id="log1" class="fa fa-caret-down"></i>';
                echo '<div id="dropdown-content" class="dropdown-content">';
                echo '<a href="logout.php">Logout</a>';
                echo '<a href="user_profile_view.php">User Profile</a>';
                echo '<a href="user_profile_update.php">Edit Profile</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </header>

    <!-- Main Content -->
    <section class="main-content">
        <section class="recommendations">
            <?php 
            if ($results) {
                foreach ($results as $result) { ?>
                    <div class="product">
                        <img class="pic" src="<?= htmlspecialchars($result['images']) ?>" alt="<?= htmlspecialchars($result['Pname']) ?>">
                        <div class="description">
                            <h6><?= htmlspecialchars($result['Pname']) ?></h6>
                            <p><?= htmlspecialchars($result['specifications']) ?></p>
                        </div>
                        <b>Price: <?= htmlspecialchars($result['Price']) ?></b>
                    </div>
                <?php }
            } else { ?>
                <em>Sorry, couldn't fetch product data.</em>
            <?php } ?>
        </section>
        <p align="center">& MANY MORE...</p>
    </section>

    <!-- Footer -->
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
