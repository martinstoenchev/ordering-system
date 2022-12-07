<?php

    $first_name = $last_name = $username = $password = $repassword = $email = $phone = "";
    $first_name_err = $last_name_err = $username_err = $password_err = $repassword_err = $email_err = $phone_err = "";

    if ($_POST) {
        $first_name = ($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $email = trim($_POST['email']);
        $phone = $_POST['phone'];
        
        include("Db.php");
        $db = new Db();
        $connection = $db->getConnection();

        if (empty($first_name)) {
            $first_name_err = "Моля, въведете име";
        }

        if (empty($last_name)) {
            $last_name_err = "Моля, въведете фамилия";
        }

        if (empty($username)) {
            $username_err = "Моля, въведете потребителско име";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $username_err = "Потребителското име може да съдържа само букви, цифри и долна черта";
        } else {
            $sql = "SELECT id FROM user WHERE username = '$username'";
            $user = $connection->query($sql)->fetch();

            if (!empty($user)) {
                $username_err = "Потребителското име е заето";
            }
        }

        if (empty($password)) {
            $password_err = "Моля, въведете парола";
        } elseif (strlen($password) < 6) {
            $password_err = "Паролата трябва да е дълга поне 6 символа";
        }

        if (empty($repassword)) {
            $repassword_err = "Моля, потвърдете паролата";
        } elseif (empty($password_err) && ($password != $repassword)){
            $repassword_err = "Паролите не съвпадат";
        }

        if (empty($email)) {
            $email_err = "Моля, въведете email адрес";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Невалиден формат за email адрес";
        } else {
            $sql = "SELECT id FROM user WHERE email = '$email'";
            $user = $connection->query($sql)->fetch();

            if (!empty($user)) {
                $email_err = "Вече има регистриран потребител с такъв email адрес";
            }
        }

        if (empty($phone)) {
            $phone_err = "Моля, въведете телефонен номер";
        }

        if(empty($first_name_err) && empty($last_name_err) && empty($username_err) && empty($password_err) && empty($repassword_err) && empty($email_err) && empty($phone_err)) {
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $connection->prepare("INSERT INTO user(first_name, last_name, username, email, password, phone) VALUES(?, ?, ?, ?, ?, ?)")->execute([$first_name, $last_name, $username, $email, $param_password, $phone]);
            $first_name = $last_name = $username = $password = $repassword = $email = $phone = "";
            $first_name_err = $last_name_err = $username_err = $password_err = $repassword_err = $email_err = $phone_err = "";
            echo "<div id='success-reg'> Успешна регистрация </div>";
        }
    }

?>

<script type="text/javascript">
    // close the div in 4 secs
    window.setTimeout("closeNotification();", 5000);
    function closeNotification() {
        document.getElementById("success-reg").style.display = " none";
        window.location.href = 'MainView.php';
    }
</script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,800,900&display=swap&subset=cyrillic">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">   
        <h2>Регистрация</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="first_name" placeholder="Име" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Фамилия" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="text" name="username" placeholder="Потребителско име" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="password" name="password" placeholder="Парола" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="repassword" placeholder="Потвърдете паролата" class="form-control <?php echo (!empty($repassword_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repassword; ?>">
                <span class="invalid-feedback"><?php echo $repassword_err; ?></span>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email адрес" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Телефонен номер (10 цифри)" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Регистрирай">
                <input type="reset" class="btn btn-secondary ml-2" value="Изтрий всичко">
            </div>
        </form>
    </div>
</body>
</html>