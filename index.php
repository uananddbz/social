<?php include('connect.php'); include('header.php'); include('fun.php');include('classes/user_class.php');

$action=new user($db);

$uid=$_SESSION['user']['id'];
$row=$data=$db->select('members',"id='$uid'");
$user=$row[0];
$user['fullname']=$user['fname'].' '.$user['lname'];
//<--load posts
$p_html='';
$lid=0;
$oid=0;

//get posts

$posts=array();

$row=$action->get_posts(5);

if (count($row)!=0)
{
for ($i=0; $i<count($row); $i++) {
$uid=$row[$i]['uid'];
$ur=$db->select('members',"id='$uid'");


if ($row[$i]['liked']) {$lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'.$row[$i]['c_like'].'</button>'; } else {$lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'.$row[$i]['c_like'].'</button>'; }

$p_html.='<li id="'.$row[$i]['id'].'"><img src="avatar.jpg" class="ui-li-icon ui-corner-none"><h2><a class="no_u" data-ajax="false" href="user.php?username='.$ur[0]['username'].'">'.$ur[0]['fname'].' '.$ur[0]['lname'].'</a></h2>
<p>'.$row[$i]['content'].'</p>
<p>'.$lb.'</p><p class="ui-li-aside"><b>'.$row[$i]['time'].'</b></p></li>';
$oid=$row[$i]['id'];
}

$lid=$row[0]['id'];}
//load posts--->
 ?>
 <script>
oid=<?=$oid?>;

function get_posts() {

$ul=$("#posts");

$.ajax({url:"ajax.php",
	   data:{'task':'get_posts','id':oid},
	   type:'POST',
	   dataType:'JSON',
	   success:function(result) {
	   	   if (result.length==0) {}
	   else {
	   html='';
	   for (i in result) {
	   
	   if (result[i].liked=='1') {lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'+result[i].c_like+'</button>'; } else {lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'+result[i].c_like+'</button>'; }
	   
                html=html+'<li id="'+result[i].id+'"><img src="avatar.jpg" class="ui-li-icon ui-corner-none"><h2><a class="no_u" href="user.php?username='+result[i].username+'">'+result[i].name+'</a></h2><p>'+result[i].content+'</p><p>'+lb+'</p><p class="ui-li-aside"><b>'+result[i].time+'</b></p></li>';
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

function refresh_posts() {

$ul=$("#posts");

$.ajax({url:"ajax.php",
	   data:{'task':'refresh_posts'},
	   type:'POST',
	   dataType:'JSON',
	   success:function(result) {
	   	   if (result.length==0) {}
	   else {
	   html='';
	   for (i in result) {
	   
	   if (result[i].liked=='1') {lb='<button data-inline="true" class="like ui-nodisc-icon" data-theme="c" data-icon="heart">'+result[i].c_like+'</button>'; } else {lb='<button data-inline="true" class="ui-nodisc-icon ui-alt-icon like" data-icon="heart">'+result[i].c_like+'</button>'; }
	   
                html=html+'<li id="'+result[i].id+'"><img src="avatar.jpg" class="ui-li-icon ui-corner-none"><h2><a class="no_u" href="user.php?username='+result[i].username+'">'+result[i].name+'</a></h2><p>'+result[i].content+'</p><p>'+lb+'</p><p class="ui-li-aside"><b>'+result[i].time+'</b></p></li>';
		lid=result[i].id;
				}
		$ul.fadeOut('fast',function() {
		$(this).html(html).listview( "refresh" ).trigger( "create").trigger( "updatelayout").fadeIn('fast');
		});

		 }

	   }
  });

}

$( document ).on( "pageinit", function() {

$("#sub_but").click(function(){

var data=$('#post_form').serializeArray();	
if (data[1].value=='') {alert('textbox is empty');return false;}

$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:function(result) {
  $('#content').val('');
  refresh_posts();
	   }
  });
});


$( "#search_friend" ).on( "listviewbeforefilter", function ( e, data ) {
        var $ul = $( this ),
            $input = $( data.input ),
            value = $input.val(),
            html = "";
        $ul.html( "" );
        if ( value && value.length > 0 ) {
            $ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
            $ul.listview( "refresh" );
            $.ajax({
                url: "ajax.php",
				type:'POST',
                dataType: "json",
                data: {'task':'find_user','name':$input.val()}
            })
            .then( function ( response ) {
                $.each( response, function ( i, val ) {
                    html += "<li><a data-transition='pop' href='user.php?username="+val.username+"'>" + val.fname+' '+val.lname + "<p>"+val.username+"</p></a></li>";
                });
                $ul.html( html );
                $ul.listview( "refresh" );
                $ul.trigger( "updatelayout");
            });
        }
    });
	
});


</script>
 
 
<div id="home" data-role="page">

<div data-theme="b" data-role="panel" data-position-fixed="true"  id="user_panel">


		  <ul  class="ui-alt-icon ui-nodisc-icon" data-theme="a"  data-role="listview">

        <li  data-icon="false" data-theme="b" ><a data-ajax="false" href="profile.php" data-transition="slide"><img  src="https://graph.facebook.com/<?=$_SESSION['user']['username']?>/picture?type=large"><h2><?=$user['fullname']?></h2><p><?=$user['username']?></p></a></li>
		<li><a data-ajax="false" href="friends.php" data-transition="slide">Friends <span class="ui-li-count"><?=count(to_array($user['r_list']))?></span> </a></li>
		<li><a data-ajax="false" href="notes.php" data-transition="slide">Notes </a></li>
      </ul>
<div class="ui-content">
    <a data-role="button" data-mini="true" class="ui-nodisc-icon" data-icon="power" data-transition="pop" data-theme="c" href="logout.php">Logout</a> 
	</div>
	</div>
	




<!--LOGO-->

<div data-role="header">
<a href="#user_panel" data-theme="b" class="ui-nodisc-icon" data-icon="bars" data-iconpos="notext">Menu</a>
<h1>Usay</h1>
<button onclick="refresh_posts();" data-inline="true" data-iconpos="notext" class="ui-btn-right" data-icon="recycle">Refresh</button>


</div>



<!--CONTAINER-->
<div role="main" class="ui-content">


<form data-ajax="false" id="post_form">
<input name="task" value="add_post" type="hidden">
<div class="ui-bar">


<textarea placeholder="What's on your mind?" id="content" name="content"></textarea>
<button  type="button" data-shadow="false" id="sub_but" data-theme="g">POST</button>
</div>

</form>


<ul data-count-theme="b" data-mini="true" id="posts" class="no_ws post_list" data-inset="true" data-role="listview">
<?=$p_html?>
</ul>
<div class="ui-bar c">
<button data-shadow="false" data-inline="true" data-mini="true" onclick="get_posts();">Load more</button>
</div>


</div>



</div>



<?php include('footer.php');?>
