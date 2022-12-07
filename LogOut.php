<?php

session_start();

$_SESSION = array();

session_destroy();

echo "<div id='success-logout'> Успешно излизане от профила </div>";

?>

<script type="text/javascript">
    // close the div in 2 secs
    window.setTimeout("closeNotification();", 2000);
    function closeNotification() {
        document.getElementById("success-logout").style.display = " none";
        window.location.href = 'MainView.php';
    }
</script>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,800,900&display=swap&subset=cyrillic">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>