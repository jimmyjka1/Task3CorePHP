<?php
session_start();
require_once "Utilities/helpers.php";
loginRequired();
$CURRENT_PAGE = "cart";

if (isset($_SESSION['user_id'])) {
    $query = "SELECT * FROM `User` WHERE id=:id";
    $params = array(
        ":id" => $_SESSION['user_id']
    );

    $result = executeQueryResult($pdo, $query, $params)[0];
    $profile_url = $result['profile_image_url'];
}

$query = "SELECT p.id, p.name, p.price, p.quantity, p.category_id, p.image_url, p.description, c.user_id, c.quantity as cart_quantity, c.id as cart_id FROM cart as c JOIN product as p ON c.product_id = p.id WHERE c.user_id = :id ORDER BY c.id DESC";
$params = array(
    ":id" => $_SESSION['user_id']
);

$result = executeQueryResult($pdo, $query, $params);
// var_dump($result);
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


    <title>My Cart - <?php echo $title ?></title>
</head>

<body>
    <?php require_once "Views/navbar.php" ?>


    <div class="mensContainerCart" id="menSection">
        <h1>My Cart</h1>
        <div class="row mt-5 ml-0 mr-0 mb-0 ">
            <div class="cartContainer col-12 col-lg-8" id="cartContainer">
                <div class="cartHeadingContainer row m-0 text-uppercase d-none d-lg-flex">
                    <div class="col-8">
                        <h5>Products</h5>
                    </div>
                    <div class="col-2">
                        <h5>Quantity</h5>
                    </div>
                    <div class="col-2">
                        <h5>Total</h5>
                    </div>
                </div>
                <div class="productsContainer">
                    <?php
                    if (count($result) <= 0) {
                        echo "<h6 class='pt-5 pl-5 text-uppercase'>No Items In Cart</h6>";
                    } else {
                        foreach ($result as $product) {
                            require "Views/myCartProductView.php";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="orderDetailsContainer col-12 col-lg-4">
                <h2 class="py-3">Cart Totals</h2>
                <div id="cartFinalCheckoutTable">
                <span class="color-grey text-uppercase" id="cartNoItemsSelectedCheckout">
                        No Items Selected For Checkout
                    </span>
                </div>
                <button class="mt-3 btn btn-success btn-block disabled" id="checkoutButton">Checkout</button>
            </div>
        </div>
    </div>
    </div>
    <?php require_once "Views/footer.php";
    importBootstrapJS(); ?>
    <script>
        
        function calculateCost() {
            cart_id_list = [];
            all_boxes = $(".cartProductCheck:checked");
            check_box_button = $("#checkoutButton");
            if (all_boxes.length <= 0) {
                console.log("Here too");
                check_box_button.removeClass("disabled");
                check_box_button.addClass("disabled");

                $("#cartNoItemsSelectedCheckout").show();
            } else {
                console.log("going here");
                check_box_button.removeClass("disabled");
            }
            all_boxes.each(function(index, element) {
                cart_id = $(element).attr("data-id")
                cart_id_list.push(cart_id)
            });

            $.ajax({
                url: "toCart.php",
                method: "POST",
                data: {
                    action: "calculate_cost",
                    cart_id: cart_id_list
                },
                success: function(response) {
                    $('#cartFinalCheckoutTable').html(response);
                    if (all_boxes.length <= 0) {
                        $('#cartFinalCheckoutTable').html('<span class="color-grey text-uppercase" id="cartNoItemsSelectedCheckout">No Items Selected For Checkout</span>');
                    }
                }
            })
        }
        $(document).ready(function() {
            $(".cart-button").click(function(e) {
                $element = $(this);
                // console.log("GOING HERE");
                $id = $element.attr("data-id");

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
                        $element.parent().parent().parent().remove();
                        // checkCartContainerIsEmpty()
                        // console.log(response);
                        productsContainer = $(".productsContainer");
                        // console.log();
                        if (productsContainer.children().length <= 0) {
                            productsContainer.html("<h6 class='pt-5 pl-5 text-uppercase'>No Items In Cart</h6>")
                        }
                        calculateCost();
                    }
                });
                updateCartCount();

            });



            $('.increment-quantity').click(function(e) {
                element = $(this);
                id = element.attr('data-id');
                // console.log("Going Here", element);
                input_element = $('#product_input_' + id);
                total_price = $("#cartTotalProductPrice_" + id);
                per_price = $("#cartPerProductPrice_" + id);
                $.ajax({
                    url: "toCart.php",
                    method: "POST",
                    data: {
                        action: "increment_quantity",
                        product_id: id
                    },
                    success: function(response) {
                        input_element.val(response);
                        console.log(response);

                        total_price.text(response * per_price.text());
                        calculateCost();


                    }
                })
            })


            $('.decrement-quantity').click(function(e) {
                element = $(this);
                id = element.attr('data-id');
                // console.log("Going Here", element);
                input_element = $('#product_input_' + id);
                total_price = $("#cartTotalProductPrice_" + id);
                per_price = $("#cartPerProductPrice_" + id);
                $.ajax({
                    url: "toCart.php",
                    method: "POST",
                    data: {
                        action: "decrement_quantity",
                        product_id: id
                    },
                    success: function(response) {
                        input_element.val(response);
                        console.log(response);

                        total_price.text(response * per_price.text());
                        calculateCost();

                    }
                })
            });


            $(".cartProductQuantity").on("input", function(e) {
                element = $(this);
                value = element.val();
                id = element.attr("data-id");
                total_price = $("#cartTotalProductPrice_" + id);
                per_price = $("#cartPerProductPrice_" + id);

                total_price.text(element.val() * per_price.text());
                calculateCost();

            });

            $(".cartProductCheck").change(function(e) {
                calculateCost();
            });




        });
    </script>

</body>

</html>