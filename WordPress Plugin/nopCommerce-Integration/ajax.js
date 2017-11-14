// call for the registration form in the frontend
$(document).ready(function(){	
$(".email-custom-form-field").css("margin-left","0");
 $("#nopenable").change(function()
  {
if ($('#nopenable').is(":checked"))
{
 $("#box_role").css("display","block");
 $('#nopenable').val(1);
}
else
{
 $("#box_role").css("display","none");
 $('#nopenable').val(0);
}
  });
if(window.location.href.indexOf("api_settings") > -1) {
	
if($(".nav-tab-active").length == 0)
{
var meu = window.location.href+"&tab=general-settings";
window.location.assign(meu);
}	
		}

$(".admin-register").click(function(){
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
		url : mainurl+'insertwpuser.php',
		dataType: "html",
	    data:{ "username": username, "email": email, "firstname": firstname, "lastname": lastname, "password": pass }, 
	    success: function(response) 
		{	
			$(".error_msg_custom").html(response);
		$(".error_msg_custom").show();
		}
	});
	
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
	var api_url= $("#wpurl-main").val()+"api/getajaxdata.php?url="+$("#url").val()+'/api/customers/search?query=Email:'+email;
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
	var api_url= $("#wpurl-main").val()+"api/shopping_cart_items.php?url="+$("#url").val()+'/api/customers';
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
					url : mainurl+'insertwpusermapping.php',
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
		url : mainurl+'insertwpuser.php',
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

$('body').on('click', '#submit', function(){
var vl = $(this).val();

	if(vl == "Update Profile")
	{

		var nopmeid = nopusrid;

		var api_url = cpurl+"api/updateuser.php?url="+myapurl+"/api/customers/"+nopmeid;
		var newpass = $("#pass1-text").val();
		var firstname = $("#first_name").val();
		var lastname = $("#last_name").val();
	 var customer={
  "customer": {
    "first_name": firstname,
    "last_name": lastname,
    "password": newpass 
  }
};
if(newpass == "")
{
customer={
  "customer": {
    "first_name": firstname,
    "last_name": lastname
    
  }
};
	//var d=JSON.stringify(customer);
	
	var jdata=JSON.stringify(customer);
		
	$.ajax({
		 type: "post",
		 	url : api_url,
			dataType: "json",
			data:{dta:jdata},
			success: function(response) 
			{
	
			}
		});
	
	}
}});
var nopmeid = "";
$('body').on('click', '#submit', function(){


	if(($(this).val() == "Update User")  )
	{

		var usrname= $("#user_login").val();

var uirl = "http://randomtest.strivingprogrammers.com/wp-content/plugins/plugin/getuid.php?usrname="+usrname;


$.ajax({
		 type: "GET",
		 	url : uirl,
			success: function(data) 
			{
	nopmeid=data;




		var api_url = "http://randomtest.strivingprogrammers.com/wp-content/plugins/plugin/api/updateuser.php?url=http://nopapidemo.strivingprogrammers.com/api/customers/"+nopmeid;
		var newpass = $("#pass1-text").val();
		var firstname = $("#first_name").val();
		var lastname = $("#last_name").val();

	 var customer={
  "customer": {
    "first_name": firstname,
    "last_name": lastname,
    "password": newpass 
  }
};
if(newpass == "")
{
customer={
  "customer": {
    "first_name": firstname,
    "last_name": lastname
    
  }
};
}

	//var d=JSON.stringify(customer);
	
	var jdata=JSON.stringify(customer);
alert(jdata);
	$.ajax({
		 type: "post",
		 	url : api_url,
			dataType: "json",
			data:{dta:jdata},
			success: function(response) 
			{
	
			}
		});
	
			}

		});
	}
});



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
});
