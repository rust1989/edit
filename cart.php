<?php
require_once('inc/init.php');

$action=$_GET['action'];
switch($action){
case "buy":
$action="buy";
break;
default:
$action="view";
}
$cartid=getCookies("cartid");
if(!empty($cartid)){
$odts=$db->row_select("orderdetails","cartid={$cartid} and langid={$_SYS['langid']}");
foreach($odts as $okey=>$odt){
		$odt['proname']=htmlFilter($odt['proname']);
		$odt['displayprice']=number_format($odt['price'],2);
		$odt['itemtotal']=number_format($odt['price']*$odt['pronum'],2);
		$ordertotal+=($odt['price']*$odt['pronum']);
		$odt['prourl']="../product.php?id={$odt['proid']}";
		$protmppic=$webcore->getPics($odt['picid'],$odt['picpath'],0,true,true);
	    $odt['picpath']=$protmppic['picpath'];
		$odts[$okey]=$odt;
	}
}
require_once('./header.php');
require_once getTemplatePath('cart.htm');
footer();

?>