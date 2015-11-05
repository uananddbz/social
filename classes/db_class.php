<?php
class db {

private $host; 
private $db_user;
private $db_pass;
private $db_name;
private $con;

//auto run function
function __construct($host,$db_user,$db_pass,$db_name) {
$this->host=$host;
$this->db_user=$db_user;
$this->db_pass=$db_pass;
$this->db_name=$db_name;
	}
//auto run function-/>

//connect to database

function connect() {

if (!$this->con)
{
	$this->sql = mysqli_connect($this->host, $this->db_user, $this->db_pass);
$sel=mysqli_select_db($this->sql,$this->db_name);

if ($sel)
{$this->con=true;}
}

}
//connect to database -/>

//select from database

function select($table,$where=null,$select='*',$order=null) {
$this->connect();

$where=($where!=null?'WHERE '.$where:null);
$order=($order!=null?'ORDER BY '.$order:null);

$q = mysqli_query($this->sql,"SELECT $select FROM $table $where $order");
if ($q)
{
$rows=array();
while($r = mysqli_fetch_assoc($q))
  {
array_push($rows,$r);
  }
  return $rows;
  }
  else
  return false;

}
//select from database -/>

//insert to database

function insert($table,$data) {
$this->connect();

//if data is array
if (is_array($data))
{
//columns
$key=array_keys($data);
$column=implode(',',$key);

//values
$v=array();

for ($i=0; $i<count($data); $i++)
{
array_push($v,"'".$data[$key[$i]]."'");
}

$value=implode(',',$v);

//insert to db
$q="INSERT INTO $table ($column) VALUES ($value)";
}

//if data is string
else
{
$q="INSERT INTO $table $data";
}

if (mysqli_query($this->sql,$q))
{return true;}
else
{return false;}

}
//insert to database -/>


//update to database
function update($table,$where=null,$data) {

//check if where is defined
if ($where!=null)
{
$this->connect();


//if data is array
if (is_array($data))
{

//columns
$key=array_keys($data);

//values
$v=array();

for ($i=0; $i<count($data); $i++)
{
array_push($v,$key[$i]."='".$data[$key[$i]]."'");
}
$value=implode(',',$v);


//insert to db
$q="UPDATE $table SET $value WHERE $where";
}

//if data is string
else
{
$q="UPDATE $table SET $data WHERE $where";
}

if (mysqli_query($this->sql,$q))
{return true;}
else
{return false;}

}

else
{return false;}

}
//update to database -/>


//delete from database
function delete($table,$where=null) {
$this->connect();

if ($where!=null)
{
$q = "DELETE FROM $table WHERE $where";

if (mysqli_query($this->sql,$q))
{return true;}
else
{return false;}
}

}
//delete from database -/>

}
?>
