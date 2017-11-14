	jQuery(document).ready(function(){
		if(jQuery('#wpurl-main').length){
 jQuery("#reg_passmail").hide();
			}
		jQuery('#sh-orders').click( function() {
			
			jQuery(".tab-adrs").hide();
			jQuery(".tab-ord").show();
		});
		jQuery('#sh-adrs').click( function() {
			jQuery(".tab-adrs").show();
			jQuery(".tab-ord").hide();
		});
		
		 var arrname = [];
		  var resval = "";
	
		jQuery("#loader").hide();
	function getCookiebyname(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
		 var chbox_list = [];
		 var selbox_list=[];
		 var rbox_list=[];
		
	
		var custid="";
		var pid="";
		var newurl="";
		var catmain="";
		var b="";
		var xcookie = getCookiebyname('nopmeid');
		
		if(xcookie=="000")
		{
			nopgetid();
		}
		
		var api_url11= myapurl+"/api/shopping_cart_items";
	var pathname = window.location.pathname; // Returns path only
	var url      = window.location.href;
		//newurl=url.split("?");
		//catmain=newurl[1].split("/");
		//b = catmain[0].split("-"); 
	   // var c = b.substr(b.indexOf('-')+1);
		
		jQuery( ".catmain" ).each(function() {
			var tt=$(this);
		var hfr=$(this).attr('href');
		var bnewurl=hfr.split("?");
		var bcatmain=bnewurl[1].split("/");
		var bb = bcatmain[0].split("-"); 

		if(b[0] != bb[0])
		{
			 // alert(bb[0]);
			$(this).attr("style","color:#444!important");
			//alert($(this).text());
			$(tt).parent("li").find("ul").attr("style","display:none!important");
		}
		else{
			//alert("Fsf");
				$(this).attr("style","color:#4ab2f1!important");
			//alert($(this).text());
			$(tt).parent("li").find("ul").attr("style","display:block:none!important");
		}
	  });
	  
	  jQuery(".imgthumbs").click(function()
	  {
		  var tt=$(this).attr("src");
		  $("#mainwimg").attr("src",tt);
	  });
	  
	//start radio
	function rvals()
	  {
		  
		  rbox_list=[];
		  $(".product-essential input[type=radio]:checked").each(function(){
			  
		  var rbox_id = $(this).attr("id");
		  var rbox_val=$(this).attr("data-att-val");
		  
			rbox_list.push({
            id: parseInt(rbox_id),
			value:rbox_val
			 });
});
	  }
	//end radio
	 // start checkbox list get value
	  
	  function cboxvals()
	  {
		  
		  chbox_list=[];
		  $(".product-essential input[type=checkbox]:checked").each(function(){
			  
		  var chk_id = $(this).attr("id");
		  var chk_val=$(this).attr("value");
		  
			chbox_list.push({
            id: parseInt(chk_id),
			value:chk_val
			 });
});
	  }
	// End checkbox list get values
	// start slectbox list get value
	  
	  function selboxvals()
	  {
		  
		  selbox_list=[];
		  $(".product-essential select").each(function(){
			  
		  var sel_id = $(this).attr("id");
		  var sel_val=$(this).find("option:selected").attr("data-att-value");
		  
			selbox_list.push({
            id: parseInt(sel_id),
			value:sel_val
			 });
});
	  }
	// End selectbox list get values
	
	
	  // call for the registration form in the wp admin Section

	jQuery(".register").click(function(){

		var test=$("#role_id").val();
		var role_id = JSON.parse(test);
		var username=$("#username").val(); 
		var pass=$("#password").val();
		var firstname=$("#fname").val();
		var lastname=$("#lname").val();
		var email=$("#email").val();
		var api_url='check_data.php';
		var mainurl=$("#wpurl-main").val();

		if(username =="" || password =="" || email =="")
		{
			
			$(".error_msg_custom").html("Fields marks with * cannot be empty");
			$(".error_msg_custom").show();
			
			return false;
		}
		var vamail = validateEmail(email);
		if(vamail == false)
		{
			
			$(".error_msg_custom").html("Please ener valid email address");
			$(".error_msg_custom").show();
			
			return false;
		}
		
		//var role_id=[3,6];
		//var customer={"customer":{"username":username,"first_name":firstname,"last_name":lastname,"email":email,"password":pass,"role_ids":role_id}};
		//var d=JSON.stringify(customer);
		//console.log(d);	
		//var data=$(".myform").serialize(); 	
		
		$.ajax({
		 type: "GET",
			url : mainurl+'check_data.php',
			dataType: "html",
			data:{ "username": username, "email": email }, 
			success: function(response) 
			{	
			var rsps = $.trim(response);
			
			if(rsps!= 'Create')
			{
				
					
			$(".error_msg_custom").html(response);
			$(".error_msg_custom").show();
			}
			else
			{
		
				
				nopuservalidate();
		
			}
			}
		});
	});

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	function nopuservalidate()
	{
		var test=$("#role_id").val();
		var role_id = JSON.parse(test);
		var username=$("#username").val(); 
		var pass=$("#password").val();
		var firstname=$("#fname").val();
		var lastname=$("#lname").val();
		var email=$("#email").val();
		var api_url= cpurl+"api/getajaxdata.php?url="+myapurl+'/api/customers/search?query=Email:'+email;
		
		//var role_id=[3,6];
		var customer={"customer":{"username":username,
		"first_name":firstname,"last_name":lastname,
		"email":email,"password":pass,"role_ids":role_id}};
		var d=JSON.stringify(customer);
		//console.log(d);	
	//	var data=$(".myform").serialize(); 	
		
	$.getJSON(api_url, function( data ) {

	var cust=data['customers'];
	var obj = {};

		if(typeof cust[0]!='undefined')
		{
	if(cust[0].username==username)
	{
			$(".error_msg_custom").html("User name already exist");
			$(".error_msg_custom").show();
	}
	else if(cust[0].email==email )
	{
			$(".error_msg_custom").html("email already exist");
			$(".error_msg_custom").show();
	}
		}
	else
	{
		insert_wpuser();
		
		//nopuserinsert();
		$(".error_msg_custom").html("User Added Successfully");
			$(".error_msg_custom").show();
	}


	  });
	 

	}

	function nopuserinsert(wpoid)
	{

			var test=$("#role_id").val();
		var role_id = JSON.parse(test);
		var username=$("#username").val(); 
		var pass=$("#password").val();
		var firstname=$("#fname").val();
		var lastname=$("#lname").val();
		var email=$("#email").val();
		var api_url= cpurl+"api/shopping_cart_items.php?url="+myapurl+'/api/customers';
		var mainurl=$("#wpurl-main").val();
		//var role_id=[3,6];
		var customer={"customer":{"username":username,
		"first_name":firstname,"last_name":lastname,
		"email":email,"password":pass,"role_ids":role_id}};
		var d=JSON.stringify(customer);
		
		//console.log(d);	
	var nopeuid="";
		var jdata=JSON.stringify(customer);
		$.ajax({
		 type: "POST",
			url :api_url,
			dataType: "json",
	    	data:{dta:jdata},
			success: function(data){
			var cust=data['customers'];
			
			$.each( cust, function( key, value ) {
				nopeuid=value.id;
			});

			$.ajax({
				 type: "GET",
					url : cpurl+'insertwpusermapping.php',
					dataType: "html",
					data:{"nopeuid": nopeuid, "wpuid": wpoid}, 
					success: function(response) 
					{	
					console.log(response);
			$("#username, #password, #fname, #lname, #email").val("");
					
					}
				});
			}
			});

	}

	function insert_wpuser()
	{

		var username=$("#username").val(); 
		var pass=$("#password").val();
		var firstname=$("#fname").val();
		var lastname=$("#lname").val();
		var email=$("#email").val();
		var mainurl=$("#wpurl-main").val();
		
		$.ajax({
		 type: "GET",
			url : cpurl+'insertwpuser.php',
			dataType: "html",
			data:{ "username": username, "email": email, "firstname": firstname, "lastname": lastname, "password": pass }, 
			success: function(response) 
			{	
			var rsp = response.split("-");
			//alert(rsp[0]);
		nopuserinsert(rsp[0]);
			$(".error_msg_custom").html(rsp[1]);
			$(".error_msg_custom").show();
		
			}
		});
		
	}

	  
	jQuery('body').on('click', '.addcartproduct', function(){
		
	 pid = $(this).attr("paid");
	 var stockqty = parseInt($(".addcartproduct").attr("stockcheck"));
	 var qtyval=parseInt($(".qtyval").val());

	 if(qtyval <= 0)
	 {
	  $("#bar-notification").show();
      $("#bar-notification span").html("Quantity must be greater than 0");
		 return;
	 }
	 if( qtyval >= stockqty)
	 {
	  $("#bar-notification").show();
      $("#bar-notification span").html("Available stock is"+stockqty);
		 return;
	 }
	$("#loader").css("display","block");
	 $.ajax({
		 type: "GET",
			url : cpurl+'mapping.php',
			dataType: "html",
			success: function(response) 
			{	
			custid=$.trim(response);
		if(custid == "notlogin")
		{
			var gdjdata = myapurl+'/wpblog/getid?wp='+getCookie('Nop.customer');
			$.ajax({
		 type: "get",
			url : gdjdata,
			dataType: "json",
		   success: function(responset) 
			{	
		
			custid = responset;
			//console.log(custid);

	var cname = "nopmeid";
	cvalue = custid;
	var d = new Date();
		d.setTime(d.getTime() + (2*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

			},
			complete: function () {
				success_guid();
				
			}
		});

		}
		else
		{ 
		var cname = "nopmeid";
	cvalue = custid;
	var d = new Date();
		d.setTime(d.getTime() + (2*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		success_guid();
		}

	 
			
			
			
			}
		});
	 
	 
	});
	
	
	function success_guid()
	{
			var qtme=1;
			cboxvals();
		selboxvals();
		rvals();
		var clist = chbox_list;
		var rlist = rbox_list;
		var slist = selbox_list;
		var attl = clist.concat(rlist);
		var attlist = attl.concat(slist);
		console.log(attlist);
		var json_attrlist = JSON.stringify(attlist);

	if($(".qtyval").val() == 0 || typeof $(".qtyval").val() == 'undefined' || typeof $(".qtyval").val() == undefined)
	{
		qtme=1;
	}	
	else{
		qtme=$(".qtyval").val();
	}
	api_url111 = cpurl+"api/shopping_cart_items.php?url="+api_url11;

			var customercart={"shopping_cart_item":{"product_attributes": JSON.parse(json_attrlist),"quantity": qtme,"shopping_cart_type": "ShoppingCart","product_id": pid,"customer_id": custid}};
$("#loader").show();
		var d = JSON.stringify(customercart);
		
			$.ajax({
		 type: "POST",
			url :api_url111,
			dataType: "json",
	    	data:{dta:d},
			complete: function(resp){
				
			  rs =  resp.responseJSON;
		 
			  ds = rs.errors; 
if(ds['shopping cart item'] != ""){
	$("#bar-notification").show();
$("#bar-notification span").html(ds['shopping cart item']);
 
				$("#loader").css("display","none");
}				
			},
			success: function(response) 
			{
				
				
		$("#loader").css("display","none");
			
	$(".bar-notification span").html("Product added to shopping cart successfully!").show();
	
	$(".bar-notification").show();
	


			$.ajax({
			url :cpurl+'addcart.php',
			success: function(resp){
				$("#spcrt").html(resp);
			}
			});


			},
			error:function(response)
			{
				
				var pp = JSON.parse(response.responseText);
				$(".pp-page-title").nextAll('p').remove();
				$(".pp-page-title").after("<p style='color:red'>"+pp.errors['shopping cart item'][0]+"</p>").slideUp();;
				
			}
		});
	}
	  function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}	
	 jQuery("body").delegate(".delitem","click",function()
	{
		jQuery("#loader").show();
		var delid=$(this).attr("delid");
		var api_urldel = cpurl+"api/delete_cartitem.php?url="+myapurl+"/api/shopping_cart_items/"+delid;
		$.ajax({
		 type: "post",
		 	url : api_urldel,
			dataType: "json",
			success: function(response) 
			{
		jQuery("#loader").hide();
			$(".bar-notification span").html("Product Deleted Successfully!").show();
	
	$(".bar-notification").show();
	
	$.ajax({
			url :cpurl+'addcart.php',
			success: function(resp){
				$("#spcrt").html(resp);
			}
			});
	
			
			}
		});
	});
	  
	 jQuery(document).ready(function(){
		 var meq = "";
		 		var urlParams = new URLSearchParams(window.location.search);
						meq = urlParams.get('q');
						
						if(meq != "" && meq != null)
						{
						
						jQuery("#search_form_input").val(meq);
						jQuery("#search").click();
						var q= $("#search_form_input").val();
					
						$("#loader").show();
						$.ajax({
							url : cpurl+"3214.php",
							type:"post",
							data:"q="+q,
							success:function(resp){
							
								$(".productsearch").html(resp);
								$("#loader").hide();
								$(".productsearch").show();
							}
						});
						}
		 
					jQuery("#search").on("click", function(){
					
						$(".productsearch").hide();
					
						var q= $("#search_form_input").val();
					
						$("#loader").show();
						$.ajax({
							url : cpurl+"3214.php",
							type:"post",
							data:"q="+q,
							success:function(resp){
							
								$(".productsearch").html(resp);
								$("#loader").hide();
								$(".productsearch").show();
							}
						})
					})
				}) 
	  
	  jQuery("body").delegate(".shopping_Cart_menu","click",function()
	  {
		 // $("#cart_pop").slideDown(500);
		  $("#cart_pop").toggle();
	  });
	  
function nopgetid()
{
	
	var getajdt = myapurl+'/wpblog/getid?wp='+getCookie('Nop.customer');

	$.ajax({
		 type: "get",
			url : getajdt,
			dataType: "json",
		   success: function(responset) 
			{	
		
			custid = responset;
			
			//console.log(custid);

	var cname = "nopmeid";
	cvalue = custid;
	var d = new Date();
		d.setTime(d.getTime() + (2*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

			},
			complete: function () {
				
				
			}
		});
}


$(".product-essential input[type=radio]:checked").each(function(){
			  
		  var raid = $(this).attr("name");
		  var ra_val=$(this).attr("value");
		  resval = parseFloat($("#pprss").html()) + parseFloat(ra_val);
		  $("#pprss").html(resval);
		   arrname.push(
		 {
			 name:raid,
			 value:ra_val
		 }
		 );
         });
		  $(".product-essential input[type=checkbox]:checked").each(function(){
			    var ckk_id = $(this).attr("name");
				var ckk_val=$(this).attr("pr-data");
				 resval = parseFloat($("#pprss").html()) + parseFloat(ckk_val);
		  $("#pprss").html(resval);
		   arrname.push(
		 {
			 name:ckk_id,
			 value:ckk_val
		 }
		 );
		  });
$(".product-essential select").each(function(){
			  
		  var selpp_id = $(this).attr("id");
		  var selpp_val=$(this).find("option:selected").attr("value");
		  resval = parseFloat($("#pprss").html()) + parseFloat(selpp_val);
		  $("#pprss").html(resval);
		   arrname.push(
		 {
			 name:selpp_id,
			 value:selpp_val
		 }
		 );
		  
});
	  $(".product-essential input[type=radio]").click(function()
	 {
		
		 var nameatr = $(this).attr("name");
		 var nameval = $(this).attr("value");

		if( !lookuparr(nameatr) ) {
			resval = parseFloat($("#pprss").html()) + parseFloat(nameval);
			$("#pprss").html(resval);
		 arrname.push(
		 {
			 name:nameatr,
			 value:nameval
		 }
		 );
		}
		 else
		 {
			 var index = lookuparrindex(nameatr);
			 var valueAtIndex1 = arrname[index].value;
			 resval = parseFloat($("#pprss").html()) - parseFloat(valueAtIndex1);
			 $("#pprss").html(resval);
			 resval = parseFloat($("#pprss").html()) + parseFloat(nameval);
		     $("#pprss").html(resval);
			  arrname.splice(index, 1);
		 arrname.push(
		 {
			 name:nameatr,
			 value:nameval
		 }
		 );
		 }
			// alert(parseFloat(resval));
	 });
	 $(".product-essential input[type=checkbox]").change(function()
	 {
		  var cck_cval = $(this).is(":checked");
		  var nameatr = $(this).attr("name");
		  var nameval = $(this).attr("pr-data");

		  if(cck_cval == true)
		  {
					if( !lookuparr(nameatr) ) {
			resval = parseFloat($("#pprss").html()) + parseFloat(nameval);
			$("#pprss").html(resval);
		 arrname.push(
		 {
			 name:nameatr,
			 value:nameval
		 }
		 );
		}
		 else
		 {
			 var index = lookuparrindex(nameatr);
			 var valueAtIndex1 = arrname[index].value;
			 resval = parseFloat($("#pprss").html()) - parseFloat(valueAtIndex1);
			 $("#pprss").html(resval);
			 resval = parseFloat($("#pprss").html()) + parseFloat(nameval);
		     $("#pprss").html(resval);
			  arrname.splice(index, 1);
		 arrname.push(
		 {
			 name:nameatr,
			 value:nameval
		 }
		 );
		 }
		  }
		  else
		  {
			  var index = lookuparrindex(nameatr);
			 var valueAtIndex1 = arrname[index].value;
			resval = parseFloat($("#pprss").html()) - parseFloat(valueAtIndex1);
			 $("#pprss").html(resval);
			  arrname.splice(index, 1);
		  }
		  console.log(arrname);
	 });
	 $(".product-essential select").change(function()
	 {
		
		  
		  var nameatr = $(this).attr("id");
		  var nameval = $(this).find("option:selected").attr("value");
 
		 
					if( !lookuparr(nameatr) ) {
			resval = parseFloat($("#pprss").html()) + parseFloat(nameval);
			$("#pprss").html(resval);
		 arrname.push(
		 {
			 name:nameatr,
			 value:nameval
		 }
		 );
		}
		 else
		 {
			 var index = lookuparrindex(nameatr);
			 var valueAtIndex1 = arrname[index].value;
			 resval = parseFloat($("#pprss").html()) - parseFloat(valueAtIndex1);
			 $("#pprss").html(resval);
			 resval = parseFloat($("#pprss").html()) + parseFloat(nameval);
		     $("#pprss").html(resval);
			  arrname.splice(index, 1);
		 arrname.push(
		 {
			 name:nameatr,
			 value:nameval
		 }
		 );
		 }
		  
		  
		//  console.log(arrname);
	 });
	 
	 function lookuparr( name ) {
    for(var i = 0, len = arrname.length; i < len; i++) {
        if( arrname[ i ].name === name )
            return true;
    }
    return false;
}

 function lookuparrindex( name ) {

    for(var i = 0, len = arrname.length; i < len; i++) {
        if( arrname[ i ].name === name )
            return i;
    }
    
}

		
});
	