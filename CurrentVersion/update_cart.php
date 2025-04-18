<?php
session_start();

if (!isset($_SESSION['cartData'])) {
    $_SESSION['cartData'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
    $cart = json_decode($_POST['cart_data'], true);
    if (is_array($cart)) {
        $_SESSION['cartData'] = $cart;
        http_response_code(200);
        echo json_encode(["success" => true]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid cart data"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
?>
