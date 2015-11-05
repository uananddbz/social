<?php include('header.php'); include('connect.php');
session_start();
$uid=$_SESSION['user']['id'];
$id=$_GET['id'];

$row=$db->select('notes',"id='$id'");

?>
<div id="edit_note" data-role="page">
<script>
function delete_note(id) {
$.ajax({url:"ajax.php",
	   data:{'task':'delete_note','id':id},
	   type:'POST',
	   success:function(result) {
	   if (result=='1')
	   {location='notes.php';}
	   else
	   {alert('error');}
	   }
  });
  return false;
}

</script>	



<!--LOGO-->

<div data-role="header" data-theme="a" >

<a href="#" data-rel="back" class="ui-nodisc-icon ui-alt-icon" data-icon="carat-l">Cancel</a>
<h1>Edit Note</h1>
<button data-icon="delete" onclick="delete_note('<?=$row[0]['id']?>');" class="ui-nodisc-icon" data-theme="c" data-inline="true" >Delete</button>

</div>


<!--CONTAINER-->
<div role="main" class="ui-content">
  <form data-ajax="false" id="edit_note_form">
    <input name="task" value="edit_note" type="hidden">
	<input name="id" value="<?=$row[0]['id']?>" type="hidden">
	<input type="text" value="<?=$row[0]['title']?>" disabled="disabled" />
<textarea name="content">
<?=$row[0]['content'];?>
</textarea>
<button type="submit" class="ui-nodisc-icon ui-corner-all" data-icon="check" data-theme="e" >Save</button>

</form>


</div>



</div>


<?php include('footer.php');?>
