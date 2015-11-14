<?php include('header.php'); include('connect.php');
session_start(); 

//check user is login
if (isset($_SESSION['user'])) {}
else {
header("Location: login.php");}

//get user info
$uid=$_SESSION['user']['id'];

$row=$db->select('members',"id='$uid'");
$user=$row[0];

?>

<div data-overlay-theme="b" id="edit_profile_page" data-role="page">


<!--LOGO-->

<div data-role="header">
<a data-role="button" href="profile.php" data-rel="back">Cancel</a>

<h1>Edit Profile</h1>
</div>


<!--CONTAINER-->
<div data-role="content" >

  <form data-ajax="false" id="edit_form">
    <input name="task" value="edit_profile" type="hidden">
      <ul data-role="listview" data-inset="true">
        <li class="ui-field-contain">
      <label for="dob">dob</label>
      <input name="dob" id="dob" value="<?=$user['dob']?>" type="date">
</li><li class="ui-field-contain">
      <label for="gender">gender</label>
      <select name="gender" id="gender" data-role="slider">
        <option value="male" <?=($user['gender']=='male'?'selected=""':'')?>>male</option>
        <option value="female" <?=($user['gender']=='female'?'selected=""':'')?>>female</option>
    </select>
</li><li class="ui-field-contain">
      <label for="country">country</label>
      <input name="country" id="country" value="<?=$user['country']?>" type="text">
</li><li class="ui-field-contain">
	  <label for="address">address</label>
      <input name="address" id="address" value="<?=$user['address']?>" type="text">
</li><li class="ui-field-contain">
	  <label for="occupation">occupation</label>
      <input name="occupation" id="occupation" value="<?=$user['occupation']?>" type="text">
</li><li class="ui-field-contain">
	  <label for="about">about</label>
      <input name="about" id="about" value="<?=$user['about']?>" type="text">
	  </li></ul>
<button type="submit" data-theme="e">SAVE</button>

    </form>
	
</div>

</div>


<?php include('footer.php');?>
