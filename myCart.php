<?php
session_start();
require_once "Utilities/helpers.php";
loginRequired();

if (isset($_SESSION['user_id'])) {
    $query = "SELECT * FROM `User` WHERE id=:id";
    $params = array(
        ":id" => $_SESSION['user_id']
    );

    $result = executeQueryResult($pdo, $query, $params)[0];
    $profile_url = $result['profile_image_url'];
}

    $query = "SELECT p.id, p.name, p.price, p.category_id, p.image_url, c.user_id FROM cart as c JOIN product as p ON c.product_id = p.id WHERE c.user_id = :id";
    $params = array(
        ":id" => $_SESSION['user_id']
    );

    $result = executeQueryResult($pdo, $query, $params);
    // var_dump($result);


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


    <title>Shop</title>
</head>

<body>
    <?php require_once "Views/navbar.php" ?>


    <div class="mensContainerCart d-flex flex-row justify-content-between" id="menSection">
        <!-- <div class="arrow1 d-none d-md-flex justify-content-center align-items-center">
            <i class="material-icons">&#xe5cb;</i>
        </div> -->
        <div class="arrowItems h-100 w-100">
            <h1 class="py-5">My Cart</h1>
            <div class="imageListContainer row mx-auto" id="cartItemContainer">
                <?php
                if (count($result) == 0){
                    echo "<span class='text-center ml-3'>No Items in Cart</span>";
                }
                foreach ($result as $product) {
                    require "Views/productTile.php";
                }

                ?>


            </div>
        </div>
        <!-- <div class="arrow3 d-none d-md-flex justify-content-center align-items-center" id="menarrow3">
            <i class="material-icons">&#xe5cc;</i>
        </div> -->
    </div>
    <?php require_once "Views/footer.php";
    importBootstrapJS(); ?>
    <script>
        function checkCartContainerIsEmpty(){
            if ($("#cartItemContainer").children().length == 0){
                $("#cartItemContainer").html("<span class='text-center ml-3'>No Items in Cart</span>");
            }
        }
        $(document).ready(function() {
            $(".cart-button").click(function(e) {
                $element = $(this);
                $id = $element.attr("data-id");
                if ($element.hasClass("added")) {
                    $.ajax({
                        url: "toCart.php",
                        method: "POST",
                        data: {
                            action: "remove",
                            product_id: $id
                        },
                        success: function(response) {
                            // if (response == "success") {
                                $element.removeClass("added");
                                $element.html("&#xe854;");
                                // remove element from DOM 
                                $element.parent().parent().remove();
                                checkCartContainerIsEmpty()
                                console.log(response);
                            // }
                        }
                    });
                } else {
                    $.ajax({
                        url: "toCart.php",
                        method: "POST",
                        data: {
                            action: "add",
                            product_id: $id
                        },
                        success: function(response) {
                            // if (response == "success") {
                                $element.addClass("added");
                                $element.html("&#xe928;");
                                console.log(response);
                            // }
                        }
                    });
                }

            });
        });
    </script>

</body>

</html>