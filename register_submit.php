<?php
require('connection.php');
require('functioninc.php');

$name = get_safe_value($con,$_POST['name']);
$email = get_safe_value($con,$_POST['email']);
$mobile = get_safe_value($con,$_POST['mobile']);
$password = get_safe_value($con,$_POST['password']);
$added_on = date('Y-m-d h:i:s');


$check_user =mysqli_num_rows(mysqli_query($con,"SELECT * FROM user where email='$email'"));
if($check_user>0){
    echo "Present";
}else{
    echo "Inserted";
    mysqli_query($con,"insert into user(name,email,mobile,password,added_on) values('$name','$email','$mobile','$password','$added_on')");
}


?>