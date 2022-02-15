<?php
session_start();
require_once "Utilities/helpers.php";
loginRequired();

// code to get profile image url 
if (isset($_SESSION['user_id'])) {
    $query = "SELECT profile_image_url FROM `User` WHERE id=:id";
    $params = array(
        ":id" => $_SESSION['user_id']
    );

    $result = executeQueryResult($pdo, $query, $params);
    $profile_url = $result[0]['profile_image_url'];
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
    

    <div class="editProfileContainer d-flex justify-content-center align-items-center flex-column">
        <h1>Edit Profile</h1>
        <img src="<?php echo $profile_url ?>" alt="" id="editProfileImage">
        <form class="my-3 d-flex justify-content-center align-items-center"action="" id="changeProfileImageForm" enctype="multipart/form-data">
                <input type="file" name="input_profile_image" id="input_file" class="form-control-file">
                <button class="btn btn-secondary">Change</button>
        </form>
        <div class="formContainer">
            
        </div>
    </div>



    <?php importBootstrapJS(); ?>
</body>

</html>