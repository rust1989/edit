<?php
require_once('inc/init.php');
$guidemenu="<b><a href='member.php?action=myfavs'>".$_SLANG['member.myfavs']."</a></b><b><a href='member.php?action=myorders'>".$_SLANG['member.myorders']."</a></b><b><a href='member.php?action=details'>".$_SLANG['member.details']."</a></b><b><a href='member.php?action=password'>".$_SLANG['member.password']."</a></b>";

switch($_GET['action']){
 case "myfavs":
 $rows=$db->row_select("favs","memberid='{$lg['memberid']}' and langid={$_SYS['langid']}");
 $includepath="member_favs.htm";
 break;
 case "myorders":
 $rows=$db->row_select("orders","memberid='{$lg['memberid']}' and langid={$_SYS['langid']}");
 $includepath="member_orders.htm";
 break;
 case "details":
 $username=rSESSION('membername');

 $member=$db->row_select_one("members","membername='{$username}'");
 
 $includepath="member_details.htm";
 break;
 case "password":
 $includepath="member_password.htm";
 break;
 default:
  $username=rSESSION('membername');
 $member=$db->row_select_one("members","membername='{$username}'");
 $includepath="member_details.htm";	
}

require_once('./header.php');
require_once getTemplatePath('member.htm');
footer();

?>