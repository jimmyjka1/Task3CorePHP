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
    <?php importBootstrapCSS(); setFont(); ?>


</head>

<body>
    <div class="mainContainer d-flex justify-content-center align-items-center p-5">
        <div class="loginContainer w-75">
            <form action="#" method="post" class="" id="createUserForm" novalidate>
                <div class="form-group">
                    <label for="input_first_name">
                        First Name:
                    </label>
                    <input type="text" class="form-control" name="first_name" id="input_first_name" required oninvalid="this.setCustomValidity('First Name Required')" oninput="this.setCustomValidity('')">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Valid First Name!
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_last_name">
                        Last Name:
                    </label>
                    <input type="text" class="form-control" name="last_name" id="input_last_name" required oninvalid="this.setCustomValidity('Last Name Required')" oninput="this.setCustomValidity('')">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Valid Last Name!
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_email">
                        Email:
                    </label>
                    <input type="e,ao;" class="form-control" name="email" id="input_email" required oninvalid="this.setCustomValidity('Enter Proper Email')" oninput="this.setCustomValidity('')">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Enter Proper Email!
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_password_1">
                        Enter Password:
                    </label>
                    <input type="password" name="password_1" id="input_password_1" class="form-control" required>
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback" id="invalid_feedback_password1">
                        Enter Proper Email
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_password_2">
                        Re-Enter Password:
                    </label>
                    <input type="password" name="password_2" id="input_password_2" class="form-control">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Both Password Should be Same
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_phone">
                        Enter Phone Number:
                    </label>
                    <input type="tel" name="phone" id="input_phone" class="form-control">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Please enter valid 10 digit phone number
                    </div>
                </div>

                <div class="form-group">
                    <label for="input_gender">
                        Select Gender: 
                    </label>
                    <select name="gender" id="input_gender" class="custom-select">
                        <option value="0" selected>Select Gender</option>
                        <option value="1">Female</option>
                        <option value="2">Male</option>
                    </select>
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Please Select Valid Gender
                    </div>
                </div>

                <div class="form-group">
                    <label for="input_dob">
                        Date Of Birth:
                    </label>
                    <input type="date" name="dob" id="input_dob" class="form-control">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Valid Date
                    </div>
                </div>

                <div class="form-group">
                    <label for="input_profile_image">
                        Profile Image:
                    </label>
                    <input type="file" name="profile_image" id="input_profile" class="form-control-file">
                    <div class="valid-feedback">
                        Looks Good
                    </div>
                    <div class="invalid-feedback">
                        Please Select Profile Picture
                    </div>
                </div>



                <button type="submit" name="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>

    </div>

    <?php importBootstrapJS() ?>

    <script>
        function validateForm(){
                firstName = $('#input_first_name');
                lastName = $('#input_last_name');
                email = $('#input_email');
                password_1 = $('#input_password_1');
                password_2 = $('#input_password_2');
                phone = $('#input_phone');
                gender = $('#input_gender');
                dob = $("#input_dob");
                profile_pic = $('#input_profile');

                firstNameValue = firstName.val();
                lastNameValue = lastName.val();
                emailValue = email.val();
                password_1Value = password_1.val();
                password_2Value = password_2.val();
                phoneValue = phone.val();
                genderValue = gender.val();
                dobValue = dob.val();
                picValue = profile_pic.val()

                if (firstNameValue.length <= 0){
                    firstName.removeClass(['is-valid', 'is-invalid']);
                    firstName.addClass('is-invalid');
                } else {
                    firstName.removeClass(['is-valid', 'is-invalid']);
                    firstName.addClass('is-valid');
                }

                if (lastNameValue.length <= 0){
                    lastName.removeClass(['is-valid', 'is-invalid']);
                    lastName.addClass('is-invalid');
                } else {
                    lastName.removeClass(['is-valid', 'is-invalid']);
                    lastName.addClass('is-valid');
                }

                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]+)+$/;
                if(!regex.test(emailValue)){
                    email.removeClass(['is-valid', 'is-invalid']);
                    email.addClass('is-invalid');
                } else {
                    email.removeClass(['is-valid', 'is-invalid']);
                    email.addClass('is-valid');
                }

                regexNumber = /^.*\d.*$/;
                regexUpperCaseLetter = /^.*[A-Z].*$/
                regexLowerCaseLetter = /^.*[a-z].*$/
                regexSpecialCharacters = /^.*[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\|\\\'\"\;\:\?\/\>\.\<\,].*$/;

                console.log(password_1Value.length, "this is great");
                if (password_1Value.length <= 7) {
                    $('#invalid_feedback_password1').text('Your password should contain atleast 8 characters, atleast one number, one upper case letter,one lower case letter, and one special character');
                    password_1.removeClass(['is-valid', 'is-invalid']);
                    password_1.addClass('is-invalid');
                } else if (!regexNumber.test(password_1Value)){
                    $('#invalid_feedback_password1').text('Should contain at least one number!');
                    password_1.removeClass(['is-valid', 'is-invalid']);
                    password_1.addClass('is-invalid');
                } else if (!regexUpperCaseLetter.test(password_1Value)){
                    $('#invalid_feedback_password1').text('Should contain at least one Upper Case Letter!');
                    password_1.removeClass(['is-valid', 'is-invalid']);
                    password_1.addClass('is-invalid');
                } else if (!regexLowerCaseLetter.test(password_1Value)){
                    $('#invalid_feedback_password1').text('Should contain at least one Lower Case Letter!');
                    password_1.removeClass(['is-valid', 'is-invalid']);
                    password_1.addClass('is-invalid');
                } else if (!regexSpecialCharacters.test(password_1Value)){
                    $('#invalid_feedback_password1').text('Should contain at least one Special Character');
                    password_1.removeClass(['is-valid', 'is-invalid']);
                    password_1.addClass('is-invalid');
                } else {
                    password_1.removeClass(['is-valid', 'is-invalid']);
                    password_1.addClass('is-valid');
                }


                if (password_1Value != password_2Value){
                    password_2.removeClass(['is-valid', 'is-invalid']);
                    password_2.addClass('is-invalid');
                } else {
                    password_2.removeClass(['is-valid', 'is-invalid']);
                    password_2.addClass('is-valid');
                }


                phoneRegex = /^\d{10}$/;
                if (!phoneRegex.test(phoneValue)){
                    phone.removeClass(['is-valid', 'is-invalid']);
                    phone.addClass('is-invalid');
                } else {
                    phone.removeClass(['is-valid', 'is-invalid']);
                    phone.addClass('is-valid');
                }

                if (genderValue == 0){
                    gender.removeClass(['is-valid', 'is-invalid']);
                    gender.addClass('is-invalid');
                } else {
                    gender.removeClass(['is-valid', 'is-invalid']);
                    gender.addClass('is-valid');
                }

                currDate = new Date();
                dobDate = new Date(dobValue);
                if (dobDate >= currDate){
                    dob.removeClass(['is-valid', 'is-invalid']);
                    dob.addClass('is-invalid');
                } else {
                    dob.removeClass(['is-valid', 'is-invalid']);
                    dob.addClass('is-valid');
                }

                if (picValue.length <= 0){
                    profile_pic.removeClass(['is-valid', 'is-invalid']);
                    profile_pic.addClass('is-invalid');
                } else {
                    profile_pic.removeClass(['is-valid', 'is-invalid']);
                    profile_pic.addClass('is-valid');
                }


                return true;

                
        }       

        $(document).ready(function(){
            $("#createUserForm").submit(function(e){
                
                e.preventDefault();
                $('input').on('keyup', validateForm);
                $('#input_gender').on('change', validateForm);
                
                

            });



            
        });

        

    </script>
</body>

</html>