<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="/assets/js/vendor/jquery.min.js"></script>
    <script src="/assets/js/vendor/popper.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/css/custom/global.css">
    <link rel="stylesheet" href="/assets/css/custom/product_view.css">
    <script>
        $(document).ready(function(){
            $(document).on('click', 'button.qty_change', function(){
                var current_value = $('input#item_qty').attr('value');
                var change = $(this).attr('value');
                var new_value = parseInt(current_value) + parseInt(change);
                if(new_value >= 1){
                    $('input#item_qty').attr('value', new_value);
                    var amount = <?=$item['price']?>;
                    $('span.total_amount').html("₱ " + (new_value * amount).toFixed(2));
                };
            });
            $(document).on('change', 'input#item_qty', function(){
                var quantity = $('input#item_qty').attr('value');
                var amount = $item['price'];
                $('span#total_amount').html(parseInt(quantity) * parseInt(amount));
            });
            $(document).on('click', '#add_to_cart', function(){
                $("<span class='added_to_cart'>Added to cart succesfully!</span>")
                .insertAfter(this)
                .fadeIn()
                .delay(1000)
                .fadeOut(function() {
                    $(this).remove();
                });
                // return false;
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
<?php $this->load->view('partials/header'); ?>
        <aside>
            <a href="/"><img src="/assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
            <!-- <ul>
                <li class="active"><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul> -->
        </aside>
        <section>
            <form action="" method="post" class="search_form">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <a class="show_cart" href="/cart">Cart (<?=$item_count?>)</a>
            <a href="/">Go Back</a>
            <ul>
                <li>
<?php /* need to fix this with jquery so that clicking an image below will blow it up here
and will also be marked active below */ ?>
                    <img src=<?=$images[0]['image']?> alt="food">
                    <ul>
<?php
for($i = 0; $i < count($images); $i++){
?>                      <li <?= ($i == 0) ? 'class="active"' : '' ?>><button class="show_image"><img src=<?=$images[$i]['image']?> alt="food"></button></li>
<?php } ?>          </ul>
                </li>
                <li>
                    <h2><?=$item['name']?></h2>
                    <ul class="rating">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <span>36 Rating</span>
                    <span class="amount">₱ <?=$item['price']?></span>
                    <p><?=$item['description']?></p>
                    <form action="/cart/add_to_cart" method="post" id="add_to_cart_form">
                        <ul>
                            <li>
                                <label>Quantity</label>
                                <input id="item_qty" name="item_qty" type="text" min-value="1" value="1">
                                <ul>
                                    <li><button type="button" class="qty_change" name="qty_increase" value="1" class="increase_decrease_quantity" data-quantity-ctrl="1"></button></li>
                                    <li><button type="button" class="qty_change" name="qty_decrease" value="-1" class="increase_decrease_quantity" data-quantity-ctrl="0"></button></li>
                                </ul>
                            </li>
                            <li>
                                <label>Total Amount</label>
                                <span class="total_amount">₱ <?=$item['price']?></span>
                            </li>
                            <li><button type="submit" id="add_to_cart">Add to Cart</button></li>
                        </ul>
                        <input type="hidden" name="item_id" value="<?=$item['id']?>">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    </form>
                </li>
            </ul>
<?php
if(count($similar_products) > 1){
?>          <section>
                <h3>Similar Items</h3>
                <ul>
<?php
foreach($similar_products as $product){
    if($product['id'] !== $item['id']){
?>                  <li>
                        <a href="/product/<?=$product['id']?>">
                            <img src=<?=$product['image']?> alt="product image">
                            <h3><?=$product['name']?></h3>
                            <ul class="rating">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <span>36 Rating</span>
                            <span class="price">₱ <?=$product['price']?></span>
                        </a>
                    </li>
<?php }
} ?>            </ul>
            </section>
<?php } ?>
        </section>
    </div>
</body>
</html>