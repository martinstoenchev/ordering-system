<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Контакти</title>
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
        <table id="contacts_table">
            <tr>
                <td class="contacts_td">Адрес</td>
                <td class="contacts_td">село Цалапица, обшина Родопи, област Пловдив</td>
            </tr>
            <tr>
                <td class="contacts_td">Телефон за връзка</td>
                <td class="contacts_td">1234567890</td>
            </tr>
            <tr>
                <td class="contacts_td">Социални мрежи</td>
                <td class="contacts_td">
                <a href="https://www.facebook.com">
                    <img src="/ivo_project/fb.png" width="40" height="40">
                </a>
                <a href="https://www.instagram.com">
                    <img src="/ivo_project/ig.png" width="40" height="40">
                </a>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>