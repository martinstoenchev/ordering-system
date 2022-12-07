<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}

include("Db.php");
$db = new Db();
$connection = $db->getConnection();
$addressee_id = $_SESSION["id"];

$query = "SELECT name, number, amount_due, confirmed FROM orders WHERE addressee_id = '$addressee_id' AND confirmed = 0";
$orders = $connection->query($query)->fetchAll();

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
    <?php if(!empty($orders)) { ?>
        <table id="queue-table">
            <tr>
                <th class="th-queue">Наименование</th>
                <th class="th-queue">Номер</th>
                <th class="th-queue">Дължима сума</th>
                <th class="th-queue"></th>
                <th class="th-queue"></th>
            </tr>
            <?php foreach ($orders as $order) { ?>
                    <?php if ($order['confirmed'] == 0) {  ?>
                        <tr>
                        <td class="td-queue">
                            <span><?= $order['name'] ?></span>
                        </td>
                        <td class="td-queue">
                            <span><?= $order['number'] ?></span>
                        </td>
                        <td class="td-queue">
                        <span><?= $order['amount_due'] ?></span>
                        </td>
                        <td class="td-queue">
                            <button id="queue_btn" onclick="location.href='ConfirmOrder.php?num=<?php echo $order['number'] ?>'">Потвърди</button>
                        </td>
                        <td class="td-queue">
                            <button id="queue_btn" onclick="location.href='DenyOrder.php?num=<?php echo $order['number'] ?>'">Откажи и изтрий</button>
                        </td>
                    </tr>
                    <?php } ?>
            <?php } ?>
            </table>
    <?php } else {
        echo "<div id='no_orders_in_q'>Нямате изчакващи поръчки!</div>"; }?>
    
</body>
</html>