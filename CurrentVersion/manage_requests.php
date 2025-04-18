<?php
require_once "pdo.php";

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $Rid = $_POST['Rid'];
    $Status = $_POST['Status'];

    $sql = "UPDATE delivery_requests SET Status = :Status WHERE Rid = :Rid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':Status' => $Status, ':Rid' => $Rid]);

    header("Location: manage_requests.php");
    return;
}

// Handle search query
if (isset($_GET['search_status'])) {
    $search_status = $_GET['search_status'];
    $stmt = $pdo->prepare("SELECT * FROM delivery_requests WHERE Status = :status");
    $stmt->execute([':status' => $search_status]);
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query('SELECT * FROM delivery_requests');
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Delivery Requests</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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
            margin-bottom: 0;
        }
        select {
            width: 150px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-bar {
            margin: 20px auto;
            width: 80%;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        .search-bar select {
            width: 200px;
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
    <h1>Manage Delivery Requests</h1>

    <!-- Search Bar -->
    <div class="search-bar">
        <form action="manage_requests.php" method="GET">
            <select name="search_status">
                <option value="">All</option>
                <option value="Pending" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                <option value="Confirmed" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                <option value="Shipped" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'Shipped') ? 'selected' : '' ?>>Shipped</option>
                <option value="Delivered" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'Delivered') ? 'selected' : '' ?>>Delivered</option>
                <option value="Cancelled" <?= (isset($_GET['search_status']) && $_GET['search_status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
            </select>
            <input type="submit" value="Search">
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Customer ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Timing</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($requests as $request) { ?>
                <tr>
                    <td><?= htmlspecialchars($request['Rid']) ?></td>
                    <td><?= htmlspecialchars($request['Cid']) ?></td>
                    <td><?= htmlspecialchars($request['Pid']) ?></td>
                    <td><?= htmlspecialchars($request['Quantity']) ?></td>
                    <td><?= htmlspecialchars($request['Timing']) ?></td>
                    <td><?= htmlspecialchars($request['Status']) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="Rid" value="<?= htmlspecialchars($request['Rid']) ?>">
                            <select name="Status">
                                <option value="Pending" <?= ($request['Status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="Confirmed" <?= ($request['Status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                                <option value="Shipped" <?= ($request['Status'] == 'Shipped') ? 'selected' : '' ?>>Shipped</option>
                                <option value="Delivered" <?= ($request['Status'] == 'Delivered') ? 'selected' : '' ?>>Delivered</option>
                                <option value="Cancelled" <?= ($request['Status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <input type="submit" value="Update">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
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
