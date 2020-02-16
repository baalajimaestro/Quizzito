<?php
//$n = $_POST["n"];     //GO TO EACH PAGE(HTML) AND DO SOMETHING(PHP)  ALL FUNCTIONS ARE KEPT IN A SEPARATE FILE SO THEY CAN BE RESUSED.
                        //SESSION(ONLY KNOWLEDGE ABT THE USER) HAS TO START IN ALL PAGES..BECAUSE PAGES ARE INDIPENDENT(NEW FRESH PAGES)
						//OF EACH OTHER. SO PUT THAT ALSO IN THE SEPARATE FILE. BECAUSE All the pages are fresh..we have to create new objects in each page and
						//then use the functions freshly.
						//TOP TO DOWN EXECUTION LIKE ANY HTML FILE.
//$n = $_POST; Bettar use extract else error: array to string conversion.
include("class/users.php");
$add_quiz= new users;
extract($_POST);//  directly use variables instead of writting post everywhere !!;
$cat= $_POST['cat'];
$name=$_SESSION['ad_name'];
//$ques->ques_show($cat);
//$_SESSION['cat']=$cat;




//echo $n;
$query="insert into create_contest values('','$name','$cat','$e','$p','$t')";


if($add_quiz->signup($query))
{
	$add_quiz->url("home_admin.php?run=success"); //what ??
}






?>