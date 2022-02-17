<?php
session_start();
require_once "Utilities/helpers.php";
loginRequired();


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];

        // query
        $query = "INSERT INTO cart (user_id, product_id) VALUES (:user, :product)";
        $params = array(':user' => $user_id, ':product' => $product_id);
        $result = executeQuery($pdo, $query, $params);
        if ($result) {
            echo "Success";
        } else {
            echo "Error";
        }
    } else if ($_POST['action'] == 'remove') {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];

        // query
        $query = "DELETE FROM cart WHERE user_id = :user AND product_id = :product";
        $params = array(':user' => $user_id, ':product' => $product_id);
        $result = executeQuery($pdo, $query, $params);
        if ($result) {
            echo "Success";
        } else {
            echo "Error";
        }
    } else if ($_POST['action'] == 'increment_quantity' && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];
        // var_dump($_POST);

        $query = "SELECT quantity FROM Cart WHERE user_id=:id AND product_id = :product";
        $params = array(
            ":id" => $user_id,
            ":product" => $product_id
        );

        $result = executeQueryResult($pdo, $query, $params);
        // var_dump($result);
        if ($result) {
            $quantity = $result[0]['quantity'];

            $query = "SELECT quantity FROM Product WHERE id=:id";
            $params = array(
                ":id" => $product_id
            );
            $result = executeQueryResult($pdo, $query, $params)[0];
            if (!$result || $result['quantity'] <= $quantity){
                echo $quantity;
                die();
            }

            $query = "UPDATE Cart SET quantity=:qtn WHERE user_id=:id AND product_id=:product";
            $params = array(
                ":qtn" => $quantity + 1,
                ":id" => $user_id,
                ":product" => $product_id
            );

            $res = executeQuery($pdo, $query, $params);
            if ($res){
                echo $quantity + 1;
            } else {
                echo "e";
                die();
            }
        } else {
            echo "e";
            die();
        }
    } else if ($_POST['action'] == 'decrement_quantity' && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];
        // var_dump($_POST);

        $query = "SELECT quantity FROM Cart WHERE user_id=:id AND product_id = :product";
        $params = array(
            ":id" => $user_id,
            ":product" => $product_id
        );

        $result = executeQueryResult($pdo, $query, $params);
        // var_dump($result);
        if ($result) {
            $quantity = $result[0]['quantity'];

            if ($quantity <= 1){
                echo $quantity;
                die();
            }

            $query = "UPDATE Cart SET quantity=:qtn WHERE user_id=:id AND product_id=:product";
            $params = array(
                ":qtn" => $quantity - 1,
                ":id" => $user_id,
                ":product" => $product_id
            );

            $res = executeQuery($pdo, $query, $params);
            if ($res){
                echo $quantity - 1;
            } else {
                echo "e";
                die();
            }
        } else {
            echo "e";
            die();
        }
    } else if ($_POST['action'] == 'calculate_cost' && isset($_POST['cart_id'])){
        $cart_item_list = join(", ",$_POST['cart_id']);
        $params = array();
        $query = "SELECT c.id, c.user_id, c.product_id, c.quantity as cart_quantity, p.quantity as p_quantity, p.name, p.price, p.quantity as product_quantity FROM cart as c INNER JOIN product as p ON p.id = c.product_id WHERE c.user_id = 1 AND c.quantity <= p.quantity AND c.id IN ($cart_item_list)";

        
        $total = 0;

        $result = executeQueryResult($pdo, $query, $params);
        echo '<table>
        <tr>
            <th>NAME</th>
            <th>QUANTITY</th>
            <th>PRICE</th>
        </tr>';
        foreach ($result as $row) {
            $total_price = $row['cart_quantity'] * $row['price'];
            $total += $total_price;
            echo '<tr><td>'.$row['name'].'</td><td>'.$row['cart_quantity'].'</td><td style="text-align: right">₹ '.$total_price.'</td></tr>';
        }

        echo '<tr>
            <td></td>
            <td><b>Total: </b></td>
            <td style="text-align: right"><b>₹ '.$total.'</b></td>
        </tr></table>';

        
    }
}
