<?php 
    require_once "Database_config/config.php";
    $title = "HexaShop";
    $useHashedPassword = true;
    

    function executeQuery($pdo, $query, $params){

        $stmt = $pdo -> prepare($query);
        $rs = $stmt -> execute($params);
        return $rs;

    }

    function executeQueryResult($pdo, $query, $params){

        $stmt = $pdo -> prepare($query);
        $rs = $stmt -> execute($params);
        if ($rs){
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }

    }

    function hashPassword($password){
        global $salt, $useHashedPassword;
        if ($useHashedPassword){
            return hash('sha256', $salt.$password);
        } else {
            return $password;
        }
    }



    function importBootstrapJS(){
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>';
    }

    function importBootstrapCSS(){
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">';
    }

    function setFont(){
        echo '<style>
        @import url(\'https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;600;700;800;900&display=swap\');

        body {
            font-family: \'Outfit\', sans-serif;
        }
        </style>';
    }


    function loginRequired(){
        if (!isset($_SESSION['user_id'])){
            header("Location: login.php");
            die();
        }
    }
