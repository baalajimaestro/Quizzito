<?php
session_start();

class users{
	
	public $host="localhost";
	public $username="root";
	public $pass="";
	public $db_name="new_quiz";
	public $conn;
	public $data;
	public $cat;
	public $ques;
	public $cont;
	public $time_alloted;
	public $contest;
	//public $cdata;
	public $answer;
	
	public function __construct()
	{
		$this->conn=new mysqli($this->host,$this->username,$this->pass,$this->db_name);
		if($this->conn->connect_errno)//new
		{  
		   die("data base connection failed".$this->conn->connect_errno);
		}                    //concatenate eh?
		
		
		
	}
	
	public function signup($data)
	{
		$this->conn->query($data);
		return true;
	}
	
	public function url($url)
	{ 
	   header("location:".$url);
	
	}
	
	public function signin($email,$pass)
	{ 
	  $query=$this->conn->query("select name,email,password from signup where email='$email' and password='$pass'");
	  $d=$query->fetch_array(MYSQLI_ASSOC); //how on boolean ?? what function is this ?
	  $name=$d['name'];
	  if($query->num_rows>0)
	  {
		  $_SESSION['email']=$email;
	      $_SESSION['name']=$name;
		  //echo $_SESSION['name'];
		  return true;
	  }
	  
	  else
	  {
		  return false;
	  }
	  
	  
	}
	public function cat_show()
	{
		$query=$this->conn->query("select * from category");
	  while($row=$query->fetch_array(MYSQLI_ASSOC)) //how on boolean ?? what function is this ?
	  {
		 $this->cat[]=$row;
		 //echo "hi";
	  }
	  return $this->cat;
		
	}
	
	
	public function users_profile($email)
	{
	  $query=$this->conn->query("select * from signup where email='$email'");
	  $row=$query->fetch_array(MYSQLI_ASSOC); //how on boolean ?? what function is this ?
	  
	  if($query->num_rows>0)
	  {
		 $this->data[]=$row;
	  }
	  return $this->data;
	  
	 
		
	}
	
	public function ques_show( $ques)
	{    echo $ques;
		
		$query=$this->conn->query("select * from questions where cat_id='$ques'");
	  while($row=$query->fetch_array(MYSQLI_ASSOC)) //how on boolean ?? what function is this ?
	  
	 
	  {
		 $this->ques[]=$row;
	  }
	  return $this->ques;
	  
		
	}
	
	public function answer($data)
	{
		
	  //print_r($data);
	  $ans=implode("",$data);
	  $right=0;
	  $wrong=0;
	  $no_ans=0;
	  //$noans=0;         //just checking the data in the entire table !
	  		$query=$this->conn->query("select id,ans from questions where cat_id='".$_SESSION['cat']."'");  //??
	  while($quest=$query->fetch_array(MYSQLI_ASSOC)) //how on boolean ?? what function is this ?
	  
	                             
	  {                            //this the the name of the option.
		 if($quest['ans']==$_POST[$quest['id']]) //How is post working here??(basically it is there in the posted file also)
		 {
			$right++; 
			 
		 }
		 
		 elseif($_POST[$quest['id']]=="Not Attempted")
		 {
			 $no_ans++;
		 }
		 
		 else
		 
		 {
			 $wrong++;
		 }
		 
		 
		 
		 
		 
		 
	  }
	  $per=($right/($right+$wrong+$no_ans))*100;
	  $array=array();
	  $array['Right Answers']=$right;
	  $array['Not Attempted']=$no_ans;
      $array['Wrong Answers']=$wrong;
	  $array['per']=$per;
	  
	  return $array;


		
	}
	
	
	public function correct_answer($data) //iam afraid everything is serial :)
	{
		
	  //print_r($data);
	  //echo "inside users correct ans";
	  $ans=implode("",$data);
	  $right=0;
	  $wrong=0;
	  $no_ans=0;
	  $i=1;
	  $ra;
	  $ya;
	  $correct_array=array();
	  //$noans=0;         //just checking the data in the entire table !
	  		$query=$this->conn->query("select id,ans from questions where cat_id='".$_SESSION['cat']."'");  //??
	  while($quest=$query->fetch_array(MYSQLI_ASSOC)) //how on boolean ?? what function is this ?
	  
	                             
	  {                            //this the the name of the option.
		 if($quest['ans']==$data[$quest['id']]) //How is post working here??(basically it is there in the posted file also)
		 {
			$ya= $data[$quest['id']]+1;
			$ra= $quest['ans']+1;
			$correct_array[$i]=nl2br("your answer is correct: ".$ra."\n you scored +1");
			
			 
		 }
		 
		 elseif($data[$quest['id']]=="Not Attempted")
		 {
			 //$ra= $data[$quest['id']]+1;
			// $ya= $data[$quest['id']]+1;
			$ra= $quest['ans']+1;
			 $correct_array[$i]=nl2br("you have not attempted this question, the correct answer is: ".$ra."\n you scored +0");
		 }
		 
		 else
		 
		 {
			 $ya= $data[$quest['id']]+1;
			$ra= $quest['ans']+1;
			 $correct_array[$i]=nl2br("your answer ".$ya." is incorrect, the correct answer is: ".$ra."\n you scored +0");
			 
		 }
		 
		 $i+=1;
		 
		 
		 
		 
		 
		 
	  }
      //echo "trying to print correct array";
	  //print_r($correct_array);
	  return $correct_array;


		
	}
	
	public function add_quiz($rec)
	{
		
		$a=$this->conn->query($rec);
		//echo "inserted";
		//echo $a;
		return true;
	}
	
	
	public function contest_student()
	{
		$name=$_SESSION['name'];
		$query=$this->conn->query("select * from create_contest");
	  while($row=$query->fetch_array(MYSQLI_ASSOC)) //how on boolean ?? what function is this ?
	  {
		 $this->contest[]=$row;
		 //echo "hi";
	  }
	  return $this->contest;
		
				
	}
	
	
		public function con_show($con_id)
	{    //echo $con_id;
	    
		$query1=$this->conn->query("select * from create_contest where id='$con_id'");
		$row1=$query1->fetch_array(MYSQLI_ASSOC);
		$cat_id=$row1['cat_id'];
		$no_of_ques=$row1['no_of_ques'];
		$random=$row1['random'];
		$time_alloted=$row1['time'];
		//echo $time_alloted;
		//print_r($row1);
		
		$i=$no_of_ques;
		 
		$query=$this->conn->query("select * from questions where cat_id='$cat_id'");
	  while($i>0) //how on boolean ?? what function is this ?
	  
	 
	  {
		 $row=$query->fetch_array(MYSQLI_ASSOC);   //first i questions only
		 $this->cont[]=$row;
		 $i-=1;
	  }
	  return $this->cont;
	  
		
	}
	
	
	
	
	
}

new users;


?>