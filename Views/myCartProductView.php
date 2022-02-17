<div class="myCartProductItem py-3 px-2">
    <div class="row m-0">
        <div class="cartProductIcon col-lg-3 d-flex justify-content-center align-items-center">
            <input type="checkbox" class="cartProductCheck m-1 d-inline-block stretched-link" data-id="<?php echo $product['cart_id'] ?>" <?php if ($product['quantity'] <= 0){ echo "disabled"; } ?>>
            <img class="mycartProductImage" src="<?php echo $product['image_url'] ?>" alt="Order">
        </div>
        <div class="cartProductDetails col-lg-5 pt-2">
            <b class="d-block"><?php echo $product['name'] ?></b>
            <span class="d-block mt-1">₹ <span id="cartPerProductPrice_<?php echo $product['id'] ?>"><?php echo $product['price'] ?></span></span>
            <?php 
                if ($product['quantity'] <= 0){
                    echo '<span class="d-block mt-2 cartOutOfStockWarning d-flex justify-content-center align-items-center w-75">Out Of Stock</span>';
                } else if ($product['quantity'] <= 10){
                    echo '<span class="d-block mt-2 cartLowQuantityWarning d-flex justify-content-center align-items-center w-75">Hurry! Only '.$product['quantity'].' Left in Stock</span>';
                }
            ?>
            
            <span class="d-block mt-1 smallText color-grey"><?php echo $product['description'] ?></span>
        </div>
        <div class="cartProductQuantity col-lg-2 p-0 d-flex justify-content-center align-items-center flex-column">
            <span class="d-inline d-lg-none pt-3">Quantity:</span>
            <div class="cartProductQuantityInputContainer d-flex justify-content-center-align-items-center">
                <button class="cartQuantityChangeButtons decrement-quantity" <?php if ($product['quantity'] <= 0){ echo "disabled"; } ?> max="<?php echo $product['quantity'] ?>" data-id="<?php echo $product['id'] ?>">-</button>

                <input class="cartProductQuantity" type="text" maxlength="2" value="<?php echo $product['cart_quantity'] ?>" <?php if ($product['quantity'] <= 0){ echo "disabled"; } ?> max="<?php echo $product['quantity'] ?>" id="product_input_<?php echo $product['id'] ?>" data-id="<?php echo $product['id'] ?>" readonly>
                
                <button class="cartQuantityChangeButtons increment-quantity" <?php if ($product['quantity'] <= 0){ echo "disabled"; } ?> data-id="<?php echo $product['id'] ?>">+</button>
            </div>
            <button class="btn btn-danger mt-2 p-1 pt-2 cart-button" data-id="<?php echo $product['id'] ?>"><i class="material-icons">&#xe872;</i></button>

        </div>
        <div class="cartProductTotal col-lg-2 d-flex justify-content-center align-items-center flex-column">
            <b class="mt-3 d-inline d-lg-none">Total Cost:</b>
            <h5><b>₹ <span id="cartTotalProductPrice_<?php echo $product['id'] ?>"><?php echo $product['cart_quantity'] * $product['price'] ?><span></b></h5>
        </div>
    </div>
</div>

