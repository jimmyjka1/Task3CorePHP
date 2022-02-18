<?php
session_start();
require_once "Utilities/helpers.php";
$CURRENT_PAGE = "kids";

$category_id = 3;

// code to get profile image url 
if (isset($_GET['filter_set'])) {

    $condition = "";
    $params = array();

    

    if (isset($_SESSION['user_id'])) {

        if (isset($_GET['search'])) {
            $condition .= " (p.description LIKE :search OR p.name LIKE :search )";
            $params[':search'] = "%".$_GET['search']."%";
        }
    
        if (isset($_GET['min_price']) && strlen($_GET['min_price']) > 0) {
            $condition .= " AND p.price >= :min ";
            $params[':min'] = $_GET['min_price'];
        }
    
        if (isset($_GET['max_price']) && strlen($_GET['max_price']) > 0) {
            $condition .= " AND p.price <= :max ";
            $params[':max'] = $_GET['max_price'];
        }

        $query = "SELECT profile_image_url FROM `User` WHERE id=:id";
        $params1 = array(
            ":id" => $_SESSION['user_id']
        );

        $result = executeQueryResult($pdo, $query, $params1);
        $profile_url = $result[0]['profile_image_url'];

        $query = "SELECT p.id, p.name, p.price, p.category_id, p.image_url, p.quantity, c.user_id FROM Product as p LEFT JOIN Cart as c ON (c.product_id = p.id AND (c.user_id = :id OR c.user_id IS NULL)) WHERE p.category_id = $category_id AND $condition ORDER BY p.id DESC; ";
        $params[':id'] = $_SESSION['user_id'];


    } else {

        if (isset($_GET['search'])) {
            $condition .= " (description LIKE :search OR name LIKE :search )";
            $params[':search'] = "%".$_GET['search']."%";
        }
    
        if (isset($_GET['min_price']) && strlen($_GET['min_price']) > 0) {
            $condition .= " AND price >= :min ";
            $params[':min'] = $_GET['min_price'];
        }
    
        if (isset($_GET['max_price']) && strlen($_GET['max_price']) > 0) {
            $condition .= " AND price <= :max ";
            $params[':max'] = $_GET['max_price'];
        }


        $query = "SELECT * FROM Product WHERE category_id = $category_id AND $condition ORDER BY id DESC";
        // var_dump($query, $params);
        // die();

    }
} else if (isset($_SESSION['user_id'])) {
    $query = "SELECT profile_image_url FROM `User` WHERE id=:id";
    $params = array(
        ":id" => $_SESSION['user_id']
    );

    $result = executeQueryResult($pdo, $query, $params);
    $profile_url = $result[0]['profile_image_url'];


    $query = "SELECT p.id, p.name, p.price, p.category_id, p.image_url, p.quantity, c.user_id FROM Product as p LEFT JOIN Cart as c ON (c.product_id = p.id AND (c.user_id = :id OR c.user_id IS NULL)) WHERE p.category_id = $category_id ORDER BY p.id DESC; ";
    $params = array(
        ":id" => $_SESSION['user_id']
    );
} else {
    $query = "SELECT * FROM Product WHERE category_id = $category_id ORDER BY id DESC;";
    $params = array();
}






$kids_products = executeQueryResult($pdo, $query, $params);


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


    <title>Kids - <?php echo $title ?></title>
</head>

<body>

    <body>
        <?php require_once "Views/navbar.php" ?>
        <div class="mensContainerCart d-flex flex-row justify-content-between" id="menSection">
            <div class="arrowItems h-100 w-100">
                <form action="" method="GET" id="filterForm">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" name="search" placeholder="Search Text" value="<?php if (isset($_GET['search'])) {
                                                                                                                        echo $_GET['search'];
                                                                                                                    } ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="filter_set" value="filter_set">Search</button>
                            <button type="button" class="btn btn-outline-secondary" data-toggle="collapse" data-target="#filterContainerId">
                            <i class='fas'>&#xf0b0;</i>
                            </button>
                        </div>
                    </div>
                    <div class="filterContainer border border-secondary p-3 collapse" id="filterContainerId">
                        <div class="form-group">
                            <label>Price Range:</label>
                            <div class="row m-0">
                                <input type="number" name="min_price" id="input_min_price" placeholder="Min" class="form-control col-6" value="<?php if (isset($_GET['min_price'])) {
                                                                                                                                                    echo $_GET['min_price'];
                                                                                                                                                } ?>">
                                <input type="number" name="max_price" id="input_max_price" placeholder="Max" class="form-control col-6" value="<?php if (isset($_GET['max_price'])) {
                                                                                                                                                    echo $_GET['max_price'];
                                                                                                                                                } ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-secondary" name="filter_set" value="filter_set">Filter</button>
                            <button class="btn btn-info" type="button" id="filterResetButton">Reset</button>
                        </div>
                    </div>
                </form>
                <h1 class="py-3">Kids's Latest</h1>

                <div class="imageListContainer row mx-auto">
                    <?php
                    foreach ($kids_products as $product) {
                        require "Views/productTile.php";
                    }
                    if (count($kids_products) <= 0){
                        echo "<div class='d-flex justify-content-center align-items-center flex-column w-100'><h4 class='color-grey text-uppercase'>NO RESULTS FOUND</h4><img src='images/noResult.gif' class='w-50 h-100 d-block' id=></div>";
                    }

                    ?>


                </div>
            </div>
        </div>
        <?php require_once "Views/footer.php";
        importBootstrapJS(); ?>

        <script>
            

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
                    updateCartCount();

                });



                $("#filterResetButton").click(function(e){
                    $("#input_max_price").val("");
                    $("#input_min_price").val("");
                });
            });
        </script>

    </body>

</html>