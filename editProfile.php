<?php
session_start();
require_once "Utilities/helpers.php";
loginRequired();

function setError($message)
{
    $_SESSION['error'] = $message;
    header("Location: editProfile.php");
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
    if ($_POST['submit'] == 'profile_change') {
        if (isset($_FILES['profile_image']['name'])) {

            if ($_FILES['profile_image']['size'] > 1048576) {
                setError('Profile Image Size should be lesss than 1 MB');
            }
            $target_dir = "profile_image/" . date("YmdHis") . rand();
            $target_file = $target_dir . basename($_FILES['profile_image']['name']);
            $check = getimagesize($_FILES['profile_image']['tmp_name']);

            if ($check !== false) {
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {

                    // deleting old image file 
                    unlink($profile_url);


                    $query = "UPDATE `User` set profile_image_url=:url WHERE id=:id";
                    $params = array(
                        ':url' => $target_file,
                        ':id' => $_SESSION['user_id']
                    );
                    if (executeQuery($pdo, $query, $params)) {
                        $_SESSION['success'] = "Profile Image Update Successfully";
                        header("Location: editProfile.php");
                        die();
                    } else {
                        setError("Error in updating profile image");
                    }
                } else {
                    setError('Error in Uploading your file');
                }
            } else {
                setError('File Uploaded is not an image');
            }
        }
    } else if ($_POST['submit'] == 'update_details') {
        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['gender']) && isset($_POST['dob']) && (strlen($_POST['first_name']) > 0) && (strlen($_POST['last_name']) > 0) && (strlen($_POST['email']) > 0) && (strlen($_POST['phone']) > 0) && (strlen($_POST['gender']) > 0) && (strlen($_POST['dob']) > 0)) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];

            // sanitizing inputs 
            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $email = htmlspecialchars(strip_tags($email));
            $phone = htmlspecialchars(strip_tags($phone));
            $gender = htmlspecialchars(strip_tags($gender));
            $dob = htmlspecialchars(strip_tags($dob));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                setError('Invalid Email');
            }

            if (strlen($phone) < 10) {
                setError('Invalid Phone Number');
            }

            if (!in_array($gender, array('1', '2'))) {
                setError('Invalid Gender Value');
            }


            $query = "UPDATE `User` SET email=:em, fname=:fname, lname=:lname, phone=:phone, gender=:gen, date_of_birth=:dob WHERE id=:id";
            $params = array(
                ':em' => $email,
                ':fname' => $first_name,
                ':lname' => $last_name,
                ':phone' => $phone,
                ':gen' => $gender,
                ':dob' => $dob,
                ':id' => $_SESSION['user_id']
            );

            try {
                $res = executeQuery($pdo, $query, $params);
            } catch (Exception $e) {
                // var_dump($e);
                if ($e->errorInfo[0] == '23000') {
                    setError('Email ID already present');
                }
            }

            if ($res) {
                $_SESSION['fname'] = $first_name;
                $_SESSION['lname'] = $last_name;
                $_SESSION['email'] = $email;

                $_SESSION['success'] = "Profile Updated Successfully";
                header("Location: editProfile.php");
                die();
            } else {
                setError("Unable to update profile");
            }
        } else {
            setError('All fields are required!');
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
    <link rel="stylesheet" href="Styles/indexStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
    <?php importBootstrapCSS(); ?>


    <title>Edit Profile - <?php echo $title ?></title>
</head>

<body>
    <?php require_once "Views/navbar.php" ?>


    <div class="editProfileContainer row p-5 w-100">
        <div class="col-12 col-lg-4 d-flex justify-content-start align-items-center flex-column">
            <h1 class="mb-5">Edit Profile</h1>
            <img src="<?php echo $profile_url ?>" alt="" id="editProfileImage">
            <form class="my-3 d-flex justify-content-center align-items-center flex-column" action="editProfile.php" method="POST" id="changeProfileImageForm" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="profile_image" id="input_file" class="form-control-file">
                </div>
                <button class="btn btn-secondary" type="submit" name="submit" value="profile_change">Change</button>
            </form>
        </div>
        <div class="col-12 col-md-8">
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
            <div class="formContainer mb-5">
                <form action="editProfile.php" method="post" id="editUserForm">
                    <div class="form-group">
                        <label for="input_first_name">
                            First Name
                        </label>
                        <input type="text" class="form-control" name="first_name" id="input_first_name" value="<?php echo $result['fname'] ?>">

                    </div>
                    <div class="form-group">
                        <label for="input_last_name">
                            Last Name
                        </label>
                        <input type="text" class="form-control" name="last_name" id="input_last_name" value="<?php echo $result['lname'] ?>">

                    </div>
                    <div class="form-group">
                        <label for="input_email">
                            Email
                        </label>
                        <input type="email" class="form-control" name="email" id="input_email" value="<?php echo $result['email'] ?>">

                    </div>
                    <div class="form-group">
                        <label for="input_phone">
                            Enter Phone Number
                        </label>
                        <input type="tel" name="phone" id="input_phone" class="form-control" value="<?php echo $result['phone'] ?>">

                    </div>

                    <div class="form-group">
                        <label for="input_gender">
                            Select Gender
                        </label>
                        <select name="gender" id="input_gender" class="custom-select">
                            <option value="">Select Gender</option>
                            <option value="1" <?php if ($result['gender'] == 1) {
                                                    echo 'selected';
                                                } ?>>Female</option>
                            <option value="2" <?php if ($result['gender'] == 2) {
                                                    echo 'selected';
                                                } ?>>Male</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="input_dob">
                            Date Of Birth
                        </label>
                        <input type="date" name="dob" id="input_dob" class="form-control" value="<?php echo $result['date_of_birth']; ?>" max="<?php echo date('Y-m-d'); ?>">

                    </div>

                    <div class="submitButtonContainer d-flex justify-content-center align-items-center">
                        <button type="submit" name="submit" class="btn btn-primary" value="update_details">Submit</button>
                    </div>


                </form>
            </div>
        </div>
    </div>



    <?php require_once "Views/footer.php";
    importBootstrapJS(); ?>
    <script>
        jQuery.validator.addMethod('validateDate', function(value, element, params) {
            dt = new Date(value);
            current_dt = new Date();
            if (dt > current_dt) {
                return false;
            } else {
                return true;
            }
        });
        $(document).ready(function() {

            $('#changeProfileImageForm').validate({
                rules: {
                    profile_image: {
                        required: true,
                        accept: "image/*"
                    }
                },
                messages: {
                    profile_image: {
                        required: "Please Upload Profile Image",
                        accept: "Please Select an Image File"
                    }
                }
            });


            $('#editUserForm').validate({
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

                }
            });
        });
    </script>
</body>

</html>