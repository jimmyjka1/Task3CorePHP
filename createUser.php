<?php
require_once "Utilities/helpers.php";
session_start();

if (isset($_POST['submit'])) {
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
        <div class="loginContainer w-75 p-5">
            <form action="#" method="post" class="" id="createUserForm">
                <div class="form-group">
                    <label for="input_first_name">
                        First Name
                    </label>
                    <input type="text" class="form-control" name="first_name" id="input_first_name">

                </div>
                <div class="form-group">
                    <label for="input_last_name">
                        Last Name:
                    </label>
                    <input type="text" class="form-control" name="last_name" id="input_last_name">

                </div>
                <div class="form-group">
                    <label for="input_email">
                        Email:
                    </label>
                    <input type="e,ao;" class="form-control" name="email" id="input_email">

                </div>
                <div class="form-group">
                    <label for="input_password_1">
                        Enter Password:
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
                        Enter Phone Number:
                    </label>
                    <input type="tel" name="phone" id="input_phone" class="form-control">

                </div>

                <div class="form-group">
                    <label for="input_gender">
                        Select Gender:
                    </label>
                    <select name="gender" id="input_gender" class="custom-select">
                        <option value="" selected>Select Gender</option>
                        <option value="1">Female</option>
                        <option value="2">Male</option>
                    </select>

                </div>

                <div class="form-group">
                    <label for="input_dob">
                        Date Of Birth:
                    </label>
                    <input type="date" name="dob" id="input_dob" class="form-control">

                </div>

                <div class="form-group">
                    <label for="input_profile_image">
                        Profile Image:
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
                    validatePassword: "Password must contain at least one number, one uppercase letter, one lowercase letter, and one special character"
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