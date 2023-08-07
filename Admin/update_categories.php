<?php
require('top.inc.php');
$categories = '';
$msg = '';
if(isset($_GET['id']) && $_GET['id']!=''){
    $id = get_safe_value($con,$_GET['id']);
    $res= mysqli_query($con,"select * from categories where id='$id'");
    $check = mysqli_num_rows($res);
    if($check>0){
    $row= mysqli_fetch_assoc($res);
    $categories = $row['categories'];
    }else{
        header('location:categories.php');
        die();
    }
}


if(isset($_POST['submit'])){
    $categories = get_safe_value($con,$_POST['categories']);
   $res= mysqli_query($con,"select * from categories where categories='$categories'");
    $check = mysqli_num_rows($res);
    if($check>0){
      $msg = "Categories Already Exits";

    }else{

    
    if(isset($_GET['id']) && $_GET['id']!=''){

        mysqli_query($con,"update categories set categories='$categories' where id='$id'");
    }
  
   }

}

?>
  <div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Add Categories</strong><small> Form</small></div>
                       <form  method='post'>
                       <div class="card-body card-block">
                           <div class="form-group"><label for="Category" class=" form-control-label">Category</label>
                           <input type="text" id="company" value='<?php echo $categories ?>' name='categories' placeholder="Enter Category name" class="form-control" required>
                        </div>
                           <button id="payment-button" name='submit' type="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                           <div><?php echo $msg ?></div>
                        </div>
                       </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>

   
 <?php
require('footer.php');
?>