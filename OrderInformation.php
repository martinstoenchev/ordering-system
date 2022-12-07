<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}

$number_of_order = $_SESSION['order_number'];

include("Db.php");
$db = new Db();
$connection = $db->getConnection();

$query = "SELECT name, number, amount_due, user_id, addressee_id, date_of_delivery, option_view, courier_phone_number FROM orders WHERE number = '$number_of_order'";
$order = $connection->query($query)->fetch();

$name_of_order = $order['name'];
$order_date = $order['date_of_delivery'];
$amount_due = $order['amount_due'];
$user_id = $order['user_id'];
$addressee_id = $order['addressee_id'];
$option_view = $order['option_view'];
$courier_phone_number = $order['courier_phone_number'];

$query = "SELECT first_name, last_name, username, phone FROM user WHERE id = '$addressee_id'";
$addressee = $connection->query($query)->fetch();

$addressee_fname = $addressee['first_name'];
$addressee_lname = $addressee['last_name'];
$addressee_username = $addressee['username'];
$addressee_phone = $addressee['phone'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Куриерски услуги</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,800,900&display=swap&subset=cyrillic">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
    <img id="logo" src="/ivo_project/logo.png" width="110" height="43">
        <a href="MyProfile.php">Моят профил</a>
        <a href="Contacts.php">Контакти</a>
        <div class="dropdown">
            <button class="dropbtn">Услуги 
            <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="CourierServiceView.php">Проследи товарителница</a>
            </div>
        </div>
        <a href="ProductsInQueue.php">Продукти в опашка</a>
    </div>
    <div class="my-style">
        <div id="order_date">
            Пратката ще бъде доставена на <?php echo $order_date ?>
        </div>
        <table>
            <tr>
                <td>Наименование на поръчката</td>
                <td><?php echo $name_of_order ?></td>
            </tr>
            <tr>
                <td>Име на получател</td>
                <td><?php echo $addressee_fname . " " . $addressee_lname ?></td>
            </tr>
            <tr>
                <td>Телефонен номер на получател</td>
                <td><?php echo $addressee_phone ?></td>
            </tr>
            <tr>
                <td>Дължима сума</td>
                <td><?php echo $amount_due ?></td>
            </tr>
            <tr>
                <td>Опция преглед</td>
                <td>
                    <?php if ($option_view == 0) { ?>
                        Не
                    <?php } else { ?>
                        Да
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>Телефон за връзка с куриер</td>
                <td><?php echo $courier_phone_number ?></td>
            </tr>
        </table>
    </div>
</body>
</html>