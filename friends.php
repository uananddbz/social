<?php
 include('connect.php'); include('header.php'); include('fun.php');
session_start();
//check user is login
if (isset($_SESSION['user'])) {}
else {
header("Location: login.php");}

//get user info
$uid=$_SESSION['user']['id'];
$row=$data=$db->select('members',"id='$uid'");
$user=$row[0];

//<---request list


//make values for sql query
$r_list_html='';

$r_list=to_array($user['r_list']);
for ($i=0; $i<count($r_list); $i++)
{
$fid=$r_list[$i];
$row=$db->select('members',"id='$fid'");
$r_list_html.='<li><a data-transition="slide" href="user.php?username='.$row[0]['username'].'"><img  src="avatar.jpg"><h2>'.$row[0]['fname'].' '.$row[0]['lname'].'</h2><p>'.$row[0]['username'].'</p></a></li>';
}


//---request lists-->

//<---friends list


//make values for sql query
$f_list_html='';

$f_list=to_array($user['f_list']);
for ($i=0; $i<count($f_list); $i++)
{
$fid=$f_list[$i];
$row=$db->select('members',"id='$fid'");
$f_list_html.='<li><a data-transition="slide" href="user.php?username='.$row[0]['username'].'"><img  src="avatar.jpg"><h2>'.$row[0]['fname'].' '.$row[0]['lname'].'</h2><p>'.$row[0]['username'].'</p></a></li>';
}


//---friend lists-->
?>




<div data-role="page" >

<!--LOGO-->

<div data-role="header" data-theme="a" >
<a href="index.php" data-rel="back"  class="ui-nodisc-icon ui-alt-icon" data-ajax="false" data-icon="carat-l" data-iconpos="notext">back</a>
<h1>Friends</h1>
<a href="#search_panel" data-icon="search" class="ui-nodisc-icon ui-alt-icon" data-iconpos="notext">search</a>
</div>



<!--search panel--->
	<div data-position="right" data-theme="c"  data-display="overlay" data-role="panel" data-position-fixed="true"  id="search_panel">

<ul data-theme="a" id="search_friend" data-icon="false" data-inset="true" data-autodividers="true" data-role="listview" data-filter="true" data-filter-placeholder="Find friend" >
</ul>
 </div>


<!--CONTAINER-->

<div role="main" class="ui-content">

<div data-role="tabs" id="tabs">

<div data-role="navbar">
    <ul class="ui-nodisc-icon ui-alt-icon">
      <li ><a href="#all"  data-ajax="false">Friends</a></li>
      <li><a href="#requests"  data-ajax="false">Requests <span class="ui-li-count"><?=count(to_array($user['r_list']))?></span></a></li>
    </ul>
  </div>
  
<div id="all">
<ul	data-role="listview" class="ui-nodisc-icon ui-alt-icon"  data-filter="true" data-filter-placeholder="Search friend" data-inset="true" >
<?=$f_list_html?>
</ul>
</div>

<div id="requests">

<ul data-mini="true" data-inset="true" data-role="listview" class="ui-nodisc-icon ui-alt-icon" data-filter-placeholder="Search">
<?=$r_list_html?>
</ul>
</div>

</div>

</div>




 <script>

$( document ).on( "pageinit", function() {


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
</div>

<!--footer-->


<?php include('footer.php');?>
