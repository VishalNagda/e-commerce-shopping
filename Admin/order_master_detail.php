<?php
require('top.inc.php');

$order_id = get_safe_value($con,$_GET['id']);

if(isset($_POST['update_order_status'])){
   $update_status=$_POST['update_order_status'];
   mysqli_query($con,"update order_list set order_status='$update_status' where id='$order_id' ");
}


?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h2 class="box-title">Order Product Detail</h2>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                           <table class='table'>
                                        <thead>
                                            <tr>
                                                
                                                <th class="product-thumbnail">Product Name</th>
                                                <th class="product-thumbnail">Product Image</th>
                                                <th class="product-name">Qty</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-stock-stauts">Total Price</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $res=mysqli_query($con,"SELECT distinct(order_detail.id),order_detail.* ,product.image,product.name,order_list.address,order_list.city,order_list.pincode  from order_detail,product,order_list where order_detail.order_id='$order_id' and  product.id=order_detail.product_id"); 
                                            $total_price=0;
                                            while($row=mysqli_fetch_assoc($res)){
                                             $address=$row['address'];
                                             $city=$row['city'];
                                             $pincode=$row['pincode'];
                                                $total_price=$total_price+( $row['qty']*$row['price']);
                                               
                                            ?>
                                            <tr>
                                            
                                                <td class="product-name"><?php echo $row['name']?></td>
                                                <td class="product-name"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>" alt="full-image"></td>
                                                <td class="product-name"><?php echo $row['qty'] ?></td>
                                                <td class="product-name"><?php echo $row['price'] ?></td>
                                                <td class="product-name"><?php echo  $row['qty']*$row['price']?></td>
                                               
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="product-name">Total Price</td>
                                                <td class="product-name"><?php echo $total_price ?></td>
                                            </tr>
                                
                                           
                                        </tbody>
                                        
                                    </table>
                                    <div class='address_details'>
                                       <strong>Address</strong>
                                       <?php echo $address ?>
                                    </div>
                                    <div class='address_details'>
                                       <strong>City</strong>
                                       <?php echo $city ?>
                                    </div>
                                    <div class='address_details'>
                                       <strong>Pincode</strong>
                                       <?php echo $pincode ?>
                                    </div>
                                    <div class='address_details'>
                                       <strong>Order Status</strong>
                                       <?php 
                                       $order_status_arr= mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,order_list where order_list.id=$order_id and order_list.order_status=order_status.id"));
                                       echo $order_status_arr['name'];
                                       ?>
                                       <div>
                                          <form method='post'>
                                          <select name="update_order_status" class='form-control'>
                                             <option> Select Status</option>
                                           <?php
                                              $res=mysqli_query($con,"select * from order_status");

                                        while($row=mysqli_fetch_assoc($res)){
                                 echo "<option value=".$row['id'].">".$row['name']."</option>";

                              }
                              ?>
                                                       </select>
                                                       <input type="submit" class='form-control'/>
                                          </form>
                                       </div>
                                    </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		  </div>

      
          <?php
require('footer.php');
?>