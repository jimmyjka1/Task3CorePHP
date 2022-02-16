<?php 
    session_start();
    require_once "Utilities/helpers.php";
    loginRequired();

    if (isset($_POST['action'])){
        if ($_POST['action'] == 'add'){
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];
            
            // query
            $query = "INSERT INTO cart (user_id, product_id) VALUES (:user, :product)";
            $params = array(':user' => $user_id, ':product' => $product_id);
            $result = executeQuery($pdo, $query, $params);
            if ($result){
                echo "Success";
            } else {
                echo "Error";
            }
        } else if ($_POST['action'] == 'remove'){
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];

            // query
            $query = "DELETE FROM cart WHERE user_id = :user AND product_id = :product";
            $params = array(':user' => $user_id, ':product' => $product_id);
            $result = executeQuery($pdo, $query, $params);
            if ($result){
                echo "Success";
            } else {
                echo "Error";
            }
        }
    }





?>