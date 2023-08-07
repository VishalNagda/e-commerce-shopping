<?php
require('connection.php');
require('functioninc.php');

$email = get_safe_value($con,$_POST['email']);
$password = get_safe_value($con,$_POST['password']);
$added_on = date('Y-m-d h:i:s');

$res = mysqli_query($con,"SELECT * FROM user where email='$email' and password='$password' ");
$check_user =mysqli_num_rows($res);
if($check_user>0){
    $row=mysqli_fetch_assoc($res);
    $_SESSION['USER_LOGIN']='yes';
    $_SESSION['USER_ID']=$row['id'];
    $_SESSION['USER_NAME']=$row['name'];
    echo "vaild";
}else{
    echo "wrong";
}


?>