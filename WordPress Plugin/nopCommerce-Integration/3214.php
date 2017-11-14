<?php 
error_reporting(0);
	include_once('../../../wp-load.php');
	include_once('api/getdata.php');
	global $wpdb;	
	 $data = parse_url($_SERVER['HTTP_REFERER']);
	$nd = explode("&",$data['query']);

	$q = explode("=", $nd[0]);
	$attl = explode("=", $nd[1]);
	
	$rs=$wpdb->get_results("select role_ids,api_url from ".$wpdb->prefix.'apisettings');
	$myapurl = $rs[0]->api_url;
$data = getdata($myapurl."/api/products");
$haystack = json_decode($data);
$data = (array)$haystack->products;
$matching_letters = $q[1];

foreach($data as $prod){
	$new[] = (array)$prod;
}

foreach($new as $prods){
	$final[] = (array)$prods;
}
?>
<div class="search-results">
<div class="product-grid">
        <div class="item-grid">
<?php

for($i=0;$i<count($final);$i++)
{

 if($final[$i]['visible_individually'] == 1 && $final[$i]['published'] == 1)
 {
if(preg_grep("/{$matching_letters}/i", $final[$i]))
	{
$img=$final[$i]['images'][0]->src;



$cat_response=file_get_contents($myapurl.'/api/products/'.$final[$i]['id']);

		$cat_result=json_decode($cat_response);
$data = (array)$cat_result->products;

foreach($data as $products){
	$newmain[] = (array)$products;
}

foreach($newmain as $prods){
	$catmain[] = (array)$prods;
}


	$cat_name=$catmain[0]['se_name'];

if($attl[1] == $final[$i]['store_ids'][0])
{

?>

		 <div class="item-box">
		  <div class="product-item" data-productid="1">
             <div class="picture">
                       <a class="product_link" href="<?php echo get_site_url().'/product-details/?product='.$final[$i]['se_name'].'&pid='.$final[$i]['id']; ?>" data-id="<?php echo $final[$i]['id']; ?>"><img src="<?php if($img!=""){ echo $img;} else { echo plugin_dir_url( __FILE__ ).'images/default-image_550.png';} ?>"></a><br>

                    </div>
				<div class="details">
				  <h2 class="product-title">  <a class="product_link" href="<?php echo get_site_url().'/product-details/?product='.$final[$i]['se_name'].'&pid='.$final[$i]['id']; ?>" data-id="<?php echo $final[$i]['id']; ?>" style='text-decoration:none;box-shadow:none;'><?php echo $final[$i]['name'] ?></a></h2>
				  <div class="add-info">            
							<div class="prices">
								<span class="price">
								<?php echo "$". $final[$i]['price']; ?></span>
							</div>
							
							<div class="bt-buttons">
									<input type="button" value="Add to cart"  class="addcartproduct" paid="<?php echo $final[$i]['id'] ?>">
							</div>
							
						</div>
				</div>

</div>
</div>

<?php

}


	}
}
}
 //print_r($fl_array);die;
//$array = preg_grep("/{$matching_letters}/i", $final[0]['name']);
//print_r($array);
?>
</div>
</div>
</div>