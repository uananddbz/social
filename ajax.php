<?php include('connect.php'); include('fun.php'); include('classes/user_class.php');

$user=new user($db);
$task=(isset($_POST['task'])?$_POST['task']:null);
$table='members';

$d = date("d",time());
$m = date("m",time());
$y = date("Y",time());


 switch ($task)
{

case 'login':
echo $user->login($_POST['username'],$_POST['password']);
break;


case 'signup':
echo $user->signup($_POST['username'],$_POST['password'],$_POST['fname'],$_POST['lname']);
break;

case 'friend_toggle':
$user->friend_toggle($_POST['id']);
break;

case 'confirm_friend':
$user->confirm_friend($_POST['id']);
break;

case 'cancel_friend':
$user->cancel_friend($_POST['id']);
break;


case 'find_user':
$name=$_POST['name'];
echo json_encode($db->select('members',"fname like '%$name%' OR lname like '%$name%'",'*',"fname"));
break;
  
case 'add_post':
echo $user->add_post($_POST['content']);
break;


case 'get_posts':
echo json_encode($user->get_posts(5,null,null,$_POST['id']));
break;

case 'refresh_posts':
echo json_encode($user->get_posts(5));
break;


case 'get_user_posts':
echo json_encode($user->get_posts(5,$_POST['id'],null,$_POST['oid']));
break;

case 'del_post':
echo json_encode($user->remove_post($_POST['id']));
break;


case 'like':
echo json_encode($user->like_toggle($_POST['id']));
break;



case 'edit_profile':
$user->check_login();
$id=$_SESSION['user']['id'];

$data['gender']=$_POST['gender'];
$data['dob']=$_POST['dob'];
$data['country']=$_POST['country'];
$data['address']=$_POST['address'];
$data['occupation']=$_POST['occupation'];
$data['about']=$_POST['about'];

$db->update($table,"id=$id",$data);
$user=$db->select($table,"id=$id");
$_SESSION['user']=$user[0];
break;


//Add note
case 'add_note':
echo json_encode($user->add_note($_POST['title'],$_POST['content']));
break;


//Edit note
case 'edit_note':
echo json_encode($user->edit_note($_POST['id'],$_POST['content']));
break;

//Delete note
case 'delete_note':
echo json_encode($user->remove_note($_POST['id']));
break;

}

?>