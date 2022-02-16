<?php
require_once "Utilities/helpers.php";
session_start();
// var_dump(date("YmdHis").rand());

function setError($message){
    $_SESSION['error'] = $message;
    header("Location: createUser.php");
    die();
}

if (isset($_POST['submit'])) {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2']) && isset($_POST['phone']) && isset($_POST['gender']) && isset($_POST['dob']) && (strlen($_POST['first_name']) > 0) && (strlen($_POST['last_name']) > 0) && (strlen($_POST['email']) > 0) && (strlen($_POST['password_1']) > 0) && (strlen($_POST['password_2']) > 0) && (strlen($_POST['phone']) > 0) && (strlen($_POST['gender']) > 0) && (strlen($_POST['dob']) > 0)){

        if (isset($_FILES['profile_image']['name'])){

            if ($_FILES['profile_image']['size'] > 1048576){
                setError('Profile Image Size should be lesss than 1 MB');
            }

            $target_dir = "profile_image/".date("YmdHis").rand();
            $target_file = $target_dir . basename($_FILES['profile_image']['name']);
            $check = getimagesize($_FILES['profile_image']['tmp_name']);
            
            if ($check !== false){
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)){
                    
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $email = $_POST['email'];
                    $password_1 = $_POST['password_1'];
                    $password_2 = $_POST['password_2'];
                    $phone = $_POST['phone'];
                    $gender = $_POST['gender'];
                    $dob = $_POST['dob'];
                    
                    if ($password_1 !== $password_2){
                        setError("Passwords not same");
                    }

                    if (strlen($password_1) < 8){
                        setError("Password should be atleast 8 characters long");
                    }


                    $regexNumber = "/.*\d.*/";
                    $regexUpperCaseLetter = "/.*[A-Z].*/";
                    $regexLowerCaseLetter = "/.*[a-z].*/";
                    $regexSpecialCharacters = "/.*[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\|\\\'\"\;\:\?\/\>\.\<\,].*/";

                    if (!preg_match($regexNumber, $password_1)){
                        setError("Password should have at least one number");
                    }

                    if (!preg_match($regexUpperCaseLetter, $password_1)){
                        setError("Password should have at least one Uppercase letter");
                    }

                    if (!preg_match($regexLowerCaseLetter, $password_1)){
                        setError("Password should have at least one Lowrcase letter");
                    }

                    if (!preg_match($regexSpecialCharacters, $password_1)){
                        setError("Password should have at least one Special Characters");
                    }


                    // sanitizing inputs 
                    $first_name = htmlspecialchars(strip_tags($first_name));
                    $last_name = htmlspecialchars(strip_tags($last_name));
                    $email = htmlspecialchars(strip_tags($email));
                    $phone = htmlspecialchars(strip_tags($phone));
                    $gender = htmlspecialchars(strip_tags($gender));
                    $dob = htmlspecialchars(strip_tags($dob));
                    $password = hashPassword($password_1);


                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        setError('Invalid Email');
                    } 

                    if (strlen($phone) < 10){
                        setError('Invalid Phone Number');
                    }

                    if (!in_array($gender, array('1', '2'))){
                        setError('Invalid Gender Value');
                    }

                    

                    $query = "INSERT INTO `User` (email, password, fname, lname, phone, gender, dateOfBirth, profile_image_url) VALUES (:email, :pass ,:fn, :ln, :ph, :gn, :dob, :url)";
                    $params = array(
                        ':email' => $email,
                        ':pass' => $password,
                        ':fn' => $first_name,
                        ':ln' => $last_name,
                        ':ph' => $phone,
                        ':gn' => $gender,
                        ':dob' => $dob,
                        ':url' => $target_file
                    );

                    try{
                        executeQuery($pdo, $query, $params);
                    } catch (Exception $e){
                        if ($e -> errorInfo[0] == '23000'){
                            setError('Email Id already present.<br> Login or use Forget password option');
                        } else {
                            setError($e -> errorInfo[2]);
                        }
                    }


                    $_SESSION['success'] = 'User Created Successfully';
                    
                    header("Location: login.php");
                    die();
                    



                } else {
                    setError("Error in Uploading image file");
                }


            } else {
                setError("Invalid Image File");
            }




        } else {
            setError('Profile Image required');
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
    <title>Create New Users - <?php echo $title ?></title>
    <link rel="stylesheet" href="Styles/loginStyle.css">
    <?php importBootstrapCSS();
    setFont(); ?>


</head>

<body>
    <div class="mainContainer d-flex justify-content-center align-items-center p-5">
        <div class="loginContainer p-5">
            <form action="" method="post" class="" id="createUserForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="error">
                        <?php if (isset($_SESSION['error'])){ echo $_SESSION['error']; unset($_SESSION['error']);  } ?>
                    </label><br>
                    <label class="text-success">
                        <?php if (isset($_SESSION['success'])){ echo $_SESSION['success']; unset($_SESSION['success']);  } ?>
                    </label>
                </div>
                <div class="form-group">
                    <label for="input_first_name">
                        First Name
                    </label>
                    <input type="text" class="form-control" name="first_name" id="input_first_name">

                </div>
                <div class="form-group">
                    <label for="input_last_name">
                        Last Name
                    </label>
                    <input type="text" class="form-control" name="last_name" id="input_last_name">

                </div>
                <div class="form-group">
                    <label for="input_email">
                        Email
                    </label>
                    <input type="email" class="form-control" name="email" id="input_email">

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
                <div class="form-group">
                    <label for="input_phone">
                        Enter Phone Number
                    </label>
                    <input type="tel" name="phone" id="input_phone" class="form-control">

                </div>

                <div class="form-group">
                    <label for="input_gender">
                        Select Gender
                    </label>
                    <select name="gender" id="input_gender" class="custom-select">
                        <option value="" selected>Select Gender</option>
                        <option value="1">Female</option>
                        <option value="2">Male</option>
                    </select>

                </div>

                <div class="form-group">
                    <label for="input_dob">
                        Date Of Birth
                    </label>
                    <input type="date" name="dob" id="input_dob" class="form-control">

                </div>

                <div class="form-group">
                    <label for="input_profile_image">
                        Profile Image
                    </label>
                    <input type="file" name="profile_image" id="input_profile" class="form-control-file">

                </div>

                <div class="submitButtonContainer d-flex justify-content-center align-items-center">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>


            </form>
        </div>

    </div>

    <?php importBootstrapJS() ?>

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

        jQuery.validator.addMethod('validateDate', function(value, element, params){
            dt = new Date(value);
            current_dt = new Date();
            if (dt > current_dt) {
                return false;
            } else {
                return true;
            }
        });

        
        jQuery('#createUserForm').validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 128
                },
                last_name: {
                    required: true,
                    maxlength: 128
                },
                email: "required",
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
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                gender: {
                    required: true
                },
                dob: {
                    required: true,
                    validateDate: true,
                },
                profile_image: {
                    required: true,
                    accept: "image/*"
                }

            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                    maxlength: "Your first name must be less than or equal to 128 characters"
                },
                last_name: {
                    required: "Please enter your last name",
                    maxlength: "Your last name must be less than or equal to 128 characters"
                },
                email: "Please Enter Valid Email",
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
                phone: {
                    required: "Please Enter Phone Number",
                    minlength: "Phone Number must be at least 10 digits long",
                    maxlength: "Phone Number cannot be more than 10 digits long",
                    digits: "Phone Number must be digits only"
                },
                gender: "Choose an Option",
                dob: {
                    require: "Please Enter Valid date",
                    validateDate: "Enter data from Past"
                },
                profile_image:{
                    required: "Please Upload Profile Image",
                    accept: "Please Select an Image File"
                }

            }
        });
    </script>

</body>

</html>