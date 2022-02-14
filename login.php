<?php 
    require_once "Utilities/helpers.php";
    session_start();
    
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo $title ?></title>
    <link rel="stylesheet" href="Styles/loginStyle.css">

</head>
<body>
    <div class="loginContainer">
        <form action="login.php" method="post">
            Email: <input type="email" name="email" id="input_email" required><br>
            Password: <input type="password" name="password" id="input_password"  title="Please Enter password" required><br>
            <button type="submit">Submit</button>
            <button onclick="window.location='createUser.php'">Create User</button>
        </form>
    </div>
</body>
</html>
