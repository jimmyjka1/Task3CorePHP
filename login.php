<?php
require_once "Utilities/helpers.php";
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['email']);
unset($_SESSION['fname']);
unset($_SESSION['lname']);

function setError($message)
{
    $_SESSION['error'] = $message;
    header("Location: login.php");
    die();
}
if (isset($_POST['submit'])){
    if (isset($_POST['email']) && (strlen($_POST['email']) > 0) && isset($_POST['password']) && strlen($_POST['password'])){
        $pass = hashPassword($_POST['password']);
        $query = "SELECT * FROM `User` WHERE email = :eml AND password=:pass";
        $params = array(
            ":eml" => $_POST['email'],
            ":pass" => $pass
        );

        $result = executeQueryResult($pdo, $query, $params);
        if ($result){
            $_SESSION['user_id'] = $result[0]['id'];
            $_SESSION['email'] = $result[0]['email'];
            $_SESSION['fname'] = $result[0]['fname'];
            $_SESSION['lname'] = $result[0]['lname'];
            header("Location: index.php");
            die();
        } else {
            setError("Email or Password Incorrect");
        }

    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo $title ?></title>
    <link rel="stylesheet" href="Styles/loginStyle.css">
    <?php importBootstrapCSS();
    setFont(); ?>
</head>

<body>
    <?php require_once "Views/navbar.php"; ?>
    <div class="mainContainer d-flex justify-content-center align-items-center p-5">
        <div class="loginContainer d-flex justify-content-center align-items-center px-5 py-3 flex-column">
            <h1>Login</h1>
            <form method="POST" id="loginForm">
                <div>
                    <label class="error p-0 m-0">
                        <?php if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        } ?>
                    </label><br>
                    <label class="text-success p-0 m-0">
                        <?php if (isset($_SESSION['success'])) {
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        } ?>
                    </label>
                </div>
                <div class="form-group">
                    <label for="input_email">
                        Email
                    </label>
                    <input type="email" name="email" id="input_email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="input_password">
                        Password
                    </label>
                    <input type="password" name="password" id="input_password" class="form-control">
                </div>
                <div class="buttonContainer d-flex justify-content-center align-items-center flex-wrap">
                    <button class="btn btn-primary m-1" type="submit" name="submit">
                        Login
                    </button>
                    <a href="forgotPassword.php" class="my-3">Forgot Password</a>
                </div>
            </form>
            
            <a href="createUser.php" class="btn btn-info m-1">Create New Account</a>

        </div>
    </div>

    <?php require_once "Views/footer.php";importBootstrapJS(); ?>

    <script>
        $('#loginForm').validate({
            rules: {
                email: "required",
                password: "required"
            },
            messages: {
                email: "Please Enter Valid Email",
                password: "Please Enter Valid Password"
            }
        });
    </script>

</body>

</html>