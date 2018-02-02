<?php
 // header("Content-type:text/html; charset=utf-8");
class DB
{
  private $con;
  public function __construct($dbname)
  {
  	try{
  		$this->con=new PDO("mysql:host=localhost;dbname=$dbname","root","root");
   		$this->con->exec('set names utf8');
  	}catch(Exception $e){
  		echo 'DB error: '.$e->getMessage();
  	}
   
  }
  public function exec($sql)
  {
   return $this->con->exec($sql);
  }
  public function query($sql)
  {
   $stmt=$this->con->query($sql);
   if($stmt)
   {
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
   else
   {
    return $stmt;
   }

  }
  public function getRows($sql)
  {
   $stmt=$this->con->query($sql);

    if($stmt)
   {
      return $stmt->fetch(PDO::FETCH_NUM)[0];  
   }
   else
   {
      return $stmt;
   }
  }
  public function rowCount($sql)
  {
  	$stmt=$this->con->query($sql);
  	return $stmt->rowCount();
  }
  public function prepare($sql,$array=array()){
    $stmt=$this->con->prepare($sql);
    $stmt->execute($array);
    return $stmt;
  }
  public function lastInsertId($id){
    return $this->con->lastInsertId($id);
  }
}
$db = new DB('album');
?>