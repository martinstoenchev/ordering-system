<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}


$number_of_order = $number_of_order_err = "";

if ($_POST) {

    include("Db.php");
    $db = new Db();
    $connection = $db->getConnection();

    $number_of_order = trim($_POST['trace_order']);

    if (empty($number_of_order)) {
        $number_of_order_err = "Моля, въведете номер на товарителница";
    }

    if (empty($number_of_order_err)) {
        $query = "SELECT number, amount_due, user_id, date_of_delivery, option_view, courier_phone_number, confirmed FROM orders WHERE number = '$number_of_order'";
        $order = $connection->query($query)->fetch();

        if (empty($order)) {
            $number_of_order_err = "Няма товарителница с такъв номер!";
        } elseif($order['confirmed'] == 0) {
            $number_of_order_err = "Поръчката с този номер не е получила потвърждение от получателя си. Моля, изчакайте, докато получателят потвърди или откаже поръчката си!";
        } else {
            $_SESSION['order_number'] = $number_of_order;
            header("Location: OrderInformation.php");
        }

    }
}

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
    <div class="wrapper">
        <h2 id="trace">Проследи пратка</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" id="trace_order" name="trace_order" placeholder="Въведете номер на товарителница" class="mainLoginInput" value="<?php echo $number_of_order; ?>">
                <span id="no_order" class="invalid-feedback"><?php echo $number_of_order_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" id="trace_btn" class="btn btn-primary" value="Проследи">
            </div>
        </form>
    </div>
</body>
</html>