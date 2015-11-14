<?php include('fun.php'); include('connect.php'); include('header.php'); include('classes/user_class.php');
$action=new user($db);


$user=$_SESSION['user'];
//<--load posts
$p_html='';
$id=$user['id'];
$oid=0;

//get posts
$posts=array();

$row=$action->get_posts(5,$user['id']);

if (count($row)<1) {}
else {
for ($i=0; $i<count($row); $i++) {

if ($row[$i]['liked']) {$lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'.$row[$i]['c_like'].'</button>'; } else {$lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'.$row[$i]['c_like'].'</button>'; }

$p_html.='<li id="'.$row[$i]['id'].'"><h4>'.$row[$i]['time'].'</h4><p>'.$row[$i]['content'].'</p><p>'.$lb.'</p><p class="ui-li-aside"><a href="#del_post" onclick="d_el=this;" data-rel="popup" data-position-to="window" class="r_t no_u" data-transition="pop">Remove</a></p></li>';
$oid=$row[$i]['id'];
}

}
//load posts--->
?>



<div data-role="page">
<script>
oid=<?=$oid?>;

function get_posts() {
$ul=$("#posts");

$.ajax({url:"ajax.php",
	   data:{'task':'get_user_posts','id':'<?=$user['id']?>','oid':oid},
	   type:'POST',
	   dataType:'JSON',
	   success:function(result) {
	   	   if (result.length==0) {}
	   else {
	   html='';
	   for (i in result) {
	   
	   if (result[i].liked=='1') {lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'+result[i].c_like+'</button>'; } else {lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'+result[i].c_like+'</button>'; }
	   
  html=html+'<li id="'+result[i].id+'"><h4>'+result[i].time+'</h4><p>'+result[i].content+'</p><p>'+lb+'</p><p class="ui-li-aside"><a href="#del_post" onclick="d_el=this;" data-rel="popup" data-position-to="window" class="r_t no_u" data-transition="pop">Remove</a></p></li>';
		oid=result[i].id;
				}
		$ul.append(html);
		$ul.listview( "refresh" );
		$ul.trigger( "create");
        $ul.trigger( "updatelayout");
		 }

	   }
  });

}


function del_post(el) {

var id=$(el).parents('li').attr("id");
$.ajax({url:"ajax.php",
	   data:{'task':'del_post','id':id},
	   type:'POST',
	   success:function() {
$(el).parents('li').slideUp(function() {$(this).remove()});
	   }
  });


}

// Instantiate the popup on DOMReady, and enhance its contents
$( function() {
    $( "#profile_pic" ).enhanceWithin().popup();
});
</script>


<!--LOGO-->

<div data-role="header">
<a href="index.php" data-ajax="false" class="ui-nodisc-icon ui-alt-icon" data-icon="carat-l" data-iconpos="notext">home</a>
<h1><?=$user['fname'].' '.$user['lname'];?></h1>
</div>


<!--CONTAINER-->
<div role="main" class="ui-content">
<div data-role="popup" id="profile_pic" data-overlay-theme="b"  data-theme="d" data-corners="false">
<img src="https://graph.facebook.com/<?=$_SESSION['user']['username']?>/picture?type=large" />
</div>

<div data-role="popup" id="del_post" data-overlay-theme="b" data-dismissible="false" >
<div style="min-width:300px;" data-role="header" data-theme="a"><h1>Delete Post</h1></div>
<div role="main" class="ui-content">
<p>Are you sure ?</p>
<fieldset class="ui-grid-a"><div class="ui-block-a">
<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-c" onclick="del_post(d_el);" data-rel="back" data-transition="flow">YES</a></div><div class="ui-block-b">
<a href="#" class="ui-btn ui-corner-all ui-shadow " data-rel="back">NO</a></div></fieldset>
</div>
</div>

<p>
<a href="#profile_pic" data-rel="popup" data-position-to="window" data-transition="pop"><img style="vertical-align:middle;width:100px;" src="https://graph.facebook.com/<?=$_SESSION['user']['username']?>/picture?type=large"></a>
</p>


<ul data-role="listview" data-inset="true" >
<li data-role="list-divider"><h4>BASIC INFORMATION</h4><span class="ui-li-aside"><a href="edit_profile.php" class=" " data-transition="slideup">EDIT</a></span>
</li>
<li><h4>Gender</h4><p><?=$user['gender']?></p></li>
<li><h4>DOB</h4><p><?=$user['dob']?></p></li>
<li><h4>Country</h4><p><?=$user['country']?></p></li>
<li><h4>Occupation</h4><p><?=$user['occupation']?></p></li>
<li><h4>About</h4><p><?=$user['about']?></p></li>
</ul>




<ul id="posts" data-role="listview" class="no_ws post_list" data-inset="true">
<li data-role="list-divider"><h4>POSTS</h4></li>
<?=$p_html?>
</ul>
<div class="ui-bar c">
<button data-shadow="false" data-inline="true" data-mini="true" onclick="get_posts();">Load more</button>
</div>


</div>

</div>
<?php include('footer.php');?>
