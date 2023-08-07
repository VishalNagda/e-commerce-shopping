function sort_product_drop(cat_id,site_path){
    var sort_product_id=jQuery('#sort_product_id').val();
    window.location.href=site_path+"categories.php?id="+cat_id+"&sort="+sort_product_id
}