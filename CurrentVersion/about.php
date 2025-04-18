<!DOCTYPE html>
<html>

<head>
    <title>About Us - LocalFinder</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .about-section {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .about-section h2,
        .about-section h3 {
            color: #333;
        }

        .about-section ul {
            list-style-type: none;
            padding: 0;
        }

        .about-section li {
            margin-bottom: 5px;
        }
    </style>
        <script src="scripts/app.js" type="text/javascript"></script>

</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                <div><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
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
    <section class="about">
        <div class="about-section">
            <h2>About LocalFinder</h2>
            <p>
                LocalFinder is a platform dedicated to connecting local vendors with
                customers in your community. We believe in supporting local businesses
                and making it easier for you to find the products you need, right in
                your neighborhood.
            </p>

            <h3>Our Mission</h3>
            <p>
                Our mission is to empower local economies by providing a user-friendly
                platform that promotes local vendors and connects them with the
                customers who value them most.
            </p>

            <h3>What We Offer</h3>
            <ul>
                <li>
                    <strong>Easy Product Search:</strong> Find the products you need
                    quickly and easily.
                </li>
                <li>
                    <strong>Support Local Businesses:</strong> Discover and support the
                    vendors in your community.
                </li>
                <li>
                    <strong>Convenient Options:</strong> Choose between visiting shops
                    in person or requesting delivery.
                </li>
            </ul>

            <h3>Our Team</h3>
            <p>
                LocalFinder is built by a team of passionate individuals dedicated to
                making a difference in our local communities. We are committed to
                providing a seamless and reliable platform for both customers and
                vendors.
            </p>
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
