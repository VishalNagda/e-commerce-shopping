<?php
require('top.inc.php');
$msg='';
$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc	 = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';

$image_requried='required';

if(isset($_GET['id']) && $_GET['id']!=''){
   $image_requried='';
   $id = get_safe_value($con,$_GET['id']);
   $res= mysqli_query($con,"select * from product where id='$id'");
   $check = mysqli_num_rows($res);
   if($check>0){
   $row= mysqli_fetch_assoc($res);
   $categories_id = $row['categories_id'];
   $name = $row['name'];
   $mrp = $row['mrp'];
   $price = $row['price'];
   $qty = $row['qty'];
   $image = $row['image'];
   $short_desc = $row['short_desc'];
   $description = $row['description'];
   $meta_title = $row['meta_title'];
   $meta_desc = $row['meta_desc'];
   $meta_keyword = $row['meta_keyword'];
   }else{
       header('location:product.php');
       die();
   }
}

if(isset($_POST['submit'])){
    $categories_id = get_safe_value($con,$_POST['categories_id']);
    $name = get_safe_value($con,$_POST['name']);
    $mrp = get_safe_value($con,$_POST['mrp']);
    $price = get_safe_value($con,$_POST['price']);
    $qty = get_safe_value($con,$_POST['qty']);
    $image = get_safe_value($con,$_POST['image']);
    $short_desc = get_safe_value($con,$_POST['short_desc']);
    $description = get_safe_value($con,$_POST['description']);
    $meta_title = get_safe_value($con,$_POST['meta_title']);
    $meta_desc = get_safe_value($con,$_POST['meta_desc']);
    $meta_keyword = get_safe_value($con,$_POST['meta_keyword']);
   
    $res= mysqli_query($con,"select * from product where name='$name'");
    $check = mysqli_num_rows($res);
    if($check>0){
      $msg = "Product Already Exits";

    }else{
      $image = rand(1111111,9999999).'_'.$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);

mysqli_query($con,"INSERT INTO product(categories_id,name,mrp,price,qty,image,short_desc,description,meta_title,meta_desc,meta_keyword,status) values('$categories_id','$name','$mrp','$price','$qty','$image','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword','1')");
   header('location:product.php');
   die();
    }

}


?>
  <div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong></div>
                        <a href="product.php">Back</a>
                       <form  method='post' enctype="multipart/form-data">
                       <div class="card-body card-block">
                           <div class="form-group"><label for="Category" class=" form-control-label">Category</label>
                           <select name="categories_id" class='form-control'>
                              <?php
                              $res=mysqli_query($con,"select id,categories from categories order by categories asc");

                              while($row=mysqli_fetch_assoc($res)){
                                 echo "<option value=".$row['id'].">".$row['categories']."</option>";

                              }
                              ?>
                           </select>

                       <div class="form-group"><label for="Category" class=" form-control-label">Product Name</label>
                           <input type="text" id="company" value='<?php echo $name ?>' name='name' placeholder="Enter Product name" class="form-control" required>
                        </div>
                        
                       <div class="form-group"><label for="Category" class=" form-control-label">MRP</label>
                           <input type="text" id="company" value='<?php echo $mrp ?>' name='mrp' placeholder="Enter MRP" class="form-control" required>
                        </div>

                       <div class="form-group"><label for="Category" class=" form-control-label">Product Price</label>
                           <input type="text" id="company" value='<?php echo $price ?>' name='price' placeholder="Enter Product price" class="form-control" required>
                        </div>

                       <div class="form-group"><label for="Category" class=" form-control-label">Product Qty</label>
                           <input type="text" id="company" value='<?php echo $qty ?>' name='qty' placeholder="Enter Product Qty" class="form-control" required>
                        </div>

                       <div class="form-group"><label for="Category" 
                       
                       class=" form-control-label">Product Image</label>
                           <input type="file" id="company" name='image' class="form-control" <?php echo $image_requried ?> >
                        </div>
                       

                       

                       <div class="form-group"><label for="Category" class=" form-control-label">Short Desc</label>
                           <textarea type="text" id="company"name='short_desc' placeholder="Enter Product Short desc" class="form-control" required><?php echo $short_desc ?></textarea>

                        </div>

                       <div class="form-group"><label for="Category" class=" form-control-label">Description</label>
                           <textarea type="text" id="company"name='description' placeholder="Enter Product Description" class="form-control" required><?php echo $description ?></textarea>

                        </div>

                       <div class="form-group"><label for="Category" class=" form-control-label">Meta Title</label>
                           <textarea type="text" id="company"name='meta_title' placeholder="Enter Product meta title" class="form-control" required><?php echo $meta_title ?></textarea>

                        </div>
                       <div class="form-group"><label for="Category" class=" form-control-label">Meta Description</label>
                           <textarea type="text" id="company"name='meta_desc' placeholder="Enter Product Meta Description" class="form-control" ><?php echo $meta_desc ?></textarea>

                        </div>
                       <div class="form-group"><label for="Category" class=" form-control-label">Meta Keyword</label>
                           <textarea type="text" id="company"name='meta_keyword' placeholder="Enter Product Meta keyword" class="form-control" ><?php echo $meta_keyword ?></textarea>

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