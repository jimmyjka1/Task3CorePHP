<?php

    echo '<div class="imageListItem col-12 col-md-6 col-lg-4 pt-3">
    <img class="" src="' . $product['image_url'] . '" alt="mens1">
    <p class="m-0 mb-lg-2 d-lg-inline-block mt-lg-2">' . $product['name'] . '</p>
    <i
    class="material-icons stars m-0 float-lg-right mt-lg-2">&#xe838;&#xe838;&#xe838;&#xe838;&#xe838;</i><br>
    <div class="cartContainer d-flex justify-content-between align-items-center">
    <span class="color-grey price m-0">₹' . $product['price'] . '</span>';
    if ($product['quantity'] <= 0){
        echo '<span class="badge badge-danger">Out Of Stock</span>';
    } else if ($product['quantity'] <= 10){
        echo '<span class="badge border border-danger text-danger">Only '.$product['quantity'].' items left!!</span>';
    }
    if (isset($profile_url)){
        // check if $product['user_id'] is null or not 
        // var_dump($product);
        if ($product['user_id'] == null){
            echo '<i class="material-icons mx-1 cart-button noselect" data-id="'.$product['id'].'" id="product'.$product['id'].'">&#xe854;</i>';    
        } else {
            echo '<i class="material-icons mx-1 cart-button noselect added" data-id="'.$product['id'].'" id="product'.$product['id'].'">&#xe928;</i>';
        }
        
    } 
    echo '</div>
    </div>';

?>