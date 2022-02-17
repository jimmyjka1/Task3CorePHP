<?php
session_start();
require_once "Utilities/helpers.php";
loginRequired();

function setError($message)
{
    $_SESSION['error'] = $message;
    header("Location: changePassword.php");
    die();
}
// code to get profile image url 
if (isset($_SESSION['user_id'])) {
    $query = "SELECT * FROM `User` WHERE id=:id";
    $params = array(
        ":id" => $_SESSION['user_id']
    );

    $result = executeQueryResult($pdo, $query, $params)[0];
    $profile_url = $result['profile_image_url'];
}


if (isset($_POST['submit'])) {
    if (isset($_POST['old_password']) && isset($_POST['password_1']) && isset($_POST['password_2']) && (strlen($_POST['old_password']) > 0) && (strlen($_POST['password_1']) > 0) && (strlen($_POST['password_2']) > 0)) {

        
        // $query = "SELECT password FROM `User` WHERE id=:id";
        // $params = array(
        //     ':id' => $_SESSION['user_id']
        // );
        // $result = executeQueryResult($pdo, $query, $params);
        if ($result) {
            $pass = $result['password'];
            $old_password = hashPassword($_POST['old_password']);

            if ($pass !== $old_password) {
                setError("Incorrect Old Password");
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
                setError("Password should have at least one number");
            }

            if (!preg_match($regexUpperCaseLetter, $password_1)) {
                setError("Password should have at least one Uppercase letter");
            }

            if (!preg_match($regexLowerCaseLetter, $password_1)) {
                setError("Password should have at least one Lowrcase letter");
            }

            if (!preg_match($regexSpecialCharacters, $password_1)) {
                setError("Password should have at least one Special Characters");
            }


            $password = hashPassword($password_1);

            $query = "UPDATE `User` SET password=:pass WHERE id=:id";
            $params = array(
                ':pass' => $password,
                ':id' => $_SESSION['user_id']
            );


            if (executeQuery($pdo, $query, $params)){
                $_SESSION['success'] = "Password Updated Successfully";
                header("Location: changePassword.php");
                die();
            } else {
                setError("Cannot Update Passwords");
            }
        } else {
            setError('Incorrect Old Password');
        }
    } else {
        setError("All Fields are required");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/indexStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
    <?php importBootstrapCSS(); ?>


    <title>Change Password - <?php echo $title ?></title>
</head>

<body>
    <?php require_once "Views/navbar.php" ?>


    <div class="editProfileContainer pt-5 d-flex justify-content-center align-items-center flex-column">
        <h1 class="mb-5">Change Password</h1>
        <div class="formContainer mb-5">
            <span class="text-danger">
                <?php
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }

                ?>
            </span>
            <span class="text-success">
                <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                }

                ?>
            </span>
            <form action="changePassword.php" method="post" id="editUserForm">
                <div class="form-group">
                    <label for="input_old_password">
                        Enter Old Password
                    </label>
                    <input type="password" name="old_password" id="input_old_password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="input_password_1">
                        Enter Password
                    </label>
                    <input type="password" name="password_1" id="input_password_1" class="form-control">

                </div>
                <div class="form-group">
                    <label for="input_password_2">
                        Re-Enter Password
                    </label>
                    <input type="password" name="password_2" id="input_password_2" class="form-control">
                </div>
                <div class="submitButtonContainer d-flex justify-content-center align-items-center">
                    <button type="submit" name="submit" class="btn btn-primary" value="submit">Submit</button>
                </div>
            </form>
        </div>


        <?php require_once "Views/footer.php";importBootstrapJS(); ?>
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
                $('#editUserForm').validate({
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
                            validatePassword: "Password must contain atleast one number,<br> one uppercase letter, one lowercase letter, and one<br> special character"
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
    </div>

</body>

</html>