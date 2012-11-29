<?php
require_once('./../inc/pager.php');
$effect_lang=_LANG($_AL['all.set.effect'],array($cache_langs[$_SYS['alangid']]['name']));
switch($action){

	/************************************** add edit BEGIN ************************************************/
	case "add":
	case "edit":
	$id=intval($_GET['id']);
	$cid=intval($_GET['cid']);
	if($action=="add"){
		$row=null;
		$row['level']=3;
	}else{
		$row=$db->row_select_one("picture","id={$id}","*");
		$cid=intval($row['cid']);
		$pics=$webcore->getPics($row['picids'],$row['picpaths']);
		
	
		$picjscode='';
		
		foreach($pics as $pic){
			$picjscode.=",{$pic['picid']}";
		}
	}
	
echo <<<EOT
	<table class="settop"><tr><td class="settop_left"><img src="../language/{$cache_langs[$_SYS['alangid']]['directory']}/flag.gif" title="{$effect_lang}" /></td><td><div id="smalltab_container"></div></td></tr></table>
	<div class="smalltab_line"></div>
	<div class="div_clear" style="height:10px;"></div>
	<form id="articleform" method="POST" onsubmit="return checkAllAction()" action="picture_ajax.php?action=savepicture">
	<div id="t1">
		<table class="table_1">
			<tr><td class="td_0" style="width:400px;">{$_AL['picture.name']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><input type="hidden" name="doaction" id="doaction" value="{$action}" /><input type="hidden" name="id" id="id" value="{$id}" /><input type="text"  value="{$row['name']}" name="name" id="name"  class="text_css" style="width:380px;" /></td><td class="td_2"></td></tr>
			<tr style="display:none;"><td class="td_0">{$_AL['picture.url']}:</td><td class=""></td></tr>
			<tr style="display:none;"><td class="td_1"><input type="text"  value="{$row['alias']}" name="alias" id="alias"  class="text_css" style="width:380px;" /></td><td class="td_2">{$_AL['picture.url.remark']}</td></tr>
			<tr><td class="td_0">{$_AL['picture.serialnum']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><input type="text"  value="{$row['serialnum']}" name="serialnum" id="serialnum"  class="text_css" style="width:380px;" /></td><td class="td_2"></td></tr>
			<tr><td class="td_0">{$_AL['picture.images']}</td><td class=""><input type='button' id='addimgnum' class='addimgbtn' value='增加图片' onclick="addmoreimg();" ></td></tr>
			<tr><td class="td_1"><div id="img_container" style="width:420px;height:70px;"><img src="images/loading.gif" /></div></td><td class="td_2">{$_AL['picture.images.remark']}</td></tr>
			<tr><td class="td_0">{$_AL['picture.store']}/{$_AL['picture.sold']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><input type="text"  value="{$row['store']}" name="store" id="store"  class="text_css" style="width:80px;" /> / <input type="text"  value="{$row['sold']}" name="sold" id="sold"  class="text_css" style="width:80px;" /></td><td class="td_2">{$_AL['picture.sold.remark']}</td></tr>
			<tr><td class="td_0">{$_AL['picture.price']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><input type="text"  value="{$row['price1']}" name="price1" id="price1"  class="text_css" /> {$cache_settings['cur']}</td><td class="td_2"></td></tr>
			<tr><td class="td_0">{$_AL['picture.level']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><select name="level" id="level"><option value="1">{$_AL['picture.levels'][0]}</option><option value="2">{$_AL['picture.levels'][1]}</option><option value="3">{$_AL['picture.levels'][2]}</option><option value="4">{$_AL['picture.levels'][3]}</option><option value="5">{$_AL['picture.levels'][4]}</option></select></td><td class="td_2"></td></tr>
			<tr><td class="td_0">{$_AL['picture.type']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><select name="type" id="type"><option value="0">{$_AL['picture.types'][0]}</option><option value="1">{$_AL['picture.types'][1]}</option><option value="2">{$_AL['picture.types'][2]}</option></select></td><td class="td_2"></td></tr>
			<tr><td class="td_0">{$_AL['picture.procate']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><select name="cid" id="cid">{$cache_procates_option}</select></td><td class="td_2"></td></tr>
			<tr><td class="td_0">{$_AL['all.seotitle']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><input type="text" style="width:380px;" value="{$row['seotitle']}" name="seotitle" id="seotitle" class="text_css" /></td><td class="td_2">{$_AL['all.seotitle.remark']}</td></tr>
			<tr><td class="td_0">{$_AL['all.metakey']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><textarea style="height:60px;width:380px;" name="metakeywords" id="metakeywords">{$row['metakeywords']}</textarea></td><td class="td_2">{$_AL['all.metakey.remark']}</td></tr>
			<tr><td class="td_0">{$_AL['all.metadesc']}:</td><td class=""></td></tr>
			<tr><td class="td_1"><textarea style="height:60px;width:380px;" name="metadesc" id="metadesc">{$row['metadesc']}</textarea></td><td class="td_2">{$_AL['all.metadesc.remark']}</td></tr>
		</table>
		<table class="table_1">
			<tr><td class="td_0">{$_AL['picture.content']}:</td><td class=""></td></tr>
			<tr><td class="td_1" style='width:800px;'>
				<textarea name="content" id="content" style="width: 800px; height: 400px;">{$row['content']}</textarea>
			</td><td class="td_2"></td></tr>
			<tr><td class="td_3"><input class="button_css" type="submit" value="  {$_AL['all.submit']}  " /></td><td class=""></td></tr>
		</table>
	</div>
	</form>
	<div class="div_clear" style="height:30px;"></div>
	<script>
		KE.show({id : 'content'});
	</script>
	<script>
	var smallNowTab;
	var pt = new Tabs();
	var doaction="{$action}";
	pt.classpre="smalltab_";
	pt.container = "smalltab_container";
	if(doaction=="add"){
		pt.createTab("t1","{$_AL['picture.add']}","",true,"n");
	}else{
		pt.createTab("t1","{$_AL['picture.edit']}","",true,"n");
	}
	pt.init = function(){
		smallNowTab = pt.nowTab;
	};
	pt.onclick = function(){
		smallNowTab = pt.nowTab;
	};		
	pt.initTab();
	pt.clickNowTab();
	
	var curImgIndex=1;
	var imgArr=[0{$picjscode}];
	var type="{$row['type']}";
	var level="{$row['level']}";
	var cid="{$cid}";
	var id="{$id}";
	setSelect("cid",cid);
	setSelect("type",type);
	setSelect("level",level);
	
	function checkAllAction(){
		return true;
	}

	function openUploadAttach(handle1,handle2){
		window.handle1=handle1; window.handle2=handle2;
		popwin.showURL("{$_AL['picture.upfile']}",'../inc/attachment/index.php',800,500);
	}

	function insertAttachment(fileid, filename, isimg){
		isimg=parseInt(isimg);
		if(window.handle1=='propics'){
			if(isimg==1&&isImg(filename)){
				E("imginput_"+curImgIndex).value=fileid;
				E("imgdiv_"+curImgIndex).innerHTML="<img src='attachment.php?id="+fileid+"' border=0 />";
				popwin.close();
			}else{
				alert("{$_AL['all.choose.image']}");
			}
		}else if(window.handle1=='editor'){
			if(isimg==1&&isImg(filename)){
				KE.insertHtml('content','<img src="attachment.php?id='+fileid+'" />');
			}else{
				KE.insertHtml('content','[file='+fileid+']'+filename+'[/file]');
			}
			popwin.close();
		}
	}

	function createImg(){
		var num=imgArr.length;
		num=num>5?num:6;
		for(var i=1;i<num;i++){
			var inp=document.createElement("input");
			inp.id="imginput_"+i;
			inp.name="imginput[]";
			inp.type='hidden';
			var outobj=document.createElement("div");
			outobj.className="uploaddiv";
			var obj=document.createElement("div");
			obj.id="imgdiv_"+i;
			obj.title="{$_AL['all.click2selimage']}";
			obj.className="uploadimgdiv";
			obj.onclick=(function(n){
				return function(){
					curImgIndex=n;
					openUploadAttach('propics');
				}
			})(i);
			var dellink=document.createElement("a");
			dellink.innerHTML='X';
			dellink.title="{$_AL['all.clear.img']}";
			dellink.href="javascript:cleanImg("+i+")";
			outobj.appendChild(obj);
			outobj.appendChild(dellink);
			E("img_container").appendChild(inp);
			E("img_container").appendChild(outobj);
			if(imgArr[i]>0){
				E("imginput_"+i).value=imgArr[i];
				E("imgdiv_"+i).innerHTML="<img src='attachment.php?id="+imgArr[i]+"' border=0 />";
			}
		}
	}
    function addmoreimg(){
		var num=$("#img_container .uploaddiv").size();
	
		for(var i=num;i<(num+5);i++){
			var inp=document.createElement("input");
			inp.id="imginput_"+i;
			inp.name="imginput[]";
			inp.type='hidden';
			var outobj=document.createElement("div");
			outobj.className="uploaddiv";
			var obj=document.createElement("div");
			obj.id="imgdiv_"+i;
			obj.title="{$_AL['all.click2selimage']}";
			obj.className="uploadimgdiv";
			obj.onclick=(function(n){
				return function(){
					curImgIndex=n;
					openUploadAttach('propics');
				}
			})(i);
			var dellink=document.createElement("a");
			dellink.innerHTML='X';
			dellink.title="{$_AL['all.clear.img']}";
			dellink.href="javascript:cleanImg("+i+")";
			outobj.appendChild(obj);
			outobj.appendChild(dellink);
			E("img_container").appendChild(inp);
			E("img_container").appendChild(outobj);
			if(imgArr[i]>0){
				E("imginput_"+i).value=imgArr[i];
				E("imgdiv_"+i).innerHTML="<img src='attachment.php?id="+imgArr[i]+"' border=0 />";
			}
		}
	}
	function cleanImg(n){
		E("imginput_"+n).value="0";
		E("imgdiv_"+n).innerHTML="";
	}

	function InitPage(){
		E("img_container").innerHTML="";
		createImg();
	}
	//window.onload = InitPage;
	InitPage();
	
	</script>
EOT;

	
	break;
	/************************************** add edit END ************************************************/
	
	/************************************** list BEGIN ************************************************/
	case "list":
echo <<<EOT
	<table class="settop"><tr><td class="settop_left"><img src="../language/{$cache_langs[$_SYS['alangid']]['directory']}/flag.gif" title="{$effect_lang}" /></td><td><div id="smalltab_container"></div></td></tr></table>
	<div class="smalltab_line"></div>
	<div id="t1">
EOT;
	{
	 	$dwidth=array(0,35,45,340,100,170,70,70,130,60);
		$protype=$_AL['picture.types'];
		$protypecolor=array('#333','#36c','#f30');
		$cond="langid={$_SYS['alangid']}";
		$keyword=trim($_GET['k']);
		$orderby=$_GET['orderby'];
		$orderby=empty($orderby)?"ordernum,id":$orderby;
		$orderbystr='';
		$keyword=str_replace("*","%",$keyword);
		if(!empty($keyword)){
			$cond.=" and (name like '%{$keyword}%' or  content like '%{$keyword}%')";
		}
		$cid=intval($_GET['cid']);
		if(!empty($cid)){
			$cond.=" and cid={$cid}";
		}
		$type=-1;
		if($_GET['type']==''){
			$type=-1;
		}else{
			$type=intval($_GET['type']);
		}
		if($type>-1){
			$cond.=" and type={$type}";
		}
		if( in_array( $orderby, array('ordernum,id','posttime','hits','price1','level')) ){
			$orderbystr=$orderby.' desc';
		}
		$curPage = intval($_GET["page"]);
		$pager = new Pager();
		$pager->init(15,$curPage,"admin.php?inc=picture&action=list&k={$keyword}&cid={$cid}&type={$type}&orderby={$orderby}&page={page}");
		$rows = $pager->queryRows($db,"picture", $cond , "*",$orderbystr);
		$recstr=_LANG($_AL['all.totalrecords'], array($pager->recordNum));
		
echo <<<EOT
	<div class="div_clear" style="height:10px;"></div>
	<div class="tips_1">
<select id="cid"><option value="0">{$_AL['picture.choosecate']}</option>{$cache_procates_option}</select>
{$_AL['all.keyword']}: <input class="text_css" type="text" size="20" value="{$keyword}" id="keyword" />
<select id="orderby"><option value="ordernum,id">{$_AL['all.orderby']}</option><option value="posttime">{$_AL['all.posttime']}</option><option value="hits">{$_AL['all.hits']}</option><option value="price1">{$_AL['picture.price']}</option><option value="level">{$_AL['picture.level']}</option></select>
<select id="type"><option value="-1">{$_AL['all.property']}</option><option value="1">{$_AL['picture.types'][1]}</option><option value="2">{$_AL['picture.types'][2]}</option></select>
<input class="button_css" type="button" value="  {$_AL['all.search']}  " onclick="searchpicture()" />
&nbsp;&nbsp;&nbsp;{$recstr}</div>
	<table class="table_1" width="100%">
		<tr><td class="td_6"><a class="td_5_1a" href="admin.php?inc=picture&action=add"><img src="images/ico_add.gif" border="0" /> {$_AL['picture.add']}</a></td></tr>
	</table>

EOT;
	echo("<form id=\"pictureform\" onsubmit=\"return false;\">");
	echo("<table class=\"table_1\" width=\"100%\">");
	echo("<tr style=\"font-weight:bold;color:#333333;\"><td class=\"row_0\">".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[1]}px;\">{$_AL['all.select']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[2]}px;\">{$_AL['picture.order']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[3]}px; padding-right:5px;\">{$_AL['picture.name']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[4]}px;\">{$_AL['picture.price']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[5]}px;\">{$_AL['picture.procate']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[6]}px;\">{$_AL['picture.type']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[7]}px;\">{$_AL['all.hits']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[8]}px;\">{$_AL['all.updatetime']}</div>".
		"<div class=\"rowdiv_0\" style=\"width:{$dwidth[9]}px;\">{$_AL['all.control']}</div>".
		"");
	$tabindex=1000;
	for($i=0;$i<count($rows);$i++){
		$tabindex++;
		$row=$rows[$i];
		$row['posttime']=getDateStr($row['posttime']);
		$row['name']=htmlFilter($row['name']);
		$row['price1']=number_format($row['price1'],2);
		$row['username']=htmlFilter($row['username']);
		$checkboxstr="<input type=\"checkbox\" value=\"{$row['id']}\" name=\"aids[]\" class=\"checkbox_css\" />";

		echo("<tr><td class=\"row_0\" style=\"line-height:150%;\">".
			"<div class='rowdiv_0' style='width:{$dwidth[1]}px;'>{$checkboxstr}</div>".
			"<div class='rowdiv_0' style='width:{$dwidth[2]}px;'><input type=\"text\" size=\"2\" value=\"{$row[ordernum]}\" name=\"ordernum[{$row['id']}]\" tabIndex=\"{$tabindex}\" class=\"text_css\" /></div>".
			"<div class='rowdiv_0' style='width:{$dwidth[3]}px; padding-right:5px;'><a href=\"../product.php?id={$row['id']}\" target=\"_blank\">{$row['name']}</a>&nbsp;</div>".
			"<div class='rowdiv_0' style='width:{$dwidth[4]}px;'><span class=\"time\" style='font-weight:bold;'>{$cache_settings['cur']}{$row['price1']}</span></div>".
			"<div class='rowdiv_0' style='width:{$dwidth[5]}px;'>{$cache_procates[$row['cid']]['title']}&nbsp;</div>".
			"<div class='rowdiv_0' style='width:{$dwidth[6]}px;'><span style='color:{$protypecolor[$row['type']]}'>{$protype[$row['type']]}</span></div>".
			"<div class='rowdiv_0' style='width:{$dwidth[7]}px;'><span class='time'>{$row['hits']}</span></div>".
			"<div class='rowdiv_0' style='width:{$dwidth[8]}px;'><span class='time'>{$row['posttime']}</span></div>".				
			"<div class='rowdiv_0' style='width:{$dwidth[9]}px;'><a href=\"admin.php?inc=picture&action=edit&id={$row['id']}\">{$_AL['all.edit']}</a></div>".
			"");				
	}
	echo("</table>");
	echo("<table width=100%><tr><td><input type=\"checkbox\" onclick=\"selectAll('pictureform',this.checked)\" class=\"checkbox_css\" /> {$_AL['all.selectall']} &nbsp;&nbsp;<input type=\"button\" class=\"button_css\" value=\" {$_AL['all.deletesel']} \" onclick=\"ajax_dopicture_yn()\" /> <input type=\"button\" class=\"button_css\" value=\" {$_AL['picture.saveorder']} \" onclick=\"ajax_dopictureorder()\" /></td><td><div class='pagestrdiv'>{$pager->getPageStr()}</div></td></tr></table>");
	echo("</form>");
 	}
echo <<<EOT
	</div>
	<div id="t2"></div>
	<div id="t3"></div>
	<div class="div_clear" style="height:30px;"></div>
<script>
var smallNowTab;
var pt = new Tabs();
pt.classpre="smalltab_";
pt.container = "smalltab_container";
pt.createTab("t1","{$_AL['picture.list']}","",true,"n");
pt.init = function(){
	smallNowTab = pt.nowTab;
};
pt.onclick = function(){
	smallNowTab = pt.nowTab;
};		
pt.initTab();
pt.clickNowTab();

function ajax_dopicture_yn(){
	var btns=[
		{value:" {$_AL['all.confirm']} ",onclick:"mainifm.ajax_dopicture()",focus:true},
		{value:" {$_AL['all.cancel']} ",onclick:"popwin.close()"}
	];
	popwin.showDialog(3,"{$_AL['all.confirm']}","{$_AL['picture.del.warning']}",btns,380,130);
}


function ajax_dopicture(){
	popwin.loading();
	ajaxPost("pictureform","picture_ajax.php?action=dopicture",ajax_dopicture_callback);
}
function ajax_dopicture_callback(data){
	var btns=[{value:" {$_AL['all.ok']} ",onclick:"popwin.close();mainifm.location.reload();",focus:true}];
	popwin.loaded();
	if(isSucceed(data)){
		popwin.showDialog(1,"{$_AL['all.con.succeed']}","{$_AL['picture.del.succeed']}",btns,280,130);
	}else{
		popwin.showDialog(0,"{$_AL['all.con.failed']}", data,btns,280,130);
	}
}

function ajax_dopictureorder(){
	popwin.loading();
	ajaxPost("pictureform","picture_ajax.php?action=dopictureorder",ajax_dopictureorder_callback);
}
function ajax_dopictureorder_callback(data){
	var btns=[{value:" {$_AL['all.ok']} ",onclick:"popwin.close();mainifm.location.reload();",focus:true}];
	popwin.loaded();
	if(isSucceed(data)){
		popwin.showDialog(1,"{$_AL['all.con.succeed']}","{$_AL['picture.saveorder.succeed']}",btns,280,130);
	}else{
		popwin.showDialog(0,"{$_AL['all.con.failed']}", data,btns,280,130);
	}
}


function searchpicture(){
	var loc = "admin.php?inc=picture&action=list&cid="+E("cid").value+"&k="+urlEncode(E("keyword").value)+"&orderby="+E("orderby").value+"&type="+E("type").value;
	reloadSelf(loc);
}

function PageInit(){
	if(E("keyword")){E("keyword").onkeyup = function(event){checkKeyPressEnter(event);};}
	var cid="{$cid}";
	var orderby="{$orderby}";
	var type="{$type}";
	setSelect("cid",cid);
	setSelect("orderby",orderby);
	setSelect("type",type);
}
function checkKeyPressEnter(eventobject){
	var eve=eventobject||window.event;
	if(eve.keyCode==13) {
		searchpicture();
	}
}
window.onload=PageInit;
</script>
EOT;
	break;
	/**************************************  list END ************************************************/

}	
?>