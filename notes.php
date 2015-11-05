<?php include('header.php'); include('connect.php');
session_start();
$uid=$_SESSION['user']['id'];
$notes_html='';

$row=$db->select('notes',"uid='$uid'");
for ($i=0; $i<count($row); $i++)
{
$notes_html.='<li><a data-transition="slide" href="view_note.php?id='.$row[$i]['id'].'">'.$row[$i]['title'].'</a></li>';
}
?>

<div id="notes" data-role="page">

<!--LOGO-->

<div data-role="header" data-theme="a" >
<a href="index.php" data-ajax="false" data-icon="home" class="">HOME</a>
<h1>Notes</h1>
<a data-type="button" data-icon="plus" data-transition="slideup" class="ui-nodisc-icon ui-alt-icon" href="#add_note">ADD</a>
</div>


<!--CONTAINER-->
<div role="main" class="ui-content">
<ul class="ui-nodisc-icon ui-alt-icon" data-role="listview">
<?=$notes_html?>
</ul>
</div>



</div>


<div id="add_note" data-role="page">

<!--LOGO-->

<div data-role="header" data-theme="a" >
<a href="notes.php" data-rel="back" class="ui-nodisc-icon ui-alt-icon" data-icon="carat-d" data-iconpos="notext">back</a>
<h1>Add Note</h1>
</div>


<!--CONTAINER-->
<div role="main" class="ui-content">
<div>
  <form data-ajax="false" id="note_form">
    <input name="task" value="add_note" type="hidden">
      <label for="title">Title</label>
<input type="text" id="title" name="title" required />
  <label for="content">Content</label>
<textarea id="content" name="content" required></textarea>
<button type="submit" data-theme="g">SAVE</button>
</form>
</div>
</div>



</div>

<?php include('footer.php');?>
