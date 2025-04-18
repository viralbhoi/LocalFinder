<?php
session_start();
require_once "pdo.php";

// Check if the user is logged in
if (!isset($_SESSION['Id'])) {
    die("Please log in to view this page.");
}

// Check if Rid is set in GET request
if (!isset($_GET['Rid'])) {
    die("Request ID (Rid) is missing.");
}

$request_id = $_GET['Rid'];

// Fetch delivery request details
$sql = "SELECT dr.Rid, dr.Cid, dr.Pid, dr.Quantity, dr.DeliveryAddress, dr.DeliveryDate,
            dr.Timing, dr.SpecialInstructions, dr.Status, c.Cname, c.Email, c.Cmobile,
            p.Pname, p.Price
        FROM delivery_requests dr
        JOIN customer c ON dr.Cid = c.Cid
        JOIN product p ON dr.Pid = p.Pid
        WHERE dr.Rid = :rid";

$stmt = $pdo->prepare($sql);
$stmt->execute([':rid' => $request_id]);
$delivery_request = $stmt->fetchALL(PDO::FETCH_ASSOC);

if (!$delivery_request) {
    die("Delivery request not found.");
}

// Calculate total amount

$total_amount =0;
for($i=0;$i<count($delivery_request);$i++){
$total_amount +=$delivery_request[$i]['Price'] * $delivery_request[$i]['Quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .bill {
            width: 80%;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }
        .details {
            margin-top: 20px;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .item-table th, .item-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="bill">
        <div class="header">
            <h1>Bill</h1>
        </div>

        <div class="details">
            <?php //print_r($delivery_request);?>
            <p><strong>Request ID:</strong> <?php echo htmlspecialchars($delivery_request[0]['Rid']); ?></p>
            <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($delivery_request[0]['Cname']); ?></p>
            <p><strong>Customer Email:</strong> <?php echo htmlspecialchars($delivery_request[0]['Email']); ?></p>
            <p><strong>Customer Mobile:</strong> <?php echo htmlspecialchars($delivery_request[0]['Cmobile']); ?></p>
            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($delivery_request[0]['DeliveryAddress']); ?></p>
            <p><strong>Delivery Date:</strong> <?php echo htmlspecialchars($delivery_request[0]['DeliveryDate']); ?></p>
            <p><strong>Delivery Time:</strong> <?php echo htmlspecialchars($delivery_request[0]['Timing']); ?></p>
            <p><strong>Special Instructions:</strong> <?php echo htmlspecialchars($delivery_request[0]['SpecialInstructions']); ?></p>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody><?php foreach( $delivery_request as $request) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['Pname']); ?></td>
                    <td><?php echo htmlspecialchars($request['Quantity']); ?></td>
                    <td><?php echo htmlspecialchars($request['Price']); ?></td>
                    <td><?php echo htmlspecialchars($request['Quantity']*$request['Price']); ?></td>
                </tr><?php } ?>
            </tbody>
        </table>

        <div class="total">
            <strong>Total Amount:</strong> <?php echo htmlspecialchars($total_amount); ?>
        </div>
    </div>
    <button id="backButton">Go Back</button>
    <!-- <form action="bill_download.php" method="GET" style="display:inline;">
        <input type="hidden" name="Rid" value="<?= htmlspecialchars($_GET['Rid']) ?>">
        <button type="submit">Download as PDF</button>
    </form> -->
    <button id="printBill">Download as PDF</button>
    
    

    </header>
    <script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.location.href="./index.php";
    });
</script>
<script>
    document.getElementById("printBill").addEventListener("click", function () {
        const printWindow = window.open('', '', 'width=800,height=600');

        const billContent = document.querySelector('.bill').innerHTML;

        const styles = `
            <style>
                body { font-family: Arial; margin: 40px; }
                h1 { text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
                .total { text-align: right; font-weight: bold; margin-top: 20px; }
            </style>
        `;

        printWindow.document.write(`
            <html>
            <head>
                <title>LocalFinder Bill</title>
                ${styles}
            </head>
            <body>
                <div class="bill">
                    ${billContent}
                </div>
                <script>
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() { window.close(); };
                    };
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    });
</script>

</body>
</html>
