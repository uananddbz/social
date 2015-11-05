<?php include('header.php');?>


<div id="login_page" data-role="page">
<script>
$( document ).on( "pageinit","#login_page", function() {


$("#login_form").submit(function(e){
data=$(this).serializeArray();

$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:function(result) {
	   if (result=='1')
	   {location='index.php';}
	   else
	   {alert('wrong username or password');}
	   }
  });
  return false;
});

	
});
</script>



<!--CONTAINER-->
<div data-role="content" >
<h1 class="c">Usay</h1>

<div data-role="popup" class="ui-bar" data-theme="e" id="alert"></div>
<div class="ui-body">
	    	<p>Don't have an account? <a data-icon="plus" href="#signup_page" data-theme="d" data-role="button" data-inline="true" class="ui-nodisc-icon" data-transition="flip" data-corners="false">Sign Up</a></p>
  <form data-ajax="false" id="login_form">
  <input name="task" value="login" type="hidden">
      <label for="l_username">username</label>
      <input data-clear-btn="true" name="username" id="l_username" value="" type="text" required>
      <label for="l_password">password</label>
      <input data-clear-btn="true" name="password" id="l_password" value="" type="password" required>
		  <button type="submit" data-icon="eye" data-shadow="false" data-theme="e">LOGIN</button>

    </form>

	</div>
	
</div></div>

<div  data-theme="b" id="signup_page" data-role="page">
<script>
$( document ).on( "pageinit","#signup_page", function() {

$("#signup_form").submit(function(e){
data=$(this).serializeArray();

$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:function(result) {
	   if (result=='1')
	   {alert('registered succesfull');}
	   else if (result=='0')
	   {alert('username already exist');}
	   else
	   {alert(result);}
	   
	   }
  });
  return false;
});

	
});
</script>



<!--CONTAINER-->
<div data-role="content" >
<h1 class="c">Usay</h1>
  <form data-ajax="false" id="signup_form">
  <input type="hidden" name="task" value="signup" />
 <div class="ui-body"> 
 	    	<p>Already have an account ? <a data-icon="carat-l" href="#login_page" data-inline="true" data-theme="e" data-role="button" data-transition="flip" class="ui-nodisc-icon" data-corners="false">Log in</a></p>
      <label for="s_username">username</label>
      <input data-clear-btn="true" name="username" id="s_username" value="" type="text" required>
      <label for="s_password">password</label>
      <input data-clear-btn="true" name="password" id="s_password" value="" type="password" required>
      <label for="c_password">confirm password</label>
      <input data-clear-btn="true" name="c_password" id="c_password" value="" type="password" required>
      <label for="fname">first name</label>
      <input data-clear-btn="true" name="fname" id="fname" value="" type="text" required>
	  <label for="lname">last name</label>
      <input data-clear-btn="true" name="lname" id="lname" value="" type="text" required>
      <button type="submit"  data-icon="eye" data-shadow="false" data-theme="d">SIGNUP</button>

    </form>
	
	
</div>


</div>
<?php include('footer.php');?>
