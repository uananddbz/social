<?php include('header.php'); include('connect.php');
session_start();
$uid=$_SESSION['user']['id'];
$id=$_GET['id'];

$row=$db->select('notes',"id='$id'");

?>
 

<div id="view_note" data-role="page">

<!--LOGO-->

<div data-role="header" data-theme="a" >

<a href="notes.php" data-rel="back" class="ui-nodisc-icon ui-alt-icon" data-icon="carat-l" data-iconpos="notext">back</a>
<h1><?=$row[0]['title']?></h1>
<a href="edit_note.php?id=<?=$id?>" data-transition="flip" class="ui-nodisc-icon ui-alt-icon ui-corner-all" data-icon="edit" data-inline="true" >Edit</a>
</div>


<!--CONTAINER-->
<div role="main" class="ui-content">
<p class="ui-body ui-body-a ui-corner-all">
<?=$row[0]['content'];?>
</p>
</div>



</div>




<?php include('footer.php');?>
