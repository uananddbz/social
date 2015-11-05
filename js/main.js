$(document).ajaxStart(function(){
if (typeof ajax_txt === 'undefined')
{
$.mobile.loading( "show");
}
else
{
$.mobile.loading( "show",{text: ajax_txt,textVisible: 'true'});
ajax_txt=undefined;
}

});

$(document).ajaxStop(function(){
$.mobile.loading( "hide");
});




//<-----ALL--FUNCTIONS-----
											   
$( document ).on( "pageinit","#add_note", function() {

$("#note_form").submit(function(e){
data=$(this).serializeArray();

$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:function(result) {
	   location='notes.php';
	   }
  });
  return false;
});
	
});

$( document ).on( "pageinit","#edit_note", function() {
$("#edit_note_form").submit(function(e){
data=$(this).serializeArray();

$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:function(result) {
	   if (result=='1')
	   {history.back(1);}
	   else
	   {alert('error');}
	   }
  });
  return false;
});											   
});		

$( document ).on( "pageinit","#edit_profile_page", function() {
$("#edit_form").submit(function(e){
data=$(this).serializeArray();

$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:function(result) {
location="profile.php";
	   }
  });
  return false;
});										   
});		







$( document ).on( "click",".like", function() {
var el=$(this);
var pid=el.parents('li').attr("id");

$.ajax({url:"ajax.php",
	data:{'task':'like','id':pid},
	type:'POST',
	success:function(result) {
	el.toggleClass('ui-alt-icon ui-btn-c ui-btn-a');
	if (el.hasClass("ui-btn-c")) {
	el.html(Number(el.html())+1);
	}
	else
	{
	el.html(Number(el.html())-1);
	}
	
	
	   }

  });

								 
});