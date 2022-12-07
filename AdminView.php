<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: MainView.php");
    exit;
}

$name_of_order = $number_of_order = $amount_due = $user_name = $addressee_name = $date_of_delivery = $view_option = $phone = "";
$name_of_order_err = $number_of_order_err = $amount_due_err = $user_name_err = $addressee_name_err = $date_of_delivery_err = $view_option_err = $phone_err = "";

if ($_POST) {
    $name_of_order = trim($_POST['name_of_order']);
    $number_of_order = trim($_POST['number_of_order']);
    $amount_due = trim($_POST['amount_due']);
    $user_name = trim($_POST['user_name']);
    $addressee_name = trim($_POST['addressee_name']);
    $date_of_delivery = $_POST['date_of_delivery'];
    $phone = $_POST['phone'];
    
    include("Db.php");
    $db = new Db();
    $connection = $db->getConnection();

    if (empty($name_of_order)) {
        $name_of_order_err = "Моля, въведете наименование на поръчката";
    }

    if (empty($number_of_order)) {
        $number_of_order_err = "Моля, въведете номер на поръчката";
    }

    if (empty($amount_due)) {
        $amount_due_err = "Моля, въведете дължимата сума";
    }

    if (empty($user_name)) {
        $user_name_err = "Моля, въведете потребителско име на подател";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $user_name)) {
        $user_name_err = "Потребителското име може да съдържа само букви, цифри и долна черта";
    } else {
        $sql = "SELECT id FROM user WHERE username = '$user_name'";
        $user = $connection->query($sql)->fetch();

        if (empty($user)) {
            $user_name_err = "Подател с такова потребителско име не съществува";
        } else {
            $user_id=$user['id'];
        }
    }

    if (empty($addressee_name)) {
        $adressee_name_err = "Моля, въведете потребителско име на получател";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $addressee_name)) {
        $adressee_name_err = "Потребителското име може да съдържа само букви, цифри и долна черта";
    } else {
        $sql = "SELECT id FROM user WHERE username = '$addressee_name'";
        $user = $connection->query($sql)->fetch();

        if (empty($user)) {
            $adressee_name_err = "Получател с такова потребителско име не съществува";
        } else {
            $addressee_id=$user['id'];
        }
    }

    if (empty($date_of_delivery)) {
        $date_of_delivery_err = "Моля, въведете дата на получаване на поръчката";
    }

    if  (empty($_POST['view_option'])) {
        $view_option_err = "Моля, изберете опция за преглед";
    } else {
        $view_option = $_POST['view_option'];
    }

    if (empty($phone)) {
        $phone_err = "Моля, въведете телефонен номер на куриер";
    }

    if(empty($name_of_order_err) && empty($number_of_order_err) && empty($amount_due_err) && empty($user_name_err) && empty($addressee_name_err) && empty($date_of_delivery_err) && empty($view_option_err) && empty($phone_err)) {
        $connection->prepare("INSERT INTO orders(name, number, amount_due, user_id, addressee_id, date_of_delivery, option_view, courier_phone_number) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute([$name_of_order, $number_of_order, $amount_due, $user_id, $addressee_id, $date_of_delivery, $view_option, $phone]);

        $sql = "SELECT number_of_orders FROM user WHERE id = '$user_id'";
        $user = $connection->query($sql)->fetch();        

        $number_of_ordersPlus1 = intval($user['number_of_orders']) + 1;

        $connection->prepare("UPDATE user SET number_of_orders='$number_of_ordersPlus1' WHERE id='$user_id'")->execute();

        $number_of_order = $amount_due = $user_name = $addressee_name = $date_of_delivery = $view_option = $phone = "";
        $number_of_order_err = $amount_due_err = $user_name_err = $addressee_name_err = $date_of_delivery_err = $view_option_err = $phone_err = "";
        echo "<div id='success-reg'> Успешно въведена поръчка </div>";
    }
}

?>

<script type="text/javascript">
    // close the div in 4 secs
    window.setTimeout("closeNotification();", 5000);
    function closeNotification() {
        document.getElementById("success-reg").style.display = " none";
        window.location.href = 'AdminView.php';
    }
</script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Куриерски услуги</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,800,900&display=swap&subset=cyrillic">
    <link rel="stylesheet" href="style.css">
</head>
<body>

        <div class="navbar">
            <a href="AdminView.php">Въведи поръчка</a>
            <a href="LogOut.php">Изход от административен профил</a>
        </div>
        <div class="wrapper">   
            <h2>Въвеждане на поръчка</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <input type="text" name="name_of_order" placeholder="Наименование на поръчка" class="form-control <?php echo (!empty($name_of_order_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name_of_order; ?>">
                    <span class="invalid-feedback"><?php echo $name_of_order_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="text" name="number_of_order" placeholder="Номер на поръчка" class="form-control <?php echo (!empty($number_of_order_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number_of_order; ?>">
                    <span class="invalid-feedback"><?php echo $number_of_order_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="text" name="amount_due" placeholder="Дължима сума" class="form-control <?php echo (!empty($amount_due_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $amount_due; ?>">
                    <span class="invalid-feedback"><?php echo $amount_due_err; ?></span>
                </div> 
                <div class="form-group">
                    <input type="text" name="user_name" placeholder="Потребителско име на подател" class="form-control <?php echo (!empty($user_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_name; ?>">
                    <span class="invalid-feedback"><?php echo $user_name_err; ?></span>
                </div>    
                <div class="form-group">
                    <input type="text" name="addressee_name" placeholder="Потребителско име на получател" class="form-control <?php echo (!empty($addressee_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $addressee_name; ?>">
                    <span class="invalid-feedback"><?php echo $addressee_name_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="date" name="date_of_delivery" placeholder="Дата на доставка" class="form-control <?php echo (!empty($date_of_delivery_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_of_delivery; ?>">
                    <span class="invalid-feedback"><?php echo $date_of_delivery_err; ?></span>
                </div>
                <div class="form-group">
                    <select name="view_option" class="form-control <?php echo (!empty($date_of_delivery_err)) ? 'is-invalid' : ''; ?>">
                        <option disabled selected value> Опция преглед </option>
                        <option value="yes">Да</option>
                        <option value="no">Не</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $view_option_err; ?></span>
                </div> 
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Телефонен номер на куриер" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                    <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                </div> 
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Въведи поръчка">
                    <input type="reset" class="btn btn-secondary ml-2" value="Изтрий всичко">
                </div>
            </form>
    </div>
</body>
</html>