<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}

include("Db.php");
$db = new Db();
$connection = $db->getConnection();

$username = $_SESSION['username'];
$query = "SELECT first_name, last_name, username, email, phone, number_of_orders FROM user WHERE username = '$username'";
$user = $connection->query($query)->fetch();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Моят профил</title>
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
        <table>
            <th>Име</th>
            <th>Фамилия</th>
            <tr>
                <td> <?php echo $user['first_name'] ?> </td>
                <td> <?php echo $user['last_name'] ?> </td>
            </tr>
        </table>

        <table>
            <th>Потребителско име</th>
            <th>Email адрес</th>
            <tr>
                <td> <?php echo $user['username'] ?> </td>
                <td> <?php echo $user['email'] ?> </td>
            </tr>
        </table>

        <table>
            <th>Телефонен номер</th>
            <th>Брой направени поръчки</th>
            <tr>
                <td> <?php echo $user['phone'] ?> </td>
                <td> <?php echo $user['number_of_orders'] ?> </td>
            </tr>
        </table>
        <form action="LogOut.php">
        <input id="trace_btn" type="submit" value="Изход от профила"/>
        </form>
    </div>
</body>
</html>