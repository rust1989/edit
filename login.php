<?php
require_once('inc/init.php');
$loginaction="login.php?action=checklogin";

if($_GET['action']=="checklogin"){
	     $username=strFilter($_POST['membername']);
	    $userpass=strFilter($_POST['memberpass']);
        $userpass = encrypt($username,$userpass);
		
		if(empty($username)||empty($userpass)) printMsg('signup_required_1');
		$row=$db->row_select_one("members","membername='{$username}' and memberpass='{$userpass}'");
		
		if($row==false){
		  
			printMsg('login_namepasserr');
		}else{
			$uobj['logintime']=time();
			$db->row_update("members",$uobj,"id={$row['id']}");
			$t= -86400 * 365 * 2;
			
			wSESSION('memberid',$row['id']);
			wSESSION('groupid',$row['groupid']);
			wSESSION('membername',$row['membername'], $t);
			wSESSION('memberpass',$row['memberpass'], $t);
			
			setCookies("cartid",$row['id'],3600*24*7);
			//session_destroy();
			setCookies('membername', $username, $t);
			
			setCookies('userpass', $userpass, $t);
			setCookies('expire', '', $t);
			wSESSION('memberauth', md5($row['membername'].$row['memberpass'].$cache_global['salt']), $t);
			
			printMsg('login_succeed');
			
		}
}else{
require_once('./header.php');
require_once getTemplatePath('login.htm');
footer();
}
?>