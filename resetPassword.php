<?php
require_once "Utilities/helpers.php";
session_start();
function setError($message)
{
    $_SESSION['error'] = $message;
    header("Location: resetPassword.php");
    die();
}

if (isset($_GET['token'])) {
    $query = "SELECT user_id FROM ForgetPassword WHERE token=:tk";
    $params = array(
        ':tk' => $_GET['token']
    );

    $result = executeQueryResult($pdo, $query, $params)[0];

    if ($result) {
        $user_id = $result['user_id'];
        $token = $_GET['token'];
    } else {
        $_SESSION['error'] = "Invalid Link";
        header("Location: login.php");
        die();
    }
} else {
    $_SESSION['error'] = "Invalid Link";
    header("Location: login.php");
    die();
}


if (isset($_POST['submit']) && $_POST['token']){
    if (isset($_POST['password_1']) && isset($_POST['password_2']) && (strlen($_POST['password_1']) > 0) && (strlen($_POST['password_2']) > 0)) {
        // check if token is valid and retrive corresponding user_id 
        $query = "SELECT user_id FROM ForgetPassword WHERE token=:tk";
        $params = array(
            ':tk' => $_POST['token']
        );

        $result = executeQueryResult($pdo, $query, $params)[0];

        if ($result) {
            $user_id = $result['user_id'];
            $token = $_POST['token'];
        } else {
            $_SESSION['error'] = "Invalid Link";
            header("Location: login.php");
            die();
        }
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];

        if ($password_1 !== $password_2) {
            setError("Passwords not same");
        }

        if (strlen($password_1) < 8) {
            setError("Password should be atleast 8 characters long");
        }

        $regexNumber = "/.*\d.*/";
        $regexUpperCaseLetter = "/.*[A-Z].*/";
        $regexLowerCaseLetter = "/.*[a-z].*/";
        $regexSpecialCharacters = "/.*[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\|\\\'\"\;\:\?\/\>\.\<\,].*/";

        if (!preg_match($regexNumber, $password_1)) {
            setError("Password should contain atleast one number");
        }

        if (!preg_match($regexUpperCaseLetter, $password_1)) {
            setError("Password should contain atleast one uppercase letter");
        }

        if (!preg_match($regexLowerCaseLetter, $password_1)) {
            setError("Password should contain atleast one lowercase letter");
        }

        if (!preg_match($regexSpecialCharacters, $password_1)) {
            setError("Password should contain atleast one special character");
        }

        $password_1 = hashPassword($password_1);

        $query = "UPDATE `User` SET password=:pass WHERE id=:id";
        $params = array(
            ':pass' => $password_1,
            ':id' => $user_id
        );

        $result = executeQueryResult($pdo, $query, $params);

        // delete all entries with corresponding user_id from forgetPassword table 
        $query = "DELETE FROM ForgetPassword WHERE user_id=:id";
        $params = array(
            ':id' => $user_id
        );

        $result = executeQueryResult($pdo, $query, $params);

        $_SESSION['success'] = "Password changed successfully";
        header("Location: login.php");
        die();
        

    } else {
        setError("Password not set");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - <?php echo $title ?></title>
    <link rel="stylesheet" href="Styles/loginStyle.css">
    <?php importBootstrapCSS();
    setFont(); ?>
</head>

<body>
    <div class="mainContainer d-flex justify-content-center align-items-center p-5">
        <div class="loginContainer d-flex justify-content-center align-items-center px-5 py-3 flex-column">
            <h1>Reset Password</h1>
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
                    <label for="input_password_1">
                        Enter Password
                    </label>
                    <input type="password" name="password_1" id="input_password_1" class="form-control">
                </div>
                <div class="form-group">
                    <label for="input_password_2">
                        Reenter Password
                    </label>
                    <input type="password" name="password_2" id="input_password_2" class="form-control">
                    <input type="hidden" name="token" value="<?php echo $token ?>">
                </div>
                <div class="buttonContainer d-flex justify-content-center align-items-center flex-wrap">
                    <button class="btn btn-primary m-1" type="submit" name="submit" value="submit">
                        Change Password
                    </button>
                </div>
            </form>

        </div>
    </div>

    <?php importBootstrapJS(); ?>

    <script>
        jQuery.validator.addMethod('validatePassword', function(value, element, params) {
            password_1Value = element.value;
            regexNumber = /^.*\d.*$/;
            regexUpperCaseLetter = /^.*[A-Z].*$/
            regexLowerCaseLetter = /^.*[a-z].*$/
            regexSpecialCharacters = /^.*[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\|\\\'\"\;\:\?\/\>\.\<\,].*$/;

            if (password_1Value.length <= 7) {
                return false;
            } else if (!regexNumber.test(password_1Value)) {
                return false;
            } else if (!regexUpperCaseLetter.test(password_1Value)) {
                return false;
            } else if (!regexLowerCaseLetter.test(password_1Value)) {
                return false;
            } else if (!regexSpecialCharacters.test(password_1Value)) {
                return false
            } else {
                return true;
            }

        });

        $(document).ready(function() {
                $('#loginForm').validate({
                    rules: {
                        old_password: "required",
                        password_1: {
                            required: true,
                            validatePassword: true,
                            minlength: 8,
                            maxlength: 128,

                        },
                        password_2: {
                            required: true,
                            equalTo: "#input_password_1",
                            minlength: 8,
                            maxlength: 128,
                        },
                    },
                    messages: {
                        old_password: "Old Password is Required",
                        password_1: {
                            required: "Please Enter Password",
                            minlength: "Password must be at least 8 characters long",
                            maxlength: "Password cannot be more than 128 characters long",
                            validatePassword: "Password must contain atleast<br> one number, one uppercase<br> letter, one lowercase letter,<br> and one special character"
                        },
                        password_2: {
                            required: "Please Enter Password",
                            minlength: "Password must be at least 8 characters long",
                            maxlength: "Password cannot be more than 128 characters long",
                            equalTo: "Passwords do not match"
                        },
                    }
                });
            });
    </script>


</body>

</html>