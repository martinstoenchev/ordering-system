<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}

include("Db.php");
$db = new Db();
$connection = $db->getConnection();

$order_number = $_GET["num"];

$connection->prepare("UPDATE orders SET confirmed=? WHERE number=?")->execute([1, $order_number]);
header("Location: ProductsInQueue.php");
?>