<?php


function Nop_Shopping_Cartss()
{

require('../../../wp-load.php');
global $wpdb;

	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
	$cart_box = "";
$cart_box .= "<div id='spcrt'>
	<style>
	.img_class li {
    list-style: none;
}
li.img_class {
    width: 190px!important;
    list-style: none;
    display: inline-block;
    line-height: 29px;
}
.img_class {
    border: 0px solid;
    max-height: 161px;
    width: 104%;
    list-style: none;
}
ul.prod_details {
    float: right;
    display: block;
    width: 100px;
}
	</style>
	
	";
	    // getting the api url from the database
		$api_config=api_config();
		$response_url=json_decode($api_config);
		$api_url=$response_url[0]->api_url;	
	
		//GET /api/shopping_cart_items
		
		 $nopmeid =$_COOKIE['nopmeid'];
$cooguid = $_COOKIE['Nop_customer'];

		 $url = $api_url."/api/shopping_cart_items/".$nopmeid;


         $cart_response=getdata($url);		 
		
        // $cart_body=wp_remote_retrieve_body($cart_response);
         $cart_items=json_decode($cart_response);
		 
		 $count_cart_items=count($cart_items->shopping_carts);
		 $cart_details=$cart_items->shopping_carts;         
		
		 $total=0;
		 
		 if($nopmeid =="")
		 {
			 $count_cart_items="0";
		 }
        $cart_box .=  '<input type="button" class="shopping_Cart_menu" value="Shopping Cart('.$count_cart_items.')"><div id="cart_pop" style="display:none;"><div style="width:263px;height:auto;margin-bottom:10px;border:1px solid #ccc;padding:2px;">';		 
if($nopmeid!="")
			 {		
		for($i=0;$i<$count_cart_items;$i++)
		 {		
	 
	 			
	       		        $atmain = $cart_details[$i]->product_attributes;
				$varProductAtrr = "";
				$varSubTotalExtra = 0;
				foreach($atmain as $mmatlist)
				{
				 	$atsid = $mmatlist->id;
					//print_r($mmatlist);
					 $atsval = $mmatlist->value;
					// change the utc time to system date 
					$time = strtotime($cart_details[$i]->customer->created_on_utc);
					$dateInLocal = date("Y-m-d", $time);
					$sysdate=date("Y-m-d");
					$atrlist = $cart_details[$i]->product->attributes;
					//var_dump(); 
					$arrAtrValues = $atrlist[$mmatlist->id-1]->attribute_values;
					$objAttrData = false;
					foreach($arrAtrValues as $key=>$value){
						if($value->id == $atsval){
							$objAttrData = $value;
						}
					}
					//var_dump($objAttrData);
					$varSubTotalExtra = $varSubTotalExtra + $objAttrData->price_adjustment;
					$varPriceAdj = (!empty($objAttrData->price_adjustment)) ? "[+$".number_format($objAttrData->price_adjustment,2)."]" : "";
					$varProductAtrr.= $atrlist[$mmatlist->id-1]->product_attribute_name.": ".$objAttrData->name.$varPriceAdj."<br/>";
			       }
			
                         $total = $total + ($cart_details[$i]->product->price * $cart_details[$i]->quantity) + $varSubTotalExtra; 	        
			 $product_attr=$cart_details[$i]->product_attributes;
			 $count_attr=count($product_attr);		
		 
			$cart_box .=  '<div style="float:left;"><img style="float: left;width: 65px;" src="'.$cart_details[$i]->product->images[0]->src.'">';
			$cart_box .= '<a href="javascript:void()" style="clear: both; display: block; width: 65px; background: #333; text-align: center; color: #fff; font-size: 14px" class="delitem" delid="'.$cart_details[$i]->id.'">delete</a></div>';	
			 
			$cart_box .=  '<div style="float:left;width:180px; padding-left:12px"><h1 style="margin: 0px; font-size: 16px; line-height: 30px;">'.$cart_details[$i]->product->name.'</h1>
			 <p class="prod" style="margin-top:10px;">';
			 $cart_box .=$varProductAtrr;
			
			 $cart_box .=  'Unit Price : $'.number_format($cart_details[$i]->product->price+$varSubTotalExtra,2).'</br>';			
			$cart_box .=  'Quantity : '.$cart_details[$i]->quantity.'</p> </div>';	
			 			 
           			 
		}
			 } 
		
		 if($count_cart_items == '0')
		 {
			
			 $cart_box .=  "<p>You have no items in your shopping cart.</p>";
		
         $cart_box .=  '</div>';
	     }
	if($count_cart_items != '0')
	{
		 $cart_box .=  '<div style="clear:both;">Sub-Total :<b>$'.$total.'</b></div>'; 
		 
		$cst_link  = $api_url.'/cart?q='.$cooguid;
		 $cart_box .=  "<a style='background: #3399ff; width: 100%; clear: both; display: block; padding-left: 10px; height: 30px;text-align: center; line-height: 30px; color: #fff;' href='{$cst_link}' type='button' class='button btn btn-primary' id='checkout'>Checkout</a>"	;
	}
		 
		$cart_box .=  '</div></div>'; 
	return $cart_box;
}



print_r(Nop_Shopping_Cartss());
?>