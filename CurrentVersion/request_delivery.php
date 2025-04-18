<?php
session_start();
require_once "pdo.php";

// Check if the user is logged in (you might have your own authentication system)
if (!isset($_SESSION['Id'])) {
    die("Please log in to request a delivery.");
}

// Process the delivery request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve customer information from the session
    $customer_id = $_SESSION['Id'];

    // Retrieve cart data from the POST request
    if (isset($_POST['cart_data'])) {
        $cart_data_json = $_POST['cart_data'];
        $cart = json_decode($cart_data_json, true); // Decode JSON to array
    } else {
        die("Error: Cart data not received.");
    }

    // Validate and sanitize delivery details
    $delivery_address = filter_var($_POST['delivery_address'], FILTER_SANITIZE_STRING);
    $delivery_date = $_POST['delivery_date'];
    $delivery_timing = $_POST['delivery_timing'];
    $special_instructions = filter_var($_POST['special_instructions'], FILTER_SANITIZE_STRING);

    if (empty($delivery_address) || empty($delivery_date) || empty($delivery_timing)) {
        die("Please fill in all required fields.");
    }

    // Insert delivery request into the database
    try {
        // Start a transaction to ensure atomicity (all operations succeed or fail together)
        $pdo->beginTransaction();

        $request_id = uniqid('R'); // Generate a unique ID for the request

        // Iterate through each item in the cart
        foreach ($cart as $item) {
            $product_name = $item['name'];
            $quantity = $item['quantity'];

            // Get the Pid (Product ID) from the product name
            $stmt = $pdo->prepare("SELECT Pid FROM product WHERE Pname = :pname");
            $stmt->execute([':pname' => $product_name]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                throw new Exception("Product not found: " . $product_name);
            }

            $product_id = $product['Pid'];

            // Prepare the SQL statement to insert the delivery request
            $sql = "INSERT INTO delivery_requests (Rid, Cid, Pid, Quantity, DeliveryAddress, DeliveryDate, Timing, SpecialInstructions, Status)
                    VALUES (:rid, :cid, :pid, :quantity, :delivery_address, :delivery_date, :timing, :special_instructions, :status)";
            $stmt = $pdo->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':rid', $request_id);
            $stmt->bindParam(':cid', $customer_id);
            $stmt->bindParam(':pid', $product_id);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':delivery_address', $delivery_address);
            $stmt->bindParam(':delivery_date', $delivery_date);
            $stmt->bindParam(':timing', $delivery_timing);
            $stmt->bindParam(':special_instructions', $special_instructions);
            $stmt->bindValue(':status', 'Pending'); // Set the initial status

            // Execute the statement
            $stmt->execute();
        }

        // Commit the transaction if all insertions were successful
        $pdo->commit();

        echo 'Delivery request submitted successfully! Request ID:' . $request_id;
        header('Refresh:30,url=bill.php?Rid='.$request_id);
        //header('location:index.php');
        
    } catch (Exception $e) {
        // Rollback the transaction if any error occurred
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
