<?php
session_start();

require_once "pdo.php";
if (isset($_SESSION['Name'])) {
    echo "<script>let logged_in=true;</script>";
} else {
    echo "<script>let logged_in=false;</script>";
}
if($_SESSION['role']!='Admin')
{
    die("Unauthorized");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Local Finder - Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        
        document.addEventListener("DOMContentLoaded", function() {
            let userAvatar = document.getElementById('user-avatar');
            let userDropdown = document.getElementById('user-dropdown');
            let dropdownContent = document.getElementById('dropdown-content');

            // Hide dropdown content by default
            dropdownContent.style.display = 'none';

            // Function to toggle dropdown visibility
            function toggleDropdown() {
                if (dropdownContent.style.display === 'none') {
                    dropdownContent.style.display = 'block';
                } else {
                    dropdownContent.style.display = 'none';
                }
            }

            // Add event listeners to user avatar and dropdown icon
            if (userAvatar && userDropdown) {
                userAvatar.addEventListener('click', toggleDropdown);
                userDropdown.addEventListener('click', toggleDropdown);
            }

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userAvatar.contains(event.target) && !userDropdown.contains(event.target) && !dropdownContent.contains(event.target)) {
                    dropdownContent.style.display = 'none';
                }
            });
        });
    </script></script>
    <style>
        .dashboard-list {
            list-style: none;
            padding: 0;
        }
        .dashboard-list li {
            margin-bottom: 10px;
        }
        .dashboard-list li a {
            display: block;
            padding: 10px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .dashboard-list li a:hover {
            background-color: #ddd;
        }
        #user-profile-container {
            display: inline-block;
            margin-top: 3px;
        }

        #user-avatar {
            background-color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 1px;
        }

        #user-dropdown {
            display: inline-block;
            margin-left: 5px;
            position: relative;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <div id="logo_1"></div>
            <i align="right" class="bi bi-arrow-left-square-fill"></i>
        </div>
        <?php if (isset($_SESSION['Name'])): ?>
                <div id="user-profile-container">
                    <div id="user-avatar">
                        <?= htmlspecialchars($_SESSION['Name'][0]) ?>
                    </div>
                    <div id="user-dropdown">
                        <i id="log1" class="fa fa-caret-down"></i>
                        <div id="dropdown-content" class="dropdown-content">
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
    </header>
    <fieldset>
        <h1>Admin Dashboard</h1>
        <ul class="dashboard-list">
            <li><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="manage_vendors.php"><i class="fas fa-store"></i> Manage Vendors</a></li>
            <li><a href="manage_requests.php"><i class="fas fa-shipping-fast"></i> Manage Requests</a></li>
        </ul>
    </fieldset>
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
