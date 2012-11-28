<?php
require_once('inc/init.php');
$formaction="signup.php?action=register";


if($_GET['action']=="register"){
	    
        $eu = strFilter($_POST["membername"]);
		$ep=strFilter($_POST['memberpass']);
		$ev = strFilter($_POST["email"]);
		$sv = strFilter($_POST["securitycode"]);
		if(empty($eu)||empty($ep)||empty($ev)) printMsg('signup_required_1');
		$signuptime=$cache_global['signupitime']*3600;
		$time=time();
		$ip=getIP();
		
		
		if(($time-$row['signuptime'])<$signuptime){
		printMsg('signup_signupitime');
		}
		$member['membername']=$eu;
		$member['memberpass']=encrypt($eu,$ep);
		$member['email']=$ev;
		$member['signuptime']=$time;
		$member['logintime']=$time;
		$member['lastlogintime']=$time;
		$member['signupip']=$ip;
		
		if($cache_global['issignupverify']==0){
		   $member['groupid']=1;
		}else if($cache_global['issignupverify']==1){
		   $member['groupid']=GROUP_NOVERIFY;
		}else if($cache_global['issignupverify']==2){
		   $member['groupid']=GROUP_NOVERIFY;
		}
		
		
		$db->row_insert("members",$member);
	    $issignupverify=$cache_global['issignupverify'];
		
		$d=$_SYS['time']-24*3600;
		$activecode=md5($member['membername'].$member['memberpass'].$_SYS['time'].mt_rand(1000,9999));
		$memberfield['memberid'] = $db->insert_id();
		$memberfield['code'] = $activecode;
		$memberfield['createtime'] = $_SYS['time'];
		$memberfield['type'] = 1;	//重置密码
		$db->row_insert("memberfield",$memberfield);		
        printMsg("signup_succeed_$issignupverify");
}else{
require_once('./header.php');
require_once getTemplatePath('signup.htm');
footer();
}

?>