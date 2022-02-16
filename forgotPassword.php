<?php
require_once "Utilities/helpers.php";
session_start();

function setError($message)
{
    $_SESSION['error'] = $message;
    header("Location: forgotPassword.php");
    die();
}


if (isset($_POST['submit'])){
    

    $query = "SELECT id FROM `User` WHERE email=:em";
    $params = array(
        ':em' => $_POST['email']
    );
    $result = executeQueryResult($pdo, $query, $params)[0];
    if ($result){
        $user_id = $result['id'];
        $token = hash('sha256', $user_id.date("YmdHis"));
        
        $query = "INSERT INTO `ForgetPassword` VALUES (:tk, :id)";
        $params = array(
            ':tk' => $token,
            ':id' => $user_id
        );

        try{
            $res = executeQuery($pdo, $query, $params);
            // ---------code to send mail ---------
            $body = '<style>
            body{margin-top:20px;}
        </style>
        <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
            <tbody>
                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                    <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                        <div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope="" itemtype="http://schema.org/ConfirmAction" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                                <tbody><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;padding: 30px;border: 3px solid #67a8e4;border-radius: 7px; background-color: #fff;" valign="top">
                                        <meta itemprop="name" content="Confirm Email" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <tbody><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                    We have recieved a request to reset your password. 
                                                </td>
                                            </tr>
                                            
                                            <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" itemprop="handler" itemscope="" itemtype="http://schema.org/HttpActionHandler" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                    <a href="https://'.$_SERVER['SERVER_NAME'].'/resetPassword.php?token='.$token.'" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #f06292; margin: 0; border-color: #f06292; border-style: solid; border-width: 8px 16px;">Confirm
                                                        email address</a>
                                                </td>
                                            </tr>
                                            <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                    If you cannot click this button, use this  https://'.$_SERVER['SERVER_NAME'].'/resetPassword.php?token='.$token.' link 
                                                </td>
                                            </tr>
                                            <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                    <b>Hexashop</b>
                                                    <p>Support Team</p>
                                                </td>
                                            </tr>
        
                                            <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" style="text-align: center;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0;" valign="top">
                                                   &copy; '.date('Y').' Hexashop All rights reserved.
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>';
            // var_dump($body);
            $header = "From: ".$mail."\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            $subject = "Password Reset";
            $res = mail($_POST['email'], $subject, $body, $header);


            // ------
            $_SESSION['success'] = "Link to reset password sent to<br> your mail id";
            header("Location: forgotPassword.php");
            die();
        } catch(Exception $e){
            setError("Error: ". $e -> errorInfo[1]);
        }

        


    } else {
        setError("This Email ID is not registered");
    }

    

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?php echo $title ?></title>
    <link rel="stylesheet" href="Styles/loginStyle.css">
    <?php importBootstrapCSS();
    setFont(); ?>
</head>

<body>
    <?php require_once "Views/navbar.php" ?>
    <div class="mainContainer d-flex justify-content-center align-items-center p-5">
        <div class="loginContainer d-flex justify-content-center align-items-center px-5 py-3 flex-column">
            <h1>Forgot Password</h1>
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
                <div class="buttonContainer d-flex justify-content-center align-items-center flex-wrap">
                    <button class="btn btn-primary m-1" type="submit" name="submit" value="submit">
                        Send Reset Link
                    </button>
                    <a href="login.php" class="btn btn-info m-1">Cancel</a>
                </div>
            </form>
            
        </div>
    </div>

    <?php require_once "Views/footer.php";importBootstrapJS(); ?>

    <script>
        $('#loginForm').validate({
            rules: {
                email: "required",
            },
            messages: {
                email: "Please Enter Valid Email",
            }
        });
    </script>
    
    
</body>

</html>


