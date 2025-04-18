<?php
session_start();
require_once "pdo.php";

// Check user & delivery request
if (!isset($_SESSION['Id']) || !isset($_GET['Rid'])) {
    die("Invalid request.");
}

$Rid = $_GET['Rid'];
$stmt = $pdo->prepare("
    SELECT dr.Rid, dr.Cid, dr.Pid, dr.Quantity, dr.DeliveryAddress, dr.DeliveryDate,
           dr.Timing, dr.SpecialInstructions, dr.Status, c.Cname, c.Email, c.Cmobile,
           p.Pname, p.Price
    FROM delivery_requests dr
    JOIN customer c ON dr.Cid = c.Cid
    JOIN product p ON dr.Pid = p.Pid
    WHERE dr.Rid = :rid
");
$stmt->execute([':rid' => $Rid]);
$bill = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bill) {
    die("No data found.");
}

$total = $bill['Price'] * $bill['Quantity'];

// Set headers for PDF-style download
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=LocalFinder_Bill_{$Rid}.html");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html>
<head>
    <title>LocalFinder Bill</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { padding: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>LocalFinder Invoice</h1>
    <p><strong>Request ID:</strong> <?= htmlspecialchars($bill['Rid']) ?></p>
    <p><strong>Customer:</strong> <?= htmlspecialchars($bill['Cname']) ?> | <?= htmlspecialchars($bill['Cmobile']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($bill['Email']) ?></p>
    <p><strong>Delivery Address:</strong> <?= htmlspecialchars($bill['DeliveryAddress']) ?></p>
    <p><strong>Timing:</strong> <?= htmlspecialchars($bill['DeliveryDate']) ?> <?= htmlspecialchars($bill['Timing']) ?></p>
    <p><strong>Instructions:</strong> <?= htmlspecialchars($bill['SpecialInstructions']) ?></p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Rate (₹)</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($bill['Pname']) ?></td>
                <td><?= $bill['Quantity'] ?></td>
                <td><?= $bill['Price'] ?></td>
                <td><?= $total ?></td>
            </tr>
        </tbody>
    </table>

    <h3 style="text-align: right;">Total Payable: ₹<?= $total ?></h3>
</body>
</html>
