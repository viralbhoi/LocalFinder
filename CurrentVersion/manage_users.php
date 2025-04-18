<?php
require_once "pdo.php";

// Check if the form is submitted for adding, editing, or deleting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add') {
            // Add a new user
            $Cid = uniqid('C'); // Generate a unique ID for the customer
            $Cname = $_POST['Cname'];
            $Cmobile = $_POST['Cmobile'];
            $Address_line1 = $_POST['Address_line1'];
            $District = $_POST['District'];
            $Pincode = $_POST['Pincode'];
            $State = $_POST['State'];
            $Email = $_POST['Email'];
            $Pass = $_POST['Pass'];

            $sql = "INSERT INTO customer (Cid, Cname, Cmobile, Address_line1, District, Pincode, State, Email, Pass)
                    VALUES (:Cid, :Cname, :Cmobile, :Address_line1, :District, :Pincode, :State, :Email, :Pass)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':Cid' => $Cid,
                ':Cname' => $Cname,
                ':Cmobile' => $Cmobile,
                ':Address_line1' => $Address_line1,
                ':District' => $District,
                ':Pincode' => $Pincode,
                ':State' => $State,
                ':Email' => $Email,
                ':Pass' => $Pass
            ]);

            header("Location: manage_users.php"); // Redirect to refresh the page
            return;
        } elseif ($action == 'edit') {
            // Edit an existing user
            $Cid = $_POST['Cid'];
            $Cname = $_POST['Cname'];
            $Cmobile = $_POST['Cmobile'];
            $Address_line1 = $_POST['Address_line1'];
            $District = $_POST['District'];
            $Pincode = $_POST['Pincode'];
            $State = $_POST['State'];
            $Email = $_POST['Email'];
            $Pass = $_POST['Pass'];

            $sql = "UPDATE customer SET Cname = :Cname, Cmobile = :Cmobile, Address_line1 = :Address_line1,
                    District = :District, Pincode = :Pincode, State = :State, Email = :Email, Pass = :Pass
                    WHERE Cid = :Cid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':Cid' => $Cid,
                ':Cname' => $Cname,
                ':Cmobile' => $Cmobile,
                ':Address_line1' => $Address_line1,
                ':District' => $District,
                ':Pincode' => $Pincode,
                ':State' => $State,
                ':Email' => $Email,
                ':Pass' => $Pass
            ]);

            header("Location: manage_users.php"); // Redirect to refresh the page
            return;
        } elseif ($action == 'delete') {
            // Delete a user
            $Cid = $_POST['Cid'];

            $sql = "DELETE FROM customer WHERE Cid = :Cid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':Cid' => $Cid]);

            header("Location: manage_users.php"); // Redirect to refresh the page
            return;
        }
    }
}

// Fetch all users for display
$stmt = $pdo->query('SELECT * FROM customer');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Basic styling for the table and forms */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            width: 80%;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button {
            background-color: #008CBA;
            color: white;
        }
        .delete-button {
            background-color: #f44336;
            color: white;
        }

        /* Style for the modal (hidden by default) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .back-button {
            margin: 10px;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo_1"></div>
    </header>
    <a href="admin_dashboard.php" class="back-button">Back</a>

    <h1>Manage Users</h1>

    <!-- Add User Form -->
    <h2>Add User</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <label for="Cname">Name:</label>
        <input type="text" name="Cname" required>
        <label for="Cmobile">Mobile:</label>
        <input type="number" name="Cmobile">
        <label for="Address_line1">Address:</label>
        <input type="text" name="Address_line1">
        <label for="District">District:</label>
        <input type="text" name="District">
        <label for="Pincode">Pincode:</label>
        <input type="number" name="Pincode">
        <label for="State">State:</label>
        <input type="text" name="State">
        <label for="Email">Email:</label>
        <input type="email" name="Email" required>
        <label for="Pass">Password:</label>
        <input type="text" name="Pass" required>
        <input type="submit" value="Add User">
    </form>

    <!-- User Table -->
    <h2>Existing Users</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user) { ?>
                <tr>
                    <td><?= htmlspecialchars($user['Cid']) ?></td>
                    <td><?= htmlspecialchars($user['Cname']) ?></td>
                    <td><?= htmlspecialchars($user['Email']) ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="edit-button" onclick="openEditModal('<?= htmlspecialchars($user['Cid']) ?>', '<?= htmlspecialchars($user['Cname']) ?>', '<?= htmlspecialchars($user['Cmobile']) ?>', '<?= htmlspecialchars($user['Address_line1']) ?>', '<?= htmlspecialchars($user['District']) ?>', '<?= htmlspecialchars($user['Pincode']) ?>', '<?= htmlspecialchars($user['State']) ?>', '<?= htmlspecialchars($user['Email']) ?>', '<?= htmlspecialchars($user['Pass']) ?>')">Edit</button>
                            <button class="delete-button" onclick="openDeleteModal('<?= htmlspecialchars($user['Cid']) ?>')">Delete</button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit User</h2>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" id="editCid" name="Cid">
                <label for="editCname">Name:</label>
                <input type="text" id="editCname" name="Cname" required>
                <label for="editCmobile">Mobile:</label>
                <input type="number" id="editCmobile" name="Cmobile">
                <label for="editAddress_line1">Address:</label>
                <input type="text" id="editAddress_line1" name="Address_line1">
                <label for="editDistrict">District:</label>
                <input type="text" id="editDistrict" name="District">
                <label for="editPincode">Pincode:</label>
                <input type="number" id="editPincode" name="Pincode">
                <label for="editState">State:</label>
                <input type="text" id="editState" name="State">
                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="Email" required>
                <label for="editPass">Password:</label>
                <input type="text" id="editPass" name="Pass" required>
                <input type="submit" value="Update User">
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Delete User</h2>
            <p>Are you sure you want to delete this user?</p>
            <form method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" id="deleteCid" name="Cid">
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>

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

    <script>
        // Edit Modal Functions
        function openEditModal(Cid, Cname, Cmobile, Address_line1, District, Pincode, State, Email, Pass) {
            document.getElementById('editCid').value = Cid;
            document.getElementById('editCname').value = Cname;
            document.getElementById('editCmobile').value = Cmobile;
            document.getElementById('editAddress_line1').value = Address_line1;
            document.getElementById('editDistrict').value = District;
            document.getElementById('editPincode').value = Pincode;
            document.getElementById('editState').value = State;
            document.getElementById('editEmail').value = Email;
            document.getElementById('editPass').value = Pass;
            document.getElementById('editModal').style.display = "block";
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        // Delete Modal Functions
        function openDeleteModal(Cid) {
            document.getElementById('deleteCid').value = Cid;
            document.getElementById('deleteModal').style.display = "block";
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = "none";
        }

        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
            if (event.target == document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }
    </script>
</body>
</html>
