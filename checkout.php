
<?php require('top.php');

use Razorpay\Api\Api;

if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
    ?>
   <script>
    window.location.href="index.php";
    </script>
   <?php
}
$cart_total=0;
foreach($_SESSION['cart'] as $key=>$val){
$productArr = get_product($con,'','',$key);
$price=$productArr[0]['price'];
$image=$productArr[0]['image'];
$qty=$val['qty'];
$cart_total = $cart_total +($price*$qty);
 }

if(isset($_POST['submit'])){
    // prx($_POST);
   $address = get_safe_value($con,$_POST['address']);
   $city = get_safe_value($con,$_POST['city']);
   $post_code = get_safe_value($con,$_POST['post_code']);
   $payment_type = get_safe_value($con,$_POST['payment_type']);
   $user_id = $_SESSION['USER_ID'];
   $total_price = $cart_total;
   $payment_status='pending';
   if($payment_type=='cod'){
    $payment_status = 'success';
   }
   $order_status=1;
   $added_on = date('Y-m-d h:i:s');
   mysqli_query($con,"INSERT INTO `order_list`(`user_id`, `address`, `city`, `pincode`, `payment_type`, `total_price`, `payment_status`, `order_status`, `added_on`) VALUES ('$user_id','$address','$city','$post_code','$payment_type','$total_price','$payment_status','$order_status','$added_on')");

   $order_id=mysqli_insert_id($con);

   mysqli_query($con,"INSERT INTO `order_detail`(`order_id`, `product_id`, `qty`, `price`) VALUES ('$order_id','$key','$qty','$price') ");

unset($_SESSION['cart']);

if ($payment_type == 'PayU') {
    ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "rzp_test_VETmMN8SAHNCYz",
            "amount": <?php echo $cart_total * 100; ?>,
            "currency": "INR",
            "name": "Vishal Pvt Limited",
            "description": "Test Transaction",
            "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
            "handler": function(response) {
                console.log(response);
                if (response.razorpay_payment_id) {
                    var payment_id = response.razorpay_payment_id;
                    var order_id = response.razorpay_order_id;
                    var signature = response.razorpay_signature;
                    var order_id = '<?php echo $order_id; ?>';
                    var payment_status = 'Success';
                    // Redirect to a PHP file for updating the payment status
                    window.location.href = "update_payment_status.php?order_id=" + order_id + "&payment_id=" + payment_id + "&payment_status=" + payment_status;
                } else {
                    var payment_status = 'Fail';
                    var order_id = '<?php echo $order_id; ?>';
                    // Redirect to a PHP file for updating the payment status
                    window.location.href = "update_payment_status.php?order_id=" + order_id + "&payment_status=" + payment_status;
                }
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    </script>
    <?php
} else {
    $payment_status = 'Success';
    mysqli_query($con, "UPDATE `order_list` SET `payment_status`='$payment_status' WHERE `id`='$order_id'");
    ?>
    <script>
        window.location.href = "thankyou.php";
    </script>
    <?php
}

} 
?>
 <!-- cart-main-area start -->
 <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                   <?php 
                                   $acc_class = 'accordion__title';
                                   if(!isset($_SESSION['USER_LOGIN'])){
                                    $acc_class = 'accordion_hide'
                                    ?>
                                    <div class="accordion__title">
                                        Checkout Method
                                    </div>
                                    <div class="accordion__body">
                                        <div class="accordion__body__form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                    <form id="contact-form"  method="post">
                                                            <h5 class="checkout-method__title">Login</h5>
                                                            <div class="single-input">
                                                                <label for="user-email">Email Address</label>
                                                                <input type="text" name="login_name" id='login_email' placeholder="Your Email*" style="width:100%">

                                                            </div>
                                                            <span class="login_field_error" id='login_email_error'></span>

                                                            <div class="single-input">
                                                                <label for="user-pass">Password</label>
                                                                <input type="password" name="login_password" id='login_password' placeholder="Your Password*" style="width:100%">
                                                            </div>
                                                            <span class="login_field_error" id='login_password_error'></span>

                                                            <p class="require">* Required fields</p>
                                                            <div class="dark-btn">
                                                            <button type="button" onclick="user_login()" class="fv-btn">Login</button>
                                                            </div>
                                                        </form>
                                                        <p id='login_msg' class="form-messege field_error"></p>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                    <form id="contact-form"  method="post">
                                                            <h5 class="checkout-method__title">Register</h5>
                                                            <div class="single-input">
                                                                <label for="user-email">Name</label>
                                                                <input type="text" name="name" id='name' placeholder="Your Name*" style="width:100%">
                                                            </div>
                                                            <span class="field_error" id='name_error'></span>

															<div class="single-input">
                                                                <label for="user-email">Email Address</label>
                                                                <input type="text" name="email" id='email' placeholder="Your Email*" style="width:100%">
                                                            </div>
                                                            <span class="field_error" id='email_error'></span>
															<div class="single-input">
                                                                <label for="user-email">Mobile Number</label>
                                                                <input type="text" name="mobile" id='mobile' placeholder="Your Mobile*" style="width:100%">
                                                            </div>
                                                            <span class="field_error" id='mobile_error'></span>


															
                                                            <div class="single-input">
                                                                <label for="user-pass">Password</label>
                                                                <input type="text" name="password" id='password' placeholder="Your Password*" style="width:100%">
                                                            </div>
                                                            <span class="field_error" id='password_error'></span>

                                                            <div class="dark-btn">
                                                            <button type="button" onclick="user_register()" class="fv-btn">Register</button>
                                                            </div>
                                                            <div class="form-output">
									<p id='register_msg' class="form-messege"></p>
								</div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="<?php echo $acc_class ?>">
                                        Address Information
                                    </div>
                                    <div class="accordion__body">
                                        <form method="post">
                                        <div class="bilinfo">
                                            
                                                <div class="row">
                                                    
                                                    <div class="col-md-12">
                                                        <div class="single-input">
                                                            <input type="text" name='address' placeholder="Street Address" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name='city' placeholder="City/State" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name='post code' placeholder="Post code/ zip" required>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="<?php echo $acc_class ?>">
                                        payment information
                                    </div>
                                    <div class="accordion__body">
                                        <div class="paymentinfo">
                                            <div class="single-method">
                                               COD <input type="radio" name="payment_type" value="COD" required/>&nbsp;&nbsp;
                                               PayU <input type="radio" name="payment_type" value="PayU" required/>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <input type="submit" name="submit" value="submit" id="submitBtn">
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php
                                $cart_total=0;
                                        foreach($_SESSION['cart'] as $key=>$val){
                                            $productArr = get_product($con,'','',$key);
                                            $pname=$productArr[0]['name'];
                                            $price=$productArr[0]['price'];
                                            $mrp=$productArr[0]['mrp'];
                                            $image=$productArr[0]['image'];
                                            $qty=$val['qty'];
                                            $cart_total = $cart_total +($price*$qty);
                                        ?>
                                <div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image ?>">
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $pname ?></a>
                                        <span class="price"><?php echo $price ?></span>
                                    </div>
                                    <div class="single-item__remove">
                                    <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="icon-trash icons"></i></a>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                           
                            <div class="ordre-details__total">
                                <h5>Order total</h5>
                                <span class="price"><?php echo $cart_total ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->


<?php require('footer.php') ?>