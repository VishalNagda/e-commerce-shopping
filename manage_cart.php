<?php
require('connection.php');
require('functioninc.php');
require('add_to_cart_inc.php');

$pid = get_safe_value($con,$_POST['pid']);
$qty = get_safe_value($con,$_POST['qty']);
$type = get_safe_value($con,$_POST['type']);


$obj= new add_to_cart();

if($qty<1){

}
else{



if($type=='add'){
    $obj->addProduct($pid,$qty);
}
if($type=='update'){
    $obj->updateProduct($pid,$qty);
}
if($type=='remove'){
    $obj->removeProduct($pid);
}
}

echo $obj->totalProduct();

?>