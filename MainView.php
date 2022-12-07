<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: CourierServiceView.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_POST) {
    include("Db.php");
    $db = new Db();
    $connection = $db->getConnection();

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username)) {
        $username_err = "Моля, въведете потребителското си име";
    }

    if (empty($password)) {
        $password_err = "Моля, въведете паролата си";
    }

    if (empty($username_err) && empty($password_err)) {
        $query = "SELECT id, username, password FROM user WHERE username='$username'";
        $user = $connection->query($query)->fetch();

        if (empty($user)) {
            $login_err = "Грешнo потребителско име";
        } else {
            $id = $user['id'];
            $user_name = $user['username'];
            $hashed_password = $user['password'];

            if (password_verify($password, $hashed_password)) {
                session_start();

                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $user_name;

                header("Location: /ivo_project/CourierServiceView.php");
            } else {
                $login_err = "Невалидна парола";
            }
        }

    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,800,900&display=swap&subset=cyrillic">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Вход в системата</h2>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Потребителско име" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="password" name="password" placeholder="Парола" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Вход">
            </div>
            <p><a href="Register.php">Регистрация на нов клиент</a></p>
            <p><a href="Admin.php">Вход като администратор</a></p>
        </form>
    </div>
</body>
</html>