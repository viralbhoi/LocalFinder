<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['Name'])) {
    header('Location: ./login.php');  
    return;
}

$vendor_id = $_SESSION['Id'];
// Fetch shop ID
$sql = "SELECT Sid FROM Shop WHERE Vid = :Vid";
$stmt = $pdo->prepare($sql);
$stmt->execute([':Vid' => $vendor_id]);
$shop_id_row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$shop_id_row) {
    echo "No shop found for this vendor.";
    exit;
}
$shop_id = $shop_id_row['Sid'];

try {
    $views_data = [];
    $orders_data = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        
        // Fetch views for the day
        $sql = "SELECT COUNT(*) AS views FROM product_views pv
                JOIN link_product_to_shop lps ON pv.Pid = lps.Pid
                WHERE lps.Sid = :Sid AND pv.view_date = :date";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':Sid' => $shop_id, ':date' => $date]);
        $views_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $views_data[] = (int)($views_result['views'] ?? 0);

        // Fetch orders for the day
        $sql = "SELECT COUNT(*) AS orders FROM delivery_requests dr
                JOIN link_product_to_shop lps ON dr.Pid = lps.Pid
                WHERE lps.Sid = :Sid AND dr.DeliveryDate = :date";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':Sid' => $shop_id, ':date' => $date]);
        $orders_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $orders_data[] = (int)($orders_result['orders'] ?? 0);
    }

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "An error occurred while fetching data.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="vendor_profile.php">My Profile</a></div>
                <div><a href="logout.php">Logout</a></div>
            </nav>
        </div>
    </header>

    <section class="vendor-profile">
        <h2>Vendor Dashboard</h2>

    <section class="vendor-profile">
        <div class="chart-container">
            <canvas id="viewsVsOrdersChart"></canvas>
        </div>

        <script>
            const ctx = document.getElementById('viewsVsOrdersChart').getContext('2d');
            const labels = ['6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', '1 day ago', 'Today'];
            const viewsData = <?= json_encode($views_data); ?>;
            const ordersData = <?= json_encode($orders_data); ?>;

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Product Views',
                        data: viewsData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Orders',
                        data: ordersData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Views/Orders'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        </script>
    </section>
</body>

</html>
