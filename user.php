<?php include('fun.php'); include('connect.php'); include('header.php'); include('classes/user_class.php');
$action=new user($db);


//get user info
$uid=$_SESSION['user']['id'];

if (!isset($_GET['username'])) {header("Location: profile.php");}

$u=$_GET['username'];
$row=$db->select('members',"username='$u'");
$friend=$row[0];
$fid=$friend['id'];

if ($uid==$fid) {
header("Location: profile.php");
}

//<--connect button
$row=$db->select('members',"id='$uid'");
$user=$row[0];
$row=$db->select('members',"id='$fid'");
$friend=$row[0];

//check if request is recieve
if (check_in_array($fid,$user['r_list']))
{
$button='<button class="ui-btn ui-btn-inline ui-btn-e" onclick="confirm_friend('.$fid.');">Confirm friend</button><button class="ui-btn ui-btn-inline" onclick="cancel_friend('.$fid.');">Not now</button>';
}

else
{

if (check_in_array($fid,$user['f_list']))
{
$button='<button class="ui-btn ui-btn-inline" onclick="friend_toggle('.$fid.');">unfriend</button>';
}
elseif (check_in_array($uid,$friend['r_list'])) {
$button='<button class="ui-btn ui-btn-inline" disabled="">Add friend</button><button  class="ui-btn  ui-btn-inline ui-icon-delete ui-btn-icon-notext" onclick="friend_toggle('.$fid.');">Cancel</button>';
}
else {
$button='<button class="ui-btn ui-btn-inline" onclick="friend_toggle('.$fid.');">Add friend</button>';
}

}

//connect button-->

//<--load posts
$p_html='';
$oid=0;

//get posts

$row=$action->get_posts(5,$fid);

if (count($row)<1) {}
else {
for ($i=0; $i<count($row); $i++) {

if ($row[$i]['liked']) {$lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'.$row[$i]['c_like'].'</button>'; } else {$lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'.$row[$i]['c_like'].'</button>'; }

$p_html.='<li id="'.$row[$i]['id'].'">
<h4>'.$row[$i]['time'].'</h4>
<p>'.$row[$i]['content'].'</p>
<p>'.$lb.'</p>
</li>';
$oid=$row[$i]['id'];
}

}
//load posts--->

?>



<div id="user_home" data-role="page">
<script>
oid=<?=$oid?>;

function get_posts() {

$ul=$("#posts");

$.ajax({url:"ajax.php",
	   data:{'task':'get_user_posts','id':'<?=$fid?>','oid':oid},
	   type:'POST',
	   dataType:'JSON',
	   success:function(result) {
	   	   if (result.length==0) {}
	   else {
	   html='';
	   for (i in result) {
	   
	   if (result[i].liked=='1') {lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'+result[i].c_like+'</button>'; } else {lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'+result[i].c_like+'</button>'; }
	   
                html=html+'<li id="'+result[i].id+'"><h4>'+result[i].time+'</h4><p>'+result[i].content+'</p><p>'+lb+'</p></li>';
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


function friend_toggle(id) {
$.ajax({url:"ajax.php",
	   data:{'task':'friend_toggle','id':id},
	   type:'POST',
	   success:function(result) {location.reload();}
  });
	
}

function confirm_friend(id) {
$.ajax({url:"ajax.php",
	   data:{'task':'confirm_friend','id':id},
	   type:'POST',
	   success:function(result) {location.reload();}
  });
	
}

function cancel_friend(id) {
$.ajax({url:"ajax.php",
	   data:{'task':'cancel_friend','id':id},
	   type:'POST',
	   success:function(result) {alert(result);location.reload();}
  });
	
}


// Instantiate the popup on DOMReady, and enhance its contents
$( function() {
    $( "#profile_pic" ).enhanceWithin().popup();
});
</script>


<!--LOGO-->

<div data-role="header">
<a href="index.php"  data-ajax="false" class="ui-nodisc-icon ui-alt-icon" data-icon="carat-l" data-iconpos="notext">home</a>
<h1><?=$user['fname'].' '.$user['lname'];?></h1>

</div>


<!--CONTAINER-->
<div data-role="content" >
<div data-role="popup" id="profile_pic" data-overlay-theme="b" data-theme="d" data-corners="false">
<img src="https://graph.facebook.com/<?=$_SESSION['user']['username']?>/picture?type=large">
</div>




<p>
<a href="#profile_pic" data-rel="popup" data-position-to="window" data-transition="pop"><img style="vertical-align:middle;width:100px;" src="https://graph.facebook.com/<?=$_SESSION['user']['username']?>/picture?type=large"></a>
<span id="action"><div data-inline="true" data-role="controlgroup" data-type="horizontal"><?=$button?></div></span>
</p>


<div class='ui-alt-icon ui-nodisc-icon' data-role="collapsible">
<h4>Basic information</h4>

<ul  data-role="listview">
<li><h4>Gender</h4><p><?=$friend['gender']?></p></li>
<li><h4>DOB</h4><p><?=$friend['dob']?></p></li>
<li><h4>Country</h4><p><?=$friend['country']?></p></li>
<li><h4>Occupation</h4><p><?=$friend['occupation']?></p></li>
<li><h4>About</h4><p><?=$friend['about']?></p></li>
</ul>

</div>


<ul data-role="listview" class="no_ws post_list" id="posts" data-inset="true">
<?=$p_html?>
</ul>
<div class="ui-bar c">
<button data-shadow="false" data-inline="true" data-mini="true" onclick="get_posts();">Load more</button>
</div>


</div>
</div>
<?php include('footer.php');?>
