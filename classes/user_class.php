<?php
class user {

public $uid; 
public $login; 
public $db; 

//auto run function
function __construct($db) {
$this->db=$db;
session_start();
if (isset($_SESSION['user'])) {$this->uid=$_SESSION['user']['id'];$this->login=true;}
	}
//auto run function-/>

//----------login and signup---------

//check login
function check_login() {
if (!$this->login)
{
if (isset($_SESSION['user'])) {$this->uid=$_SESSION['user']['id'];$this->login=true;}
else {header("Location: login.php");}
}

}
//check login


//login
function login($username,$password) {
$row=$this->db->select("members","username='$username' AND password='$password'");
if ($row) {
$_SESSION['user']=$row[0];
return '1';
}
else {
unset($_SESSION['user']);
return '0';
}
}
//login

//sign-up
function signup($username,$password,$fname,$lname) {

//check if username is  already exist
if ($this->db->select("members","username='$username'"))
{return '0';}

//else register user on db
else
{
$data['username']=$username;
$data['password']=$password;
$data['fname']=$fname;
$data['lname']=$lname;

if ($this->db->insert("members",$data))
{return '1';}
else
{return mysql_error();}

}

}
//sign-up

//----------login and signup--------->


//----------friend---------

//friend toggle
function friend_toggle($fid) {
$this->check_login();
$uid=$this->uid;
$table='members';

$row=$this->db->select($table,"id='$uid'");
$user=$row[0];
$row=$this->db->select($table,"id='$fid'");
$friend=$row[0];

//if fid is already friend then unfriend
if (check_in_array($fid,$user['f_list']))
{
$data['f_list']=remove_array($fid,$user['f_list']);
$this->db->update($table,"id='$uid'",$data);
$data['f_list']=remove_array($uid,$friend['f_list']);
$this->db->update($table,"id='$fid'",$data);
}

//elseif fid is not friend and user sended request then remove request from user db
elseif (check_in_array($uid,$friend['r_list']))
{
$data['r_list']=remove_array($uid,$friend['r_list']);
$this->db->update($table,"id='$fid'",$data);
}

//elseif request is not sended then send request to fid
else
{
$data['r_list']=add_array($uid,$friend['r_list']);
$this->db->update($table,"id='$fid'",$data);
}


}

//confirm friend
function confirm_friend($fid) {
$this->check_login();
$uid=$this->uid;
$table='members';

$row=$this->db->select($table,"id='$uid'");
$user=$row[0];
$row=$this->db->select($table,"id='$fid'");
$friend=$row[0];

if (check_in_array($fid,$user['r_list']))
{
$data['f_list']=add_array($uid,$friend['f_list']);
$this->db->update($table,"id='$fid'",$data);
$data['f_list']=add_array($fid,$user['f_list']);
$data['r_list']=remove_array($fid,$user['r_list']);
$this->db->update($table,"id='$uid'",$data);
}

}

//cancel friend
function cancel_friend($fid) {
$this->check_login();
$uid=$this->uid;
$table='members';

$row=$this->db->select($table,"id='$uid'");
$user=$row[0];
$data['r_list']=remove_array($fid,$user['r_list']);
$this->db->update($table,"id='$uid'",$data);

}

//----------friend--------->


//----------posts---------

//Add posts
function add_post($content) {
$this->check_login();
$data['uid']=$this->uid;
$data['content']=$content;
$data['time']=date("Y-m-d H:i:s",time());
if ($this->db->insert('posts',$data))
{return '1';}
else
{return mysql_error();}

}

//get posts
function get_posts($limit=null,$id=null,$lid=null,$oid=null) {
$this->check_login();

$table='posts';
$oid_q='';
$lid_q='';
$id_q='';
$limit_q='';

//get user info
$uid=$this->uid;
$row=$this->db->select('members',"id='$uid'");
$user=$row[0];


//<--load posts
if ($oid) {		$oid_q="AND id<$oid";	}
if ($lid) {		$lid_q="AND id>$lid";	}
if ($limit) {		$limit_q="LIMIT $limit";	}

if ($id) {$id_q="uid='$id'"; }
else {
//make values for sql query
$v=array();
//check if fid is not empty
if ($user['f_list']!='') {

//convert fid to array
$u_list=to_array(add_array($uid,$user['f_list']));

for ($i=0; $i<count($u_list); $i++)
{
array_push($v,"'".$u_list[$i]."'");
}
}
array_push($v,"'".$uid."'");


$va=implode(',',$v);
$id_q="uid IN ($va)";
}



//get posts
$posts=array();

$row=$this->db->select($table,"$id_q $oid_q $lid_q",'*',"time DESC $limit_q");

for ($i=0; $i<count($row); $i++) {
$uid=$row[$i]['uid'];
$ur=$this->db->select('members',"id='$uid'");
$row[$i]['name']=$ur[0]['fname'].' '.$ur[0]['lname'];
$row[$i]['username']=$ur[0]['username'];
$row[$i]['time']=prettyDate($row[$i]['time']);

//convert fid to array
$like=to_array($row[$i]['lid']);

$row[$i]['c_like']=count($like);

if (in_array($user['id'],$like)) {$row[$i]['liked']=1;} else {$row[$i]['liked']=0;}

array_push($posts,$row[$i]);
}

return $posts;

}

//Remove posts
function remove_post($id) {
$this->check_login();
if ($this->db->delete('posts',"id=$id")) {return '1';}
else {return mysql_error();}
}

//like post toggle
function like_toggle($id) {
$this->check_login();

//get exist lid list as array
$row=$this->db->select('posts',"id='$id'");
$l_list=$row[0]['lid'];

//check if post is liked
if (check_in_array($this->uid,$l_list)) {
//if post is liked then unlike it
$l_list=remove_array($this->uid,$l_list);
}
else
{
//add new id to array
$l_list=add_array($this->uid,$l_list);
}


//insert new fid to DB
$data['lid']=$l_list;
if ($this->db->update('posts',"id='$id'",$data)) {return 1;}
else {return mysql_error();}
}

//----------posts--------->


//----------notes---------

//add note
function add_note($title,$content) {
$this->check_login();

$data['uid']=$this->uid;
$data['title']=$title;
$data['content']=$_POST['content'];
$data['time']=date("Y-m-d H:i:s",time());
if ($this->db->insert("notes",$data)) {return 1;}
else {return 0;}
}

//edit note
function edit_note($id,$content) {
$this->check_login();
$data['uid']=$this->uid;
$data['content']=$content;
if ($this->db->update("notes","id='$id'",$data)) {return 1;}
else {return 0;}
}

//delete note
function remove_note($id) {
$this->check_login();
if ($this->db->delete("notes","id='$id'")) {return 1;}
else {return 0;}
}


//----------notes--------->


}
?>