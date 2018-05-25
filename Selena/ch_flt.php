<link href="selena.css" rel="stylesheet" type="text/css" />
<?php
require_once("for_form.php"); 
check_valid_user();
$conn_db = db_connect();
  if (!$conn_db) return 0;
    // вот это нужно что бы браузер не кешировал страницу...
    header("ETag: PUB" . time());
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
    header("Pragma: no-cache");
    header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
    session_cache_limiter("nocache"); php?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php	if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1") { $rem_addr="http://selena/"; } else { $rem_addr="https://10.1.2.22/"; }
	global $totalRows_customer;
	if (isset($_REQUEST ["k"])) { //st
		$k = $_REQUEST ["k"];		//	$st = $_REQUEST ["st"];
		if ($fl==0) { 
			$totalRows_customer=0;
			$id_Podjezd = 0;
		}
	} else {
		$k = $GLOBALS['k'];
		$fl = $GLOBALS ["fl"];
		$Town = $GLOBALS ["Town"];
		$name_street = $GLOBALS ["name_street"];
		$id_Podjezd = $GLOBALS ["id_Podjezd"];
		 php?>
		<span COLOR="#FF0000" class="quote"><?php echo "г.$Town ул.$name_street д.$Num_build кв.$fl";  php?> </span>
		<?php
	}
	$Nic = (isset($_REQUEST ["Nic"]))? $_REQUEST ["Nic"]:"";
	$new = (isset($_REQUEST ["new"]))? $_REQUEST ["new"]:"";
	$not_new_adr = !(isset($_REQUEST ["menu"]) && (!$_REQUEST ["menu"]=="new_adr"));
	$tp = (isset($_REQUEST['tp']))? $_REQUEST['tp']:(isset($GLOBALS['tp']))? $GLOBALS['tp']:"9";
//	$tn = (isset($GLOBALS['tn'])) ? $GLOBALS['tn'] :(isset($_REQUEST['tn']))?$_REQUEST['tn']."&":"";	///*"tn=".*/
	if (isset($GLOBALS['tn'])) {
		$tn = $GLOBALS['tn'];
	} else {
		$tn = (isset($_REQUEST['tn']))? "tn=".$_REQUEST['tn']."&":"";
	}

//	$par = $tn.$tp.$trg.$new_p.$menu_p;
	$GLOBALS['tp'] = $tp;
	$ToDay = date("Y-m-d");
	$ar_s = array(''=>'не уст.', 0=>'не уст.', 1=>'подключ.', 2=>'замороз.', 3=>'расторг');
	$m_sh = Array(1=>"января",2=>"февраля",3=>"марта",4=>"апреля",5=>"мая",6=>"июня",7=>"июля",8=>"августа",9=>"сентября",10=>"октября",11=>"ноября",12=>"декабря");
	$m = Array(1=>"янв",2=>"фев",3=>"мар",4=>"апр",5=>"мая",6=>"июн",7=>"июл",8=>"авг",9=>"сен",10=>"окт",11=>"ноя",12=>"дек");
	$Bill_Dog_New = get_Bill_Dog();
	//echo (isset($_REQUEST ["menu"])?"menu:".$_REQUEST ["menu"]:"#");
	if (isset($GLOBALS['menu'])) $p1 = $GLOBALS['menu']; else $p1 = "no menu";
	$q_podjezd = "SELECT * FROM v_podjezd where id_korp=$k and FirstFlat<=$fl and LastFlat>=$fl";

	$s_podjezd =  mysql_query($q_podjezd) or die(mysql_error());
	$row_podjezd = mysql_fetch_assoc($s_podjezd);
	if ($totalRows_podjezd = mysql_num_rows($s_podjezd)==0) { 
		echo "<br>Ошибка в справочнике адресов (таблица зданий). Не найден подъезд с кв $fl, id_korp=$k.";
		return;
	}
	$RegionName = $row_podjezd['RegionName'];
	$name_street = $row_podjezd["name_street"];
	$Num_build = $row_podjezd['Num_build'];
	$id_Podjezd = $row_podjezd['id_Podjezd'];
	$Podjezd = $row_podjezd['Podjezd'];
	$Korpus = $row_podjezd['Korpus'];
	$id_p = $id_Podjezd;

/* $Bill_Dog = 0;
 if (isset($Podjezd)) { */
/* if (!$not_new_adr) { //$Nic!=""
	$q_customer = "SELECT * FROM v_customer where Nic='$Nic'"; 
 } else*/ $q_customer = "SELECT * FROM v_customer where ".($not_new_adr?"id_Podjezd=$id_Podjezd and flat =$fl order by inet":"Nic='$Nic'");

	$s_customer =  mysql_query($q_customer) or die($s_customer.mysql_error());
	$row_customer = mysql_fetch_array($s_customer, MYSQL_ASSOC);
	$totalRows_customer = mysql_num_rows($s_customer);
	$new_Cod = check_flat($id_p, $fl);
	$Cod_flat = $new_Cod ? 0 /*new_Cod_flat()*/ : get_Cod_flat($id_p, $fl);		//$row_customer['Cod_flat'];		//($row_customer['Cod_flat'] == 0)
	$GLOBALS['new_Cod'] = $new_Cod ? 1 : 0;			//($row_customer['Cod_flat'] == 0)

	echo '<input name="h_st" type="hidden" value="'.$name_street.'" />';//st
  	echo '<input name="h_nb" type="hidden" value="'.$Num_build.'" />';
  	echo '<input name="h_fl" type="hidden" value="'.$fl.'" />';
  	echo '<input name="h_id_Podjezd'.$new.'" type="hidden" value="'.$id_Podjezd.'" />';//
  	echo '<input name="h_kr" type="hidden" value="'.$Korpus.'" />';
	echo '<input name="h_Rows" type="hidden" value="'.$totalRows_customer.'" />';
	echo (($Korpus>0)?'корп.'.$Korpus:'').'</b> пд.<u><b>&nbsp;'.$Podjezd.'&nbsp;</b></u>';
	echo 'эт.<input name="floor'.$new.'" type="text" id="floor" value="'.$row_customer['floor'].'" size="1" />';
	echo ', р-он <FONT class="quote стиль1"> <u>&nbsp;'.$RegionName.'&nbsp;</u></FONT>&nbsp;';
	//<tr><td></td></tr>			//($row_customer['Cod_flat']==0)
	echo '<b><FONT '.($row_podjezd['auto']==0? 'COLOR="#FF0000"> МОНТ.':'> авто').' </FONT></b>';
	echo '<b>Код адреса: <FONT '.($new_Cod? 'COLOR="#FF0000">'.
		/*$Cod_flat.*/' новый':'>'.$Cod_flat).'.</FONT> Договоров - '.$totalRows_customer.'</b>';

	if ($totalRows_customer > 0 and $_REQUEST ["menu"] != "new_adr") { php?>
		<button name="B_reload" type=button onClick="clr_adress();chk_adress();">
        					<img src="reload.png" align=middle alt="Обнови"></button>
<?php	}
if ($tn==2) { // ### *** ### *** ### ***	строка для отладки	 ### *** ### *** ### ***  php?>
	<input onblur="eval(this.value)" size="10"/><?php }

	echo "<input name='h_new_Cod' type='hidden' value='".( $new_Cod? 1 : 0)."' />";	//($totalRows_customer == 0 || $row_customer['Cod_flat']==0)
	echo "<input name='h_Cod_flat{$new}' type='hidden' value=$Cod_flat />";
	echo "<input name='h_Conn' type='hidden' value='".(($totalRows_customer == 0) ? 0 : 1)."' />";
	//	echo '<b><font class="quote"> </font>ул.'.$row_customer['name_street'].' д.'.$row_customer['Num_build'];
	if ($_REQUEST ["menu"] == "new_adr" and !isset($_REQUEST ["Nic"])) {  php?> 
		<input name="B_edt_cust" type="button" onclick="set_new_adr();" value="Перевести на этот адрес" /><?php //';
	}
		
	if ($totalRows_customer > 0) {
//			$GLOBALS['a_cus'][$row_customer['Bill_Dog']]['rad'] = isRadreply($row_customer['mac']);
//$conn_db = db_connect();
//			$Bill_Dog = $row_customer['Bill_Dog'];  php?>
	<table align="center" border=0 width=100%>
  		<tr>
  		  <?php	//	print_r($row_customer);	$s_onchange='"clr_adress(); show_cust('.$Bill_Dog.','.$id_p.','.$fl.'); f_btn();"';
		$s_onchange=$not_new_adr?'onchange="clr_adress(); chk_adress();"':''; 
/*	<td  rowspan="2"><select name="tabl_cust" id="tabl_cust" class="headText" size="<?php echo $totalRows_customer  php?>"<?php echo ($not_new_adr?' onchange='.$s_onchange:'') php?> > <?php	*/  php?>
  		  <td ><!-- rowspan="2"-->
  <?php if ($_REQUEST ["menu"] != "new_adr") {  php?>
    <select name="tabl_cust" id="tabl_cust" class="headText" size="<?php echo $totalRows_customer;  php?>"	onchange="clr_adress(); chk_adress();"<?php //echo $s_onchange  php?> >
  <?php }  php?>  
<?php		//,this.value //,document.getElementById(&quot;rbtn_cust&quot;).value
		$Bill_Dog1 = $row_customer['Bill_Dog'];
		$inet1 = $row_customer['inet'];
		$ab_numbs = 0;
		$tot_ab = 0;
		$ab_sum = $row_customer['ab_sum']>0?$row_customer['ab_sum']:0;
		$i=0;
		do {
			$i +=1;
			$Bill_Dog = $row_customer['Bill_Dog'];
//			$F = ($tp<3?$row_customer['Fam']:chr(ord(($row_customer['Fam'])).'.');
			$Fio = $row_customer['Fam'].' '.$row_customer['Name'].' '.$row_customer['Father'];
//			.' '.($tp<3?$row_customer['Fam']:substr($row_customer['Fam'],1,1).'.', ENT_NOQUOTES,"UTF-8");
			$Y = date("Y", strtotime($row_customer["Date_start_st"]));
			if ($ab_sum==0) { if (!$row_customer['inet']) { $ab_sum = $row_customer['ab_sum']; }}
			$GLOBALS['a_cus'][$Bill_Dog] = $row_customer;
			$GLOBALS['a_cus'][$Bill_Dog]['rad'] = $row_customer['mac']!=''?isRadreply($row_customer['mac']):0;
$conn_db = db_connect();
			$GLOBALS['a_cus'][$Bill_Dog]['dolg'] = is_off_dolg($Bill_Dog) && $ab_sum>0;
			$ab_numbs = $ab_numbs + ($row_customer['inet'] || $GLOBALS['a_cus'][$Bill_Dog]['dolg']?0:1);
			$tot_ab = $tot_ab + ($row_customer['inet']?0:1);
		  	echo $_REQUEST ["menu"] == "new_adr"?" $i ":('<option value='.$Bill_Dog.(($i ==1)?" selected":""));
			$s_1 = 'Дог.№'.$Bill_Dog.($row_customer['inet']?"(инет)":"").', '.$ar_s[$row_customer['state']].' '.
				(!empty($row_customer['Date_end_st'])?'по '.date("j", strtotime($row_customer['Date_end_st'])).$m[date("n", strtotime($row_customer['Date_end_st']))].(date("Y")==$Y?'':''.$Y.'г.'):
					($GLOBALS['a_cus'][$Bill_Dog]['dolg']?' за долг':'')).
				', ник: '.$row_customer['Nic'].'&#009;: '.$Fio; 
			echo $_REQUEST ["menu"] == "new_adr"?$s_1.'</br>' : ' >'.$s_1.'</option>';
		} while ($row_customer = mysql_fetch_array($s_customer, MYSQL_ASSOC));
		//echo '  php?>
  <?php if ($_REQUEST ["menu"] != "new_adr") {  php?>
		</select>
  <?php } else { return; }  php?>  
<?php		echo "<input name='h_ab_numbs' value=$ab_numbs type='hidden' />";
		echo "<input name='h_tot_ab' value=$tot_ab type='hidden' />"; 	 php?>
    </td><!--!!!</tr></table>-->
<?php //!	} else
if (isset($_REQUEST ["Nic"])||$_REQUEST ["menu"]=="show_err"){//<button id="sel_Bill" type="button">уст</button>	 php?>
    <!--!!!<table><tr>-->
	<td><div id="d_show_err"<?php /* php?> style="display:none"<?php */ php?>><table><tr><td>
<?php		$noNic = !isset($_REQUEST ["Nic"]);
		foreach ($a_cus as $cust_row) { php?>
       <!--     <button name='B_chng' type='button' onClick='alert(document.forms.ulaForm.hNic.value)' >       -->
			<label><input name="sel_Dog" type="radio" <?php if(!$cust_row['inet']){ php?>disabled="disabled"<?php } php?>
                	value="<?php echo $cust_row['Bill_Dog'] php?>"
                    onchange="document.getElementById('b_chng').innerHTML='<button name=\'B_chng\' type=\'button\' onClick=\'if(confirm(&quot;Вы согласны выполнить следущее: В абон учётке Ник <?php echo $cust_row["Nic"] php?> будет заменён на <?php if ($noNic) { php?>'+document.forms.ulaForm.hNic.value+'<?php } else { echo $_REQUEST["Nic"];} php?>, в таблице интернет логинов для Логина <?php echo $cust_row["Nic"] php?> будет изменён Ник на <?php if ($noNic) { php?>'+document.forms.ulaForm.hNic.value+'<?php } else { echo $_REQUEST["Nic"];} php?>. Вы уверены? &quot;)){ch_param(&quot;do_chng_nic&quot;,&quot;<?php echo "tn=".$tn."&Bill_Dog=".$cust_row['Bill_Dog']."&newNic=" php?><?php if($noNic) { php?>'+document.forms.ulaForm.hNic.value+'<?php } else { echo $_REQUEST["Nic"];} php?><?php echo '&oldNic='.$cust_row["Nic"].'&TabNum='  php?>'+document.forms.ulaForm.TabNum.value+'&quot;, &quot;new_adr<?php if ($noNic) { php?>'+document.forms.ulaForm.hNic.value+'<?php } else { echo $_REQUEST["Nic"];} php?>&quot;);}   \'><b><?php if ($noNic) { php?>'+document.forms.ulaForm.hNic.value+'<?php } else { echo $_REQUEST ["Nic"];} php?></b> -> Аб.ник<br><b><?php echo $cust_row["Nic"] php?></b> -> Инет.логин</button>'" />
					Дог.№ <?php echo $cust_row['Bill_Dog'] php?>
              </label><br />
<?php		}	//foreach php?></td>
		<td><div id="b_chng"><?php if(!$noNic){echo "{$_REQUEST['Nic']} -> Абон.ник<br>{$cust_row['Nic']} -> Инет.логин";} php?></div>
		<!--</td> --></tr></table>
</div></td>
		<!--</tr></table>-->
<?php		}	//! php?>
<?php		if ($_REQUEST ["menu"] != "show_err" and !($_REQUEST ["menu"] == "new_adr" and !isset($_REQUEST ["Nic"])) ) {  php?>
    <!--<td><div>-->
    <!--!!!<table><tr>-->
<?php /* php?><b><font style="font-size:14px">&nbsp;
	<label id="lrec"><input name="B_frm" type="radio" onclick="f_frm(this.value);" value="rec"/> Сеть </label>&nbsp;
	<label id="lpay"><input name="B_frm" type="radio" onclick="f_frm(this.value);" value="pay"/> Финансы </label>&nbsp;
	<label id="lnot"><input name="B_frm" type="radio" onclick="f_frm(this.value);" value="not"/> Заявка на ремонт </label>&nbsp;
</font></b><?php */ php?>
<?php	$nodis = 'style="display:none"';
	$div_b = '';
	$td_b  = 'style="border:solid #009"';
	$menu = $_REQUEST ["menu"]; php?>
    <?php /* php?>chk_adress();shw('nNic');if(nNic" <?php if (!($m_pay && $a_cus[$Bill_Dog]['inet']==1)) { echo 'style="display:none"'; } php?><?php */ php?>
    <!--</tr><tr>-->
			<td bgcolor="#CCFFFF" id="_rec" align="center" <?php echo $menu!="recon"?"":'style="border:solid #CC00FF"' php?>>
            	<div id="L_rec" <?php echo $menu!="recon"?$nodis:$div_b php?>>
                	<b>Сеть</b>
<?php                    if ($totalRows_customer > 0) {  php?>
                        &nbsp;<button name="B_add_cust" type=button onClick="javascript:add_cust('<?php echo $Bill_Dog_New  php?>');">
                            <img src="ico_create.gif" align=middle alt="Доп.подкл."></button>&nbsp;
                        <button name="B_del_cust" type=button 
                        onClick="javascript:B_D=f_Bill_Dog();tn=<?php echo $tn php?>;if(confirm(&quot;Вы согласны удалить договор№&quot;+B_D+&quot; в архив? &quot;)){
                                    ch_param('do_del_cust','Bill_Dog='+B_D+'&tn='+tn,'tab_Cust');}"><img src="ico_delete.gif" align=middle alt="Удалить"></button>
<?php                     } php?>
                </div>
            	<div id="B_rec" <?php echo $menu=="recon"?$nodis:"" php?>>
            	<button name="B_rec" type=button
            		onClick="f = document.forms.ulaForm;f.Menu_Item.value='recon';shw('recon');
         	          	document.getElementById('_rec').style='border: solid #CC00FF';
                        document.getElementById('_not').style='border:';
                        document.getElementById('_pay').style='border:';
                        shw('L_rec');hid('B_rec');hid('L_pay');shw('B_pay');hid('L_not');shw('B_not');
                        shw('phn');shw('fio');shw('net');shw('w3');shw('nw3');shw('rec_itog');hid('noti2rep');
                        shw('mac');
                        hid('p_net');hid('sel');shw('net_tab');
                        if(val_nm(f_Bill_Dog(),'inet')){hid('w3');hid('fin');shw('nNic');} 
                        else {shw('w3');shw('fin');hid('nNic');}
                    "><!--shw('d_b_rec');hid('d_b_pay');-->
				<img src="network.png" alt="Подключение" /></button></div></td>
<!--			<td id="d_b_rec" bgcolor="#CCFFFF" <?php echo 1 or $menu!="recon"?$nodis:"" php?>>
            </td>
-->			<!--</tr><tr>-->
            <td bgcolor="#FFCC99" id="_pay" align="center" <?php echo $menu!="pay"?"":'style="border:solid #FF9999"' php?>>
            <div id="L_pay" <?php echo $menu!="pay"?$nodis:$div_b php?>>
              <table><tr>
           		<td><b>Фин</b></td>
        <?php /* php?>		<button name="B_print" type=button onClick="javascript:dogovor();"><img src="printer.gif" width="16" alt="Печать"></button><?php */ php?>
    <?php /* php?>			<button name="B_pays" type=button onClick="javascript:document.forms.ulaForm.Menu_Item.value='pay';ch('srch','menu=pay&tp=<?php echo $tp.($new_Cod?'&Bill_Dog='.$Bill_Dog1:'&Cod_flat='.$Cod_flat) php?>',0,'tab_Cust');">Финан</button><?php */ php?>
    <?php	//	} elseif ($_REQUEST ["menu"] == "pay") {	 php?>
            <?php /* php?>	<button name="B_pays" type=button onClick="document.forms.ulaForm.Menu_Item.value='recon';ch('srch','menu=recon&tp=<?php echo $tp php?>&Bill_Dog=<?php echo $Bill_Dog1 php?>',0,'tab_Cust');">Сеть</button><?php */ php?>
    <?php		if($tp==1 || $tn==6 || $tn==8) { // (!$inet1 && ($tn==2 || $tn==6))  php?>
                <td id="d_b_pay"><button name="B_dhd" type=button 
                        onClick="toggle('dhd');c=document.forms.ulaForm.B_dhd;c.caption=(c.caption=='>>')?'>>':'<'">▼</button>
                </td>
                <td><div id="dhd" style="display:none">
                    <table><tr><td><?php echo $Bill_Dog1 php?>:</td>
    <?php			if($inet1) { php?>
                    <td><div id="toab">
                        <button name="B_2ab" type=button onClick="javascript:document.forms.ulaForm.sBill_Dog.value=<?php echo "$Bill_Dog1;ch_param('toab','B=$Bill_Dog1" php?>','toab');">Аб.</button></div></td>
    <?php         } else {  php?>
                    <td><div id="otkat" style="background-color:#9FF">
                    &nbsp;<button name="B_otkat" type=button onClick="javascript:otkat()">Откт</button>&nbsp;</div></td>
                    <td><div id="toinet" style="background-color:#FCC"><button name="B_2inet" type=button onClick="javascript:f=document.forms.ulaForm;f.sBill_Dog.value=<?php echo $Bill_Dog1 php?>;ch_param('toinet','B=<?php echo $Bill_Dog1 php?>','toinet');setTimeout('f.sBill_Dog.onchange()', 500);">3w</button></div></td>
            <?php } // if($inet1)
            $d_test = strtotime ("2000-01-01");
            if ($GLOBALS['a_cus'][$Bill_Dog1]['state']==1 && (strtotime($GLOBALS['a_cus'][$Bill_Dog1]['Date_end_st']) < $d_test || strtotime($GLOBALS['a_cus'][$Bill_Dog1]['Date_pay']) < $d_test) ) { 
                $D_e = strtotime ($GLOBALS['a_cus'][$Bill_Dog1]['Date_end_st'])<$d_test?"de":"";
                $D_p = strtotime ($GLOBALS['a_cus'][$Bill_Dog1]['Date_pay'])<$d_test?"dp":"";
                if($D_e=="" || $D_p=="") {
     php?>        		<td><div id="d_cor" style="background-color:#F99"><button type=button onClick="javascript:ch_param('d_cor','B=<?php echo $Bill_Dog1."&d=".$D_e==""?"p":"e" php?>','d_cor');setTimeout('f.sBill_Dog.onchange()', 500);">Дата</button></div></td>
    <?php			}
            }	 php?></tr></table>
                </div><!-- dhd -->
    <?php		} // if $tp==1 || $tn==6 || $tn==8  php?>
        </td></tr></table>
            </div>
            <div id="B_pay" <?php echo $menu=="pay"?$nodis:""// php?>>
            	<button name="B_pay" type=button 
                    onClick="f = document.forms.ulaForm;f.Menu_Item.value='pay'; shw('recon');shw('fin');shw('net');
         	          	document.getElementById('_pay').style='border: solid #FF9999';
                        document.getElementById('_not').style='border:';
                        document.getElementById('_rec').style='border:';
                        hid('L_rec');shw('B_rec');shw('L_pay');hid('B_pay');hid('L_not');shw('B_not');
                        hid('phn');hid('fio');hid('net_tab');shw('p_net');hid('rec_itog');hid('noti2rep');
                        hid('mac');hid('nw3');
                        if(val_nm(f_Bill_Dog(),'inet')){hid('w3');shw('nNic');shw('it_inet');hid('sel'); }
                            else {shw('w3');shw('fin');hid('nNic');hid('it_inet');shw('sel'); }
                        "><!-- style="background-image:url(coins_16.png); background-position:center"shw('d_b_pay');hid('d_b_rec');-->
					<img src="coins_16.png" alt="Финансы"/></button>
          	</div>
          </td>
	<!--	  <td id="d_b_pay" bgcolor="#FFCC99" <?php echo $menu!="pay"?$nodis:"" php?>><div></div></td>-->
	<!--d_b_pay -->
			<!--</tr><tr>-->
            <td bgcolor="#99FFFF" id="_not" align="center" <?php echo $menu!="noti"?"":'style="border:solid #00FFFF"' php?> >
            <div id="L_not" <?php echo $menu!="noti"?$nodis:$div_b php?>><b>Ремонт</b></div>
            <div id="B_not" <?php echo $menu=="noti"?$nodis:"" php?>><button name="B_not" type=button 
            	onClick="f = document.forms.ulaForm;f.Menu_Item.value='noti'; hid('fin');
                   	document.getElementById('_not').style='border: solid #00FFFF';
                    document.getElementById('_rec').style='border:';
                    document.getElementById('_pay').style='border:';
                	hid('L_rec');shw('B_rec');hid('L_pay');shw('B_pay');shw('L_not');hid('B_not');
            		hid('phn');hid('fio');hid('net');hid('w3');hid('rec_itog');shw('noti2rep');
                    hid('sel');"><!--hid('d_b_pay');hid('d_b_rec');-->
            <img src="not_16.png" alt="Ремонт"/></button></div></td>
	</tr></table>
	<?php //';// valign="baseline" chk_adress(); hid('recon');
	 //!		if ($_REQUEST ["menu"] == "recon") {//
//			$GLOBALS['Bill_Dog_New'] = get_Bill_Dog();	.$GLOBALS['Bill_Dog_New']. form=document.forms[&quot;ulaForm&quot;]; 
//			echo //' <input name="B_edt_cust" type="button" onclick='.$s_onchange.' value="Показать" />';phone_Home=form.phone_Home.value; 
 php?>	
   <!-- </div></td></tr></table>-->
<?php	} //hid('B_pay');shw('B_rec'); php?>
<table><tr><td>
	<?php	// Заполняем массив данных
		foreach ($a_cus as $cust_row) {
			$id = $cust_row['Bill_Dog'];
			// Получаем все Логины для Ника
			$q_login = "SELECT Login,id_tarif3w,tarif3w_date,saldo,account FROM `logins` where Bill_Dog=".$id;	//Nic='".$cust_row['Nic']."'"
			$s_login =  mysql_query($q_login) or die(mysql_error());
			$totalRows_login = mysql_num_rows($s_login);
			$Logins[$cust_row['Bill_Dog']]["Logins"] = $totalRows_login;
			$inp_name = "h_".$cust_row['Bill_Dog']."_Logins";
		//	echo $inp_name."=".$val."</br>";
 php?>        <div id="d<?php echo $id php?>" style="display:none">d<?php echo $id php?></div>
			<input <?php echo "name='$inp_name' id='$inp_name' type='hidden' value='$totalRows_login'" php?> />
	<?php			if ($totalRows_login >0) {
				$j = 1;
				while ($row_login = mysql_fetch_array($s_login, MYSQL_ASSOC)) {
					$Logins[$cust_row['Bill_Dog']][$j] = $row_login;
					foreach ($row_login as $key => $val) {
						print_hid($id, $key.$j, $val);
					}
					$j++;
				}
			} else { // ### !!! не найдены логины
				$Logins[$cust_row['Bill_Dog']][1] = array('Login'=>'', 'id_tarif3w'=>'','tarif3w_date'=>'','saldo'=>'');
				$inp_name = "h_".$cust_row['Bill_Dog'];
				echo '<input name="'.$inp_name.'_Login1" id="'.$inp_name.'_Login1" value="" type="hidden" />';//
				echo '<input name="'.$inp_name.'_saldo1" id="'.$inp_name.'_saldo1" value="" type="hidden" />';//
			}
			foreach ($cust_row as $key => $val) { print_hid($id, $key, $val);	}
		}
		$GLOBALS['a_cus']['ab_sum'] = $ab_sum;
	//	print_r($a_cus);
		//echo '</br>print_arr(a_cus):</br>';
		//print_arr($a_cus);
		//echo '</br>print_r(Logins) ==========================================================</br>';
		//print_r($Logins);
		
		 php?></td></tr><?php

$frm_phn = $rem_addr."frm_phn.php?phone_Home=".$a_cus[$Bill_Dog1]['phone_Home']."&phone_Cell=".
	$a_cus[$Bill_Dog1]['phone_Cell']."&phone_Work=".$a_cus[$Bill_Dog1]['phone_Work'];

$frm_fio = $rem_addr."frm_fio.php?Fam=".$a_cus[$Bill_Dog1]['Fam']."&Name=".$a_cus[$Bill_Dog1]['Name'].
	"&Father=".$a_cus[$Bill_Dog1]['Father']."&Birthday=".$a_cus[$Bill_Dog1]['Birthday'].
	"&pasp_Ser=".$a_cus[$Bill_Dog1]['pasp_Ser']."&pasp_Num=".$a_cus[$Bill_Dog1]['pasp_Num'].
	"&pasp_Date=".$a_cus[$Bill_Dog1]['pasp_Date']."&pasp_Uvd=".$a_cus[$Bill_Dog1]['pasp_Uvd'].
	"&pasp_Adr=".$a_cus[$Bill_Dog1]['pasp_Adr']."&Comment=".$a_cus[$Bill_Dog1]['Comment'];

$frm_net = $rem_addr."frm_net.php?conn=".$a_cus[$Bill_Dog1]['conn']."&Bill_Dog=".$a_cus[$Bill_Dog1]['Bill_Dog'].
	"&id_tarifab=".$a_cus[$Bill_Dog1]['id_tarifab']."&tarifab_date=".$a_cus[$Bill_Dog1]['tarifab_date'].
	"&Nic=".$a_cus[$Bill_Dog1]['Nic'];

//$frm_w3 = $rem_addr."frm_w3.php?Login=".$Logins[$Bill_Dog1][1]['Login']."&From_Net=".$a_cus[$Bill_Dog1]['From_Net'].
//	"&id_tarif3w=".$Logins[$Bill_Dog1][1]['id_tarif3w']."&tarif3w_date=".$Logins[$Bill_Dog1][1]['tarif3w_date'];

		}	else	{ // ======   нет клиентов по адресу =====================================================<	
		if ($_REQUEST ["menu"] == "new_adr" and !isset($_REQUEST ["Nic"])) { return; }
		echo "<input name='h_ab_numbs' value=0 type='hidden' />";	//$ab_numbs
		echo "<input name='h_tot_ab' value=0 type='hidden' />"; 	//$tot_ab
			if ($GLOBALS['menu'] == 'pay') { return; }
			$frm_phn = $rem_addr."frm_phn.php?phone_Home=&phone_Cell=&phone_Work=";
			$frm_fio = $rem_addr."frm_fio.php?Fam=''&Name=''&Father=''&Birthday=''".
				"&pasp_Ser=''&pasp_Num=''&pasp_Date=''&pasp_Uvd=''&pasp_Adr=''&Comment=''";
			$frm_net = $rem_addr."frm_net.php?conn=''&Bill_Dog=".get_Bill_Dog()."&id_tarifab=''&tarifab_date=&Nic=''";
			$frm_w3 = $rem_addr."frm_w3.php?Login=&id_tarif3w=''&tarif3w_date=";
	}
 php?></table></FONT><?php
//	} else { }  нет такого адреса http://selena	
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

//$Bill_Dog_New = get_Bill_Dog();//""
if ($GLOBALS['totalRows_customer']>0) {
	$phone_Home = $a_cus[$Bill_Dog1]['phone_Home'];
	$phone_Cell = $a_cus[$Bill_Dog1]['phone_Cell'];
	$phone_Work = $a_cus[$Bill_Dog1]['phone_Work'];
	$Jur = $a_cus[$Bill_Dog1]['Jur'];

	$Fam = $a_cus[$Bill_Dog1]['Fam'];//$tp<3?$row_customer['Fam']:html_entity_decode(chr(ord($a_cus[$Bill_Dog1]['Fam'])).ord($a_cus[$Bill_Dog1]['Fam']).'.');//($tp<3?$row_customer['Fam']:(chr(ord($row_customer['Fam'])).'.'))
	$Name = $a_cus[$Bill_Dog1]['Name'];
	$Father = $a_cus[$Bill_Dog1]['Father'];
	$Birthday = $a_cus[$Bill_Dog1]['Birthday'];
	$pasp_Ser = $a_cus[$Bill_Dog1]['pasp_Ser'];
	$pasp_Num = $a_cus[$Bill_Dog1]['pasp_Num'];
	$pasp_Date = $a_cus[$Bill_Dog1]['pasp_Date'];
	$pasp_Uvd = $a_cus[$Bill_Dog1]['pasp_Uvd'];
	$pasp_Adr = $a_cus[$Bill_Dog1]['pasp_Adr'];
	$Comment = $a_cus[$Bill_Dog1]['Comment'];

	$conn = $a_cus[$Bill_Dog1]['conn']==''?0:$a_cus[$Bill_Dog1]['conn'];
	$Bill_Dog = $a_cus[$Bill_Dog1]['Bill_Dog'];
	$id_tarifab = $a_cus[$Bill_Dog1]['id_tarifab'];
	$tarifab_date = $a_cus[$Bill_Dog1]['tarifab_date'];
	$Nic = $a_cus[$Bill_Dog1]['Nic'];
	$Date_start_st = $a_cus[$Bill_Dog1]['Date_start_st'];
	$Date_end_st = $a_cus[$Bill_Dog1]['Date_end_st'];
	$state = $a_cus[$Bill_Dog1]['state'];
	$Date_pay = $a_cus[$Bill_Dog1]['Date_pay'];
	
	$rad = $a_cus[$Bill_Dog1]['rad'];
	$From_Net = $a_cus[$Bill_Dog1]['From_Net'];
//echo 	$Logins[$Bill_Dog1]['Logins'];//$n = >0?1:1
	$Login = $Logins[$Bill_Dog1][1]['Login'];
	$id_tarif3w = $Logins[$Bill_Dog1][1]['id_tarif3w'];
	$tarif3w_date = $Logins[$Bill_Dog1][1]['tarif3w_date'];
//	$ = $a_cus[$Bill_Dog1][''];

} else {
	$phone_Home = "";
	$phone_Cell = "";
	$phone_Work = "";
	$Jur = 0;

	$Fam = "";
	$Name = "";
	$Father = "";
	$Birthday = "";
	$pasp_Ser = "";
	$pasp_Num = "";
	$pasp_Date = "";
	$pasp_Uvd = "";
	$pasp_Adr = "";
	$Comment = "";

	$conn = 0; // Новое
	$Bill_Dog = "новый";	//get_Bill_Dog();//""
	$Bill_frend = "";
	$id_tarifab = 0; // Стандарт
	$tarifab_date = $ToDay;
	$Nic = "";
	$Date_start_st = $ToDay;
	$Date_end_st = "";
	$state = "";
	$Date_pay = "";

	$From_Net = "";
	$Login = "";
	$id_tarif3w = 0;
	$rad = 0;
	$tarif3w_date = $ToDay;
}
$disp_rec=$GLOBALS['menu'] == 'recon'?'':'style="display:none"';
$disp_pay=$GLOBALS['menu'] == 'pay'?'':'style="display:none"';
$disp_not=$GLOBALS['menu'] == 'noti'?'':'style="display:none"';
 php?><div id="recon">  <?php
/*if ($GLOBALS['menu'] == 'recon') {*/
	form_phn($phone_Home, $phone_Cell, $phone_Work, $Jur);
	form_fio($Fam,$Name,$Father,$Birthday,$pasp_Ser,$pasp_Num,$pasp_Date,$pasp_Uvd,$pasp_Adr,$Comment, isset($a_cus)?$a_cus:"");
	form_net($conn, $Bill_Dog, $id_tarifab, $tarifab_date, $Nic, $Date_start_st, $Date_end_st, $tp, $state, $Date_pay, $GLOBALS['totalRows_customer']>0?$a_cus:"");
	form_w3($From_Net, $Login, $id_tarif3w, $tarif3w_date, isset($a_cus)?$a_cus:"");
 php?>
<div id="rec_itog"<?php echo $disp_rec php?>>
<table width="800" border=0>
  <tr <?php if($GLOBALS['tp']>2) echo 'style="display:none"' php?>>
    <td width="160">Интернет: <input name="inet_Cpay" type="text" size="4" onchange="adj_CPay()" /> руб.</td>
    <td width="657" colspan="1" align="left">Итого: 
    	<input name="total_Cpay" type="text" size="4" readonly="true" /> руб.</td>
  </tr>
</table>
<table width=800 border=0>
  <tr>
<?php /* php?>	<td width="300" align="right">Заявка монтажнику: 
	<select name="mont" class='font8pt' id="mont" lang="ru" onchange='adjustmont();'>
<?php	$q_mont = "SELECT * FROM `personal` WHERE `id_TypePers`=4";
		$mont = mysql_query($q_mont) or die(mysql_error());
		$row_mont = mysql_fetch_assoc($mont);
		$totalRows_mont = mysql_num_rows($mont);
		echo "<option value=0>выбрать</option>";
		do { echo "<option value=".$row_mont['TabNum'].">".$row_mont['Fam']." (таб.№ ".$row_mont['TabNum'].")</option>"; }
			while ($row_mont = mysql_fetch_assoc($mont));
		$rows = mysql_num_rows($mont);
		if($rows > 0) { mysql_data_seek($mont, 0); $row_mont = mysqli_fetch_assoc($mont);  }  php?>
    </select>    </td>	<?php */ php?>
    <td align="left"><div id="d_mont"></div></td>
  </tr>
</table>
</div>
</div>
<?php
/*} elseif ($GLOBALS['menu'] == 'noti') { /******************************************************/
 php?><div id="noti2rep" <?php echo $menu=="noti"?"":'style="display:none"';//$nodis php?>><?php
//	form_phn($phone_Home, $phone_Cell, $phone_Work, $Jur);	
$_cus = $a_cus[$Bill_Dog1];
 php?>
<table width="800" border=0 style="background-color:#9FF">
  <tr>
    <td width="65"  align="left" valign="middle"><strong>телефоны:</strong></td>
	<td width="725" > 	
	   	<?php echo $_cus['phone_Home']==""?"":"домашний - <b>{$_cus['phone_Home']}</b>";  php?>
	   	<?php echo $_cus['phone_Cell']==""?"":"сотовый - <b>{$_cus['phone_Cell']}</b>";  php?>
	   	<?php echo $_cus['phone_Work']==""?"":" рабочий - <b>{$_cus['phone_Work']}</b>";  php?>
     </td>
  </tr>
	<td></td><td>Дополнительный - <input name="phone_Dop" size="15" /></td>
</table>
<table width="800" border=0>
  <tr>
    <td colspan="3" align="right">Неисправность</td>
    <td colspan="4"><input name="noti" type="text" size="70" onchange='chk_noti();' />
		<select name='_noti' id='_noti' onchange='document.forms["ulaForm"].noti.value=this.value;chk_noti();' class='headText' >
		  <option value="0" >-</option>
		  <option value="Нет связи" >Нет связи</option>
		  <option value="Обрыв линии" >Обрыв</option>
		  <option value="Неизвестная причина" >Неизвестная</option>
		</select>
	</td>
  </tr>
</table>
<table width="800" border=0>
  <tr>
<?php /* php?>	<td width="161" align="right">передать монтажнику: </td>
		<td width="62"><select name="mont" class='font8pt' id="mont" lang="ru" onchange='chk_noti();'>
	<?php	$q_mont = "SELECT * FROM `personal` WHERE `id_TypePers`=4";
			$mont = mysql_query($q_mont) or die(mysql_error());
			$row_mont = mysql_fetch_assoc($mont);
			$totalRows_mont = mysql_num_rows($mont);
		echo "<option value=0>выбрать</option>";
	do {
		echo "<option value=".$row_mont['TabNum'].">".$row_mont['Fam']." (таб.№ ".$row_mont['TabNum'].")</option>";
			} while ($row_mont = mysql_fetch_assoc($mont));
			$rows = mysql_num_rows($mont);
			if($rows > 0) { mysql_data_seek($mont, 0); $row_mont = mysqli_fetch_assoc($mont);  }  php?>
		</select>    </td>  <?php */ php?>  
		<td width="189" align="right">Плановая дата выполнения:  </td>
		<td width="220" valign="middle"><input name="Date_Plan" type="date" value="<?php echo date("Y-m-d", mktime(0,0,0,date("m"),date("d")/*+3*/,date("Y")));  php?>" size="1" onchange='chk_noti();' />
	<!--    , факт <input name="Date_Fact" type="date" size="8" />-->
	</td>
  </tr>
</table>
</div>
<?php
//} elseif ($GLOBALS['menu'] == 'pay') { 
 php?><div id="fin" <?php echo $GLOBALS['menu'] == 'pay'?'':'style="display:none"' php?>><?php
/*  
	form_net($conn,$Bill_Dog,$id_tarifab,$tarifab_date,$Nic,$Date_start_st,$Date_end_st,$tp,$state,$Date_pay,$a_cus);
	form_w3($From_Net, $Login, $id_tarif3w, $tarif3w_date, $a_cus);
*/	$n_cod = $GLOBALS['new_Cod'] == 0;	
	$c_ar=$a_cus[$Bill_Dog];	
	$is_dolg=($state==2 && $Date_end_st==''/* && $c_ar['auto']==0)||($c_ar['auto']==1 && $state==0*/); 
//	$is_dolg=(($state=$c_ar['state'])==2 && ($Date_end_st=$c_ar['Date_end_st'])=='') /*&& ($d_st > (strtotime("+1 day",$d_py)))*/;// && $cust['auto']==0)||($cust['auto']==1 && $state==0); 
	$can_auto = $c_ar['auto']==1 && $state >0;
				$d_st = strtotime($Date_start_st	/* = $c_ar['Date_start_st']*/);
				$d_py = $Date_pay==""?$d_st-60*60*24:strtotime($Date_pay 		/* = $c_ar['Date_pay']*/);
	$m_dolg = /*($state==2 && $Date_end_st=='')*/$is_dolg?($d_st - (strtotime("+1 day",$d_py)))/60/60/24:0;
//	if {
///		$m_dolg = ($state==2 && $Date_end_st=='')?/**/(strtotime($Date_start_st) - strtotime("+1 day",$Date_pay))/60/60/24:0/**/;
//	}
//	if ($a_cus[$Bill_Dog]['inet']==1){//cust_row !$n_cod php?>
		<div id="it_inet" align="center"<?php if (!($GLOBALS['menu'] == 'pay' && $inet1==1)) { echo 'style="display:none"'; } php?>><b><font size="3"><u>
        	Интернет учётка!</br>Установите соотвествие сетевому нику из Ошибок базы</u></font></b></div>
	<?php // }  php?>
</br>

<div id="sel" <?php if ($inet1==1){ echo 'style="display:none"'; } // $a_cus[$Bill_Dog]['inet'] php?>>
<?php $dolg = $a_cus[$Bill_Dog]['dolg'];  php?><?php // echo $dolg?'hist_pay':'';  php?>
<input name="sel" type="hidden" value="all" /><input name="selBill" type="hidden" value="<?php echo $Bill_Dog php?>" />
<b><font style="font-size:14px">&nbsp;
	<?php $tp_ds = $tp>2?' disabled="disabled"':''  php?>
	<label id="lpay"><input name="B_sel" type="radio" onclick="f_sel(this.value);" value="pay"<?php echo $tp_ds php?>/> Платёж </label>&nbsp;
	<label id="lall" style="background-color:#CCFF99"><input name="B_sel" type="radio" onclick="f_sel(this.value);" value="all" checked<?php echo $tp_ds php?>/> Платёж поровну </label>&nbsp;
	<label id="lfrz"><input name="B_sel" type="radio" onclick="f_sel(this.value)" value="frz" /> Заморозить </label>&nbsp;
	<label id="lhist_pay"><input name="B_sel" type="radio" onclick="f_sel(this.value)" value="hist_pay"/> Платежи </label>&nbsp;
	<label id="lhist_cod"><input name="B_sel" type="radio" onclick="f_sel(this.value)" value="hist_cod"/> Смены адреса </label>&nbsp;
	<label id="lhist_not"><input name="B_sel" type="radio" onclick="f_sel(this.value);" value="hist_not" /> Операции и заявки </label>
</font></b>

<?php /* php?><table width="800" border=0>
  <tr>
	<td bgcolor="#66FF99"><?php */ php?>
    <div id="pay" <?php echo 'style="display:none"'; //if ($GLOBALS['menu']!='pay') { }  php?>>
		<table width="800" border=0 cellpadding="2" cellspacing="2" bgcolor="#66FF99">
		  <tr>
			<td border=1 height="30" colspan="7" align="center" valign="middle"><font size="3"><b>Платёж по договору </b>
		    	<?php /* php?> bgcolor="#660066" color="#FFFF99"<input name="all_dog" type="checkbox" value="1"/><?php */ php?></font></td>
			<td colspan="1" align="left"><font size="3"><b>Примечания</b></font></td>
		  </tr>
		  <tr id="r_dolg" <?php if(!$is_dolg){  php?>style="display:none"<?php }  php?>>
<?php			//echo "1! ->", 
			$m_ab = f_m_ab('ab_numbs', $id_tarifab, $c_ar['Comment'], $c_ar['ab_sum']);	
		//	$m_ab = isset($GLOBALS['ab_numbs'])?($id_tarifab==6&&$c_ar['Comment']!=''?$c_ar['Comment']:round($c_ar['ab_sum']/2*(1+1/($GLOBALS['ab_numbs']+1/*>0?$GLOBALS['ab_numbs']:1*/)))):'';
			//		echo '<b>'.$row_rslt['name_ab'].' </b>', $m_ab, ' руб./мес.';	 php?>
			<td>Долг <?php $d=date("Y-m-d", strtotime($Date_pay." +1 day")); echo round($m_dolg)>0?"с $d по $Date_start_st":"" php?></td>
			<td align="right">
            <input id="s_dolg" name="s_dolg" size="3" readonly="true" value="<?php echo $s_dolg=$is_dolg?round($m_ab/30*$m_dolg,0):0; php?>" align="right" /></td><td > руб.</td>
			<td colspan="3" ><div id="m_dolg">за <?php if($is_dolg){ echo round($m_dolg)," дней";} php?></div></td>
			<td><b><div id="c_dolg" <?php //if(!($state==2 && $Date_end_st=='')) { echo ' style="display:none"'; }  php?>>Подключить <?php $c_dolg = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+($c_ar['auto']==1&&$state==2?0:1),date("Y")))  php?>
            	<input name="c_dolg" type="date" size="8" value="<?php echo $c_dolg  php?>" onchange="adj_pay()"/></div></td>
            <td><b><?php if($m_dolg>0) { php?>Оплата долга <?php } echo ($can_auto?"авто":"+ <b>100</b>руб.")."переподкл" php?> </td>
		  </tr>
		  <tr>
			<td width="79">Абон.платёж: </td>
			<td width="32" align="right"><input name="abon_p" size="3" onchange="f=document.forms.ulaForm;f.abon_per=''; <?php if($n_cod) { php?>adj_pay('p')<?php } else { php?>alert('не присвоен код адреса')<?php } php?>" align="right" /></td><td width="34" > руб.</td>
		  	<td width="16">за </td>
		  	<td width="24" colspan="2" >
            	<input name="opl_per" type="text" size="2" onchange="<?php if($n_cod) {  php?>adj_pay('per')<?php } else { php?>alert('не присвоен код адреса')<?php } php?>" align="right" /></td>
            <td width="88"><div id="days">мес</div></td>            
		  	<td><input name="abon_Com" type="text" size="30" value="Абон.плата"/></td>
		  </tr>
		  <tr>
			<td>Интернет: </td>
            <?php $dsbl_inet = strtotime($Date_pay." +1 day")<time() && $m_ab>0  php?>
           	<td align="right"><input id="inet_pay" name="inet_pay" size="3" onchange="<?php if($n_cod) { php?>adj_pay()<?php } else { php?>alert('не присвоен код адреса')<?php } php?>" align="right" <?php if($dsbl_inet) { php?>style="display:none"<?php } php?>/></td>
   	        <td id="inet_rub" colspan="5"><?php if($dsbl_inet) { php?><b>ДОЛЖНИК !<?php } else { php?> руб.<?php } php?></td>
            <td id="inet_Com" <?php if($dsbl_inet) { php?>style="display:none"<?php } php?>><input name="inet_Com" type="text" size="30"/></td>
		  </tr>
		  <tr>
			<td class="стиль1">Итого: </td>
			<td align="right"><input name="total_pay" id="all_cost" size="3"  align="right" value="<?php if($is_dolg) {echo ($can_auto?0:100)+$s_dolg;}//readonly="true" php?>" onchange="<?php if($n_cod) {  php?>adj_pay('tot')<?php } else { php?>alert('не присвоен код адреса')<?php } php?>"/></td><td > руб.</td>
			<td colspan="5">
				<table border=0 width="100%">
				  <tr>
					<td colspan="3" align="right"><div class="quote" id="opl_to"></div></td>
					<td width="39%"><div class="quote" id="action"></div></td>
				  </tr>
			  	</table>
   			</td>
		  </tr>
		  <tr><td colspan="8"><div id="res_pay"></div></td>
		  </tr>
    	</table>
		
	</div>
	<div id="all" <?php if($tp>2) echo' style="display:none"' php?><?php //if ($dolg) { echo ' style="display:none"'; } php?>>
		<table width="800" border=0 cellspacing="3" bgcolor="#CCFF99">
<?php /*		  <tr id="a_dolg"<?php if (!$dolg) { echo ' style="display:none"'; } php?>>
			<td colspan="9" height="12" align="center" bgcolor="#FFFF99"><?php if ($dolg) {  php?><font size="+1" color="#669900"><b>Абонент отключен за долг!</b></font><?php } php?></td>
		  </tr>	*/ 
		   php?>
		  <tr>
			<td width="79" align="right">Абон.платёж: </td>
<?php	$cust = $c_ar;
//	echo "2! ->", isset($m_ab)?"+":"-"; 
	$m_ab = f_m_ab('tot_ab', $id_tarifab, $cust['Comment'], $cust['ab_sum']);	
		//$m_ab = isset($GLOBALS['tot_ab'])?($id_tarifab==6&&$cust['Comment']!=''?$cust['Comment']:round($cust['ab_sum']/2*(1+1/($GLOBALS['tot_ab']+1>0?$GLOBALS['tot_ab']:1)))):'';
 php?>			<td width="19"><input name="ab_" type="text" size="3" onchange="<?php if($n_cod) { php?>adj_pay()<?php } else { php?>alert('не присвоен код адреса')<?php } php?>" align="right" />
           	  <input name="m_ab" type="hidden" value="<?php echo $m_ab php?>"/>
            </td>
            <td width="24"> руб.</td>
			<td width="193" align="left" style="border:thin solid #6FF">
                <table id="m_op1" width="100%" border=0 style="border: thick solid #933">
                  <tr>
                    <td width="43">
					  <input type="radio" name="radio" id="sl" value="sl" 
                      	onclick="document.getElementById('m_op1').style='border: thick solid #933'; document.getElementById('m_op2').style='border:'; " checked/>за
                    </td>
                    <td width="19" >
		              <input name="opl_" type="text" size="3" align="right" value="" onchange="
					  	<?php if($n_cod) { php?>
                            f=document.ulaForm; 
                            //f.ab_.value=f.opl_mon.value*f.h_ab_numbs.value*this.value; 
                            f.ab_.value=f.m_ab.value*f.h_tot_ab.value*this.value; 
                            adj_pay()
						<?php } else { php?>alert('не присвоен код адреса')<?php } php?>" />
            		</td>
                    <td width="78">
                        <div id="days_">мес</div>
                    </td>
            	  </tr>
            	</table>
            </td>
            <td width="29" align="right">
           	  <input name="t_pay" type="hidden"/><input name="i_pay" type="hidden"/>
            </td>
			<td width="166" align="left" style="border:thin solid #6FF">
                <table id="m_op2" width="100%" border=0>
                  <tr>
                    <td width="44">
                        <input type="radio" name="radio" id="sl2" value="sl" onclick="document.getElementById('m_op2').style='border: thick solid #933'; document.getElementById('m_op1').style='border:'; "/>
                        по
                    </td>
                    <td width="91">
                        <input name="opl_2" type="date" size="10"/>
                    </td>
            	  </tr>
            	</table>
			<td width="92"><input name="Comm_all" type="text" size="15" value="Абон. плата"/></td>
		  </tr>
   		</table>
		<table width="800" cellspacing="2" bgcolor="#CCFF99" >
		  <tr bgcolor="#CCCC99">
			<td align="center"><b>Дог. №</b></td>
			<td align="center" width="78"><b>оплачено по</b></td>
			<td align="center" width="170"><b>долг</b></td>
			<td align="center"><b>подключение</b></td>
			<td align="center" ><b>сумма</b></td>
			<td align="center" width="96"><b>платёж по</b></td>
			<td align="center"><b>акция</b></td>
			<td align="center"><b></b></td>
		  </tr>
<?php		$i = 0;
	$cust = $c_ar;
	//echo "3! ->", isset($m_ab)?"+":"-"; 
	$m_ab = f_m_ab('tot_ab', $id_tarifab, $cust['Comment'], $cust['ab_sum']);	
		//$m_ab = isset($GLOBALS['tot_ab'])?($id_tarifab==6&&$cust['Comment']!=''?$cust['Comment']:round($cust['ab_sum']/2*(1+1/($GLOBALS['tot_ab']+1>0?$GLOBALS['tot_ab']:1)))):'';
	$s_tot = 0;
		foreach ($a_cus as $cust) 
		  if(1*$cust['inet']==0) {
			 if( 1 /*&& !$cust['dolg']*/){ 
//	print_r($cust);
	//		 echo ">",$cust['inet'],"<";
				$i++;	// id="ND_<?php echo $i? >"	
			//	$cust = $cust;//$a_cus[$Bill_Dog];	
				$d_st = strtotime($Date_start_st = $cust['Date_start_st']);
				$d_py = $cust['Date_pay']==""?$d_st-60*60*24:strtotime($Date_pay = $cust['Date_pay']);
				$is_dolg=(($state=$cust['state'])==2 && ($Date_end_st=$cust['Date_end_st'])=='') /*&& ($d_st > (strtotime("+1 day",$d_py)))*/;// && $cust['auto']==0)||($cust['auto']==1 && $state==0); 
				$can_auto = $cust['auto']==1 && $state >0;
		//		$need2con = $state!=1 && !$can_auto;
			//	if(!$is_dolg){  }
				$m_dolg = /*($state==2 && $Date_end_st=='')*/$is_dolg?($d_st - (strtotime("+1 day",$d_py)))/60/60/24:0;
//	echo "st= $Date_start_st, dp=$Date_pay";   php?>
			<tr bgcolor="#CCCC99"><td colspan="8"></td></tr>
            <tr>
				<td><?php //echo $cust['auto'], ' ', strlen($cust['mac']), ' ', $state, '!'; php?><label>&nbsp;
                	<input name="ND_<?php echo $i php?>" type="checkbox" value="<?php echo $cust['Bill_Dog'] php?>"
							onchange="" checked="checked" disabled="disabled" /><?php echo $cust['Bill_Dog'] php?></label></td>
				<td align="center" colspan="1"><?php echo $cust['Date_pay']==""?"":sh_date($cust['Date_pay']) php?>
                	<input name="D_st_<?php echo $i  php?>" value="<?php echo $cust['Date_start_st'] php?>" type="hidden"/></td>
  <?php ///////////////////////////////////////////                  
//	echo			$m_ab = isset($GLOBALS['tot_ab'])?($id_tarifab==6&&$cust['Comment']!=''?$cust['Comment']:round($cust['ab_sum']/2*(1+1/($GLOBALS['tot_ab']+1/*>0?$GLOBALS['ab_numbs']:1*/)))):'';
			//		echo '<b>'.$row_rslt['name_ab'].' </b>', $m_ab, ' руб./мес.';	 php?>
			<td align="center"><div id="d_<?php echo $i  php?>"><?php $d=date("Y-m-d", strtotime($Date_pay." +1 day")); echo round($m_dolg)>0?"".sh_date($d)." ÷ ".sh_date($Date_start_st):"" php?></div>
<!--            </td>
			<td align="right">	--> 
           <input id="sd_<?php echo $i /*s_dolg*/ php?>" name="sd_<?php echo $i /*s_dolg*/ php?>" type="hidden" size="3" readonly="true" value="<?php echo $s_dolg=$is_dolg /*&& $m_dolg>0*/?round($m_ab/30*$m_dolg,0):0; $s_tot += $s_dolg; php?>" align="right" /><!--</td><td >--><b><?php echo $s_dolg php?></b> руб.<!--</td>
			<td >
            <div id="m_dolg<?php echo $i  php?>">--><?php if($is_dolg){ echo "за ",round($m_dolg)," дней";} php?><!--</div>--></td>
            <td align="center"><?php if($is_dolg>0) {echo ($can_auto?"авто":"+ <b>100</b>руб.")."подкл"; $s_tot+=$can_auto?0:100;} php?> <!--</td>
			<td><b><div id="c_dolg<?php echo $i  php?>" <?php //if(!($state==2 && $Date_end_st=='')) { echo ' style="display:none"'; }  php?>>Подключить--> <?php $c_dolg = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+($can_auto?0:1),date("Y")))  php?>
         <?php if($is_dolg) { php?>  	<input name="c_dolg<?php echo $i  php?>" type="date" size="8" value="<?php echo $c_dolg  php?>" onchange="adj_pay()"/>
		 <?php 	if(strlen($cust['mac'])==0) { php?><font style="background:#F90"><br><b>&nbsp;&nbsp;&nbsp;Отсутствует МАС!&nbsp;&nbsp;&nbsp;</b></font><?php }
		 	} php?><!--</div>--></td>
      
  <?php /////////////////////////////////////////// php?>                  
                <td align="center"><div class="quote" id="ab_<?php echo $i  php?>">
                  <input name="ab_<?php echo $i  php?>" size="3" disabled="disabled"/>
              		</div></td>
                <td align="center"><div class="quote" id="opl_<?php echo $i  php?>"></div></td>
                <td align="center"><div class="quote" id="act_<?php echo $i  php?>"></div></td>
				<td colspan="1"><div id="D_end_<?php echo $i  php?>">
                	<input name="D_end_<?php echo $i  php?>" type="hidden"/></div></td>
			</tr>
<?php			} /*elseif (gettype($cust)!='string') {  php?>
			<tr>
				<td align="center"><?php echo $cust['Bill_Dog'] php?></td>
				<td align="center"><?php echo $cust['Date_pay'] php?></td>
                <td colspan="4"><?php echo ($cust['dolg']?'<b>Нет заявки на откл. Сделайте переоформление!</b>':'')
				//*.($cust['state']==2?' Отключен':'Подключен').' с '.$cust['Date_start_st'].
				//	($cust['state']==2 && $cust['Date_end_st']==''?' за долг':' по '.$cust['Date_end_st'])  php?> </td>
			</tr>
			
<?php			} */ php?>
<?php		} php?>
	  <input name="ab_ps<?php echo $i  php?>" type="hidden"/>
      </table>
<!--            <tr>
				<td colspan="7">-->
					<table border=0 width="800" bgcolor="#CCFF99">
					  <tr bgcolor="#CCCC99">
						<td width="23"></td>
						<td align="left"><input name="s_tot" type="hidden" value="<?php echo $s_tot;  php?>" /><div class="quote" id="t_pay">Всего к оплате: <?php echo $s_tot;  php?>руб</div></td>
                        <td align="left"><div class="quote" id="res_pay_all"></div></td>
					  </tr>
			  		</table>
<!--				</td>
			</tr>
		  <tr>
            <td><div class="quote" id="action"></div></td>
		  </tr>
	  </table>-->
	</div>
    <div id="frz" <?php echo 'style="display:none"' php?>>
		<table width="800" border=0 cellspacing="3" bgcolor="#99FFFF">
		  <tr>
		  	<td height="40" colspan="2" align="center" valign="bottom"><b>Приостановка сети (отключить)</b></td>
		  </tr>
		  <tr>
			<td height="40" width="555" align="center">
				с <input name="Date_start_fr" type="date" size="9" onchange="frz_chk()"/> 
				по <input name="Date_end_fr" type="date" size="9"  onchange="frz_chk()"/>
				примечание&nbsp;<input name="Comment_fr" type="text" size="30" />			</td>
		  </tr>
          <tr>
          	<td><div id="res_frz"><?php //echo date('Y-m-d', strtotime($Date_pay)) php?><b>Начало заморозки не должно быть позже <?php echo $Date_pay php?></b></div></td>
          </tr>
	  </table>
	</div>
    <!-------------------------------------------------------------------------------------->
    <div id="hist_pay" style="background-color:#E5E5E5<?php echo $dolg && $tp<3?'':'; display:none'  php?>"></div><?php /*if($tp>2) echo' style="display:none"'*/ php?>
    <!----------------------------------------------------------------->
    <div id="hist_cod" <?php echo 'style="display:none"' php?>></div>
    <!----------------------------------------------------------------->
    <div id="hist_not" <?php echo 'style="display:none"' php?>></div>
</div>
</div>
<?php
//}
//============================================================================
function inp_echo($desc, $name, $value, $type, $size, $onChange) {
    if ($GLOBALS['tp']<3)
    	echo " $desc <input name='$name' type='$type' id='$name' value='$value' size='$size' onChange='$onChange' />";
    else 
    	echo " $desc <input name='$name' id='$name' value='$value' type='$type' size='$size' />";// disabled='disabled'
//		echo strlen($value)>0?($type=="text"?(strlen($desc)>0?"$desc:":"")." <b>$value</b> ":($value>0?$desc:"")):"";
}
//============================================================================
function form_phn($phone_Home, $phone_Cell, $phone_Work, $Jur) { 	//require($frm_phn); //============================================================================
 php?><div id="phn" <?php if ($GLOBALS['menu']=='pay') { echo 'style="display:none"'; }  php?>>
<table width="800" border=0 style="background-color:#9FF">
  <tr>
    <td width="65"  align="left" valign="middle"><strong>телефоны:</strong></td>
	<td width="725" <?php if ($GLOBALS['tp']<3) { php?>align="center"<?php } php?>> 	<?php
    	inp_echo("домашний", "phone_Home", $phone_Home, "text", 7, "adjustPhn();");
    	inp_echo("сотовый", "phone_Cell", $phone_Cell, "text", 16, "adjustPhn();");
    	inp_echo("рабочий", "phone_Work", $phone_Work, "text", 7, "adjustPhn();");
    	inp_echo("юридическое лицо", "Jur", $Jur, "checkbox", 0, "adjustPhn();");  php?>
<!--    	домашний <input name="phone_Home" type="text" id="phone_Home" value="<?php echo $phone_Home;  php?>" size="7" onChange="adjustPhn();" />
        , сотовый <input name="phone_Cell" type="text" id="phone_Cell" value="<?php echo $phone_Cell;  php?>" size="16" onChange="adjustPhn();" />
        , рабочий <input name="phone_Work" type="text" id="phone_Work" value="<?php echo $phone_Work;  php?>" size="7" onChange="adjustPhn();" />
        , юридическое лицо <input name="Jur" type="checkbox" value="<?php echo $Jur;  php?>" onChange="adjustPhn();"/>-->
     </td>
  </tr>
</table>
</div>
<?php	}
//============================================================================
function form_fio($Fam, $Name, $Father, $Birthday, $pasp_Ser, $pasp_Num, $pasp_Date, $pasp_Uvd, $pasp_Adr, $Comment, $a_cus) { 
//require($frm_fio); //============================================================================
 php?> 
	<div id="fio" <?php if ($GLOBALS['menu']!='recon') { echo 'style="display:none"'; }  php?>>
    <table width="800" border=0>
  <tr>
    <td width="76" align="left"><strong>Ф.И.О.:</strong></td>
	<td width="714"  <?php if ($GLOBALS['tp']<3) { php?>align="right"<?php } php?>> <?php
 //   	inp_echo("", "Fam", $Fam, "text", 25, "adjustPasp();");
 //   	inp_echo("", "Name", $Name, "text", 20, "adjustPasp();");
 //   	inp_echo("", "Father", $Father, "text", 20, "adjustPasp();");
 //   	/*if ($Birthday!="0000-00-00")*/ inp_echo("Дата рождения", "Birthday", $Birthday, "text", 9, "adjustPasp();");
 php?><!--	-->
	  <input name="Fam" type="text" id="Fam" onchange="adjastPasp();" value="<?php echo $Fam;  php?>" size="25" />
	  <input name="Name" type="text" id="Name" onChange="adjastPasp();" value="<?php echo $Name;  php?>" size="20" />
<input name="Father" type="text" id="Father" onChange="adjastPasp();" value="<?php echo $Father;  php?>" size="20" />
	  Дата рождения: <input name="Birthday" type="text" id="Birthday" onChange="adjastPasp();" value="<?php echo $Birthday;  php?>" size="9" />	</td>
  </tr>
  <tr <?php if($GLOBALS['tp']>2) echo 'style="display:none"' php?>>
        <td align="left"><strong>Паспорт:</strong></td>
        <td  align="right">
<?php	/*    	inp_echo("серия", "pasp_Ser", $pasp_Ser, "text", 3, "adjustPasp();");
	    	inp_echo("номер", "pasp_Num", $pasp_Num, "text", 5, "adjustPasp();");
	    	inp_echo("выдан", "pasp_Date", $pasp_Date, "text", 9, "adjustPasp();");		*/ php?>
<!--   -->серия <input name="pasp_Ser" type="text" id="pasp_Ser" onChange="adjastPasp();" value="<?php echo $pasp_Ser;  php?>" size="3" />
       номер <input name="pasp_Num" type="text" id="pasp_Num" onChange="adjastPasp();" size="5" value="<?php echo $pasp_Num;  php?>" />
            выдан <input name="pasp_Date" type="text" id="pasp_Date" onChange="adjastPasp();" value="<?php echo $pasp_Date; // type="date" php?>" size="9" />
            кем 
            <input name="pasp_Uvd" id="pasp_Uvd" type="text" onchange="adjastPasp();" value="<?php echo $pasp_Uvd;  php?>" size="38" />    
            <select name='_pasp_Uvd' id='_pasp_Uvd' onchange='document.forms["ulaForm"].pasp_Uvd.value=this.value;' class='headText' >
                  <option value="0" >-</option>
                  <option value="отделением №1 (с местом дислокации в р-не Талнах г.Норильска) отдела УФМС России Красноярского края" >отд.1 УФМС</option>
                  <option value="Талнахским ГОВД Норильского УВД Красноярского края" >Т-ким ГОВД</option>
                  <option value="УФМС Россиии г.Норильск по р-ну Талнах" >р-н Талнах</option>
                  <option value="ОВД г.Талнаха" >ОВД Талнах</option>
                  <option value="О-нием в р-не Талнах отдела УФМС России по Красноярскому краю" >отд. Талнах</option>
                  <option value="УФМС России по г.Норильску" >Норильск</option>
                  <option value="УФМС России по г." >УФМС</option>
          </select>    </td>
      </tr>
      <tr <?php if($GLOBALS['tp']>2) echo 'style="display:none"' php?>>
        <td align="right"></td>
        <td  align="right">
            зарегистрирован по адресу:
            <input name="B_get_adress" type="button" onclick="document.forms.ulaForm.pasp_Adr.value=get_adress();" value="тот же" /><!--initialiseInputs();start_date();-->
          <input name="pasp_Adr" type="text" id="pasp_Adr" onChange="adjastPasp();" value="<?php echo $pasp_Adr;  php?>" size="65" />    </td>
      </tr>
  <?php // }  php?>
  <tr>
	<td align="left"><strong>Примечание:</strong></td>
	<td  align="right">
    <input name="Comment" type="text" value="<?php echo $Comment; //id="Comment"  php?>" size="97" onchange='adj_Cust();' />
    <?php //$tmp=array_keys($a_cus); print_r($a_cus[$tmp[0]]["Comment"]);// //print_arr($a_cus);//[$Bill_Dog]['mac']//echo // php?>
      </td>
  </tr>
</table>
</div>
<?php	}
//=================================================================================================
function form_net($conn, $Bill_Dog, $id_tarifab, $tarifab_date, $Nic, $Date_start_st, $Date_end_st, $tp, $state, $Date_pay, $a_cus) { //require($frm_net); //============================================================================
//echo "$conn, $Bill_Dog, $id_tarifab, $tarifab_date, $Nic";
	$conn = ($conn>0)?$conn:0;
	$id_tarifab = ($id_tarifab>0)?$id_tarifab:0;
	$tarifab_date = ($tarifab_date>0)?$tarifab_date:date("Y-m-d");
	$ar_s = array(''=>'не устан.', 0=>'не устан.', 1=>'подключен', 2=>'замороз.', 3=>'расторг');
	$m_pay = $GLOBALS['menu']=='pay';
	$m_rec = $GLOBALS['menu']=='recon';
//	$m = Array(1=>"января",2=>"февраля",3=>"марта",4=>"апреля",5=>"мая",6=>"июня",7=>"июля",8=>"августа",9=>"сентября",10=>"октября",11=>"ноября",12=>"декабря");
	$m = Array(1=>"янв",2=>"фев",3=>"мар",4=>"апр",5=>"мая",6=>"июн",7=>"июл",8=>"авг",9=>"сен",10=>"окт",11=>"ноя",12=>"дек");
 php?>
<div id="net" style="background-color:#CCFFFF;" <?php if(!$m_rec){ php?>style="display:none"<?php } php?>>
    <div id="nNic" <?php if (!($m_pay && $a_cus[$Bill_Dog]['inet']==1)) { echo 'style="display:none"'; } php?>>
        <table bgcolor="#FF9900" width="800"><tr align="center" height="40">
            <td>Установить <input name="B_err_nic" type="button" onclick='ch_param("err_nic","","nNic");' value="соответствие сетевому нику из Ошибок базы" /></td>
            <td>или как доп.инет.учётка к абон.договору №&nbsp;
                <input name="NewBill" id="NewBill" value="<?php echo $Bill_Dog;  php?>" type="text" size="4" 
                    onchange='ch_param("Bill2acc_chk","nb1="+this.value+"&nb2="+document.forms.ulaForm.Bill_Dog.value,"dNewBill");'/></td>
            <td align="left"><div id="dNewBill"></div></td>
        </tr></table>
    </div>
    <div id="net_tab" <?php echo (($m_pay /*&& $a_cus[$Bill_Dog]['inet']==1*/)?'style="display:none"':''); php?> >
<table width="800" border=0>
  <tr>
    <td width="20" align="left" <?php //echo ($m_pay?'width="40"':'colspan="3" width="450"'); php?>><strong>Сеть: </strong></td>
	<td <?php if (!$m_pay || 1) echo 'width="550"' php?>align="left">
    	<?php //print_r($a_cus[$Bill_Dog]);  php?>
	<?php if (!$m_pay || 1) { php?>&nbsp;Договор<?php } php?>
      	<input name="Bill_Dog" id="Bill_Dog" value="<?php echo $Bill_Dog php?>" type="text" <?php echo $m_pay?'style="display:none"':'' php?> size="4" <?php echo $GLOBALS['tp']<3?"onchange='adj_Bill_Dog(this)'":"" php?> <?php echo $Bill_Dog=="новый"?'disabled="disabled"':'' php?>/>
		<?php if (!$m_pay || 1) { php?>MAC<?php 
		}
		$mac = isset($a_cus[$Bill_Dog]['mac'])?$a_cus[$Bill_Dog]['mac']:"";//isset($a_cus[$Bill_Dog])?$a_cus[$Bill_Dog]['mac']:"";
		$mac = $mac==""?"":substr($mac, 0, 2)."-".substr($mac, 2, 2)."-".substr($mac, 4, 2)."-".
			   substr($mac, 6, 2)."-".substr($mac, 8, 2)."-".substr($mac, 10, 2);
         php?><input name="mac" id="mac" value="<?php echo $mac;  php?>" type="text" <?php if($m_pay){ php?>style="display:none"<?php } php?>
        	size="15" maxlength="17" onkeyup="v_MAC(this.value,<?php echo "'{$Bill_Dog}'" php?>);" 
            onchange='<?php echo /*$GLOBALS['tp']>2?*/"f=document.forms.ulaForm.tabl_cust;cor_mac(f.options[f.selectedIndex].value)"/*:"adj_mac()"*/; php?>'/>
		<?php if (!$m_pay || 1) { php?>&nbsp;ник<?php } php?>
		<input name="Nic" type="text" <?php echo ($m_pay && 0?'style="display:none"':''); php?> id="Nic" <?php if($GLOBALS['tp']<3) { php?>onChange="adj_Nic(this);"<?php } php?> value="<?php echo $Nic;  php?>" size="9" />
      	&nbsp;<?php echo ($m_pay && 0?'':'&nbsp;подключ.'); //  php?>
	<select name='conn' id='conn' <?php if($GLOBALS['tp']<3) { php?>onchange='adj_Conn(this.value);'<?php } php?> class='headText' <?php echo $m_pay && 0?'style="display:none"':''; php?> >
<?php 	if ($conn>0) {
		$v_tar = mysql_query("SELECT * FROM `v_tarifab` where id_tar_con=$conn") or die(mysql_error());
		$r_v_tar = mysql_fetch_assoc($v_tar);
		$c_typ = $r_v_tar["con_typ"];
	} else {
		$c_typ = 0;
	}
	 	$rslt = mysql_query("SELECT * FROM `spr_con_typ`") or die(mysql_error());
		$row_rslt = mysql_fetch_assoc($rslt);
		do {
			$op = $row_rslt['con_typ'];
			$able = ($op==5 ? !$GLOBALS['new_Cod'] :1)?"":"disabled='disabled' ";
			echo "<option value=".$op." ".$able./*($op==$c_typ/ *$conn* / ? "selected":"").*/">".$row_rslt['typ_name']."</option>";
		} while ($row_rslt = mysql_fetch_assoc($rslt));
	 php?>
	</select>
	</td>
	<td<?php if(!$m_pay) { php?> width="100"<?php } php?>>
	  <div id="con_tar" <?php echo ($m_pay?'align="left"':''); php?>>
	  <?php //if(!$m_pay) { echo "тариф"; }	  	
			//echo "SELECT `con_typ` FROM `spr_tar_con` WHERE `id_tar_con`=".$conn;
			$r_con = mysql_query("SELECT `con_typ` FROM `spr_tar_con` WHERE `id_tar_con`=".$conn) or die(mysql_error());//`id_tar_con`
			$r_c = mysql_fetch_assoc($r_con);
			$c_typ = $r_c["con_typ"];
//			$s_qer = "SELECT * FROM `spr_tar_con` WHERE `con_typ`=".$conn.(($conn==4)?" or (`con_typ`=1 and `con_sum`<500)":"")." order by `id_tar_con`";
/*echo $conn," ",*/ $s_qer = "SELECT * FROM `v_tarifab` WHERE `con_typ`=".$c_typ.(($c_typ==4)?" or (`id_tar_con`=1 and `con_sum`<500)":"")." order by `id_tar_con`";
			$rslt = mysql_query($s_qer) or die(mysql_error());//`id_tar_con`
			$row_rslt = mysql_fetch_assoc($rslt);
			$rows = mysql_num_rows($rslt);
			$nm_tarif = "";	 php?> 
		<select name='id_tar_con' class='font8pt' id='id_tar_con' <?php echo ($GLOBALS['tp']<3?"onchange='adj_con_tar(this)'":"").$m_pay && 0?"style='display:none'":""  php?> >	
<?php			echo "<option value=0 ".(($row_rslt['id_tar_con']==0)?"selected":"").">выбрать</option>";	//$i++
			do { 
			//		".strval($row_rslt['perstypes'])." ".strval($GLOBALS['TypePers'])."-  ($row_rslt['perstypes'] >= $GLOBALS['TypePers'])strval()
				echo "<option value=".$row_rslt['id_tar_con']." ".(($row_rslt['id_tar_con']==$conn/*$id_tarifab*/)?"selected":"").
					($tp>$row_rslt['perstypes']?" disabled='disabled' ":"")." >".$row_rslt['name_cn']."</option>";
				if ($row_rslt['id_tar_con']==$conn/*id_tarifab*/) { $nm_tarif = $row_rslt['name_cn']; }
				$tarifs[] = $row_rslt;
			 } while ($row_rslt = mysql_fetch_assoc($rslt));
			$rows = mysql_num_rows($rslt);	 php?>
		</select>
		<?php echo ($m_pay?'<b>&nbsp;'.$nm_tarif.'&nbsp;</b>':'');  php?>
		<input name="h_ts" type="hidden" value="<?php echo $rows  php?>" />
<?php		foreach ($tarifs as $t_row) {		//	print_r($t_row);
			echo '<input id="h_op_'.$t_row['id_tar_con'].'" type="hidden" value="'.$t_row['opl_period'].'" size=3/>';//
			echo '<input id="h_cn_'.$t_row['id_tar_con'].'" type="hidden" value="'.$t_row['con_sum'].'" />';//
			echo '<input id="h_ab_'.$t_row['id_tar_con'].'" type="hidden" value="'.$t_row['ab_sum'].'" />';//
			echo '<input id="h_id_'.$t_row['id_tar_con'].'" type="hidden" value="'.$t_row['id_tarifab'].'" />';//
			echo '<input id="h_kt_'.$t_row['id_tar_con'].'" type="hidden" value="'.$t_row['k_tar'].'" />';//
		}	 php?>
		</div>
	</td>
    <td align="left" <?php echo ($m_pay && 0?'style="display:none"':'');//<div id="conn_pay" ></div> php?>>
    	<input name="conn_pay" size="3" <?php if($GLOBALS['tp']<3) { php?> type="hidden" onchange="adj_CPay()" <?php } else echo ' type="hidden"' php?> /> <?php if($GLOBALS['tp']<3) echo"руб." php?>
		<input name="tarifab_date" type="hidden" value="<?php echo $tarifab_date;  php?>" /><?php // echo $tarifab_date;  php?>
		<?php
			$s_qer = "SELECT * FROM `spr_tarifab` where id_tarifab=$id_tarifab order by `id_tarifab`";
			$rslt = mysql_query($s_qer) or die(mysql_error());
			$row_rslt = mysql_fetch_assoc($rslt);
			$rows = mysql_num_rows($rslt);
			$nm_tarif = "";
			echo '<input type="hidden" id="id_tarifab" value="'.$id_tarifab.'" />';//
		 php?>
    </td>
    <td><div id="opl_p" style="display:none"></div></td>
<?php if(!$m_pay || 1) { php?>
  </tr>
</table>
<table width="800" border=0>
  <tr><td width="10"></td>
<?php } php?>
	<td <?php if(!$m_pay || 1){ php?><?php } php?>width="220"><div id="con_s">Абон.тариф<b>
		<?php if ($id_tarifab>0) {
				if ($id_tarifab==3) { php?>
					<font size="+1" style="background-color:#FF0000" color="#FFFF00">
                    	&nbsp;<b><?php echo $row_rslt['name_ab'] php?>&nbsp</font></b>
                <?php } else {
					$c_ar = $a_cus[$Bill_Dog];
						//echo "4! ->", isset($m_ab)?"+":"-"; 
						$m_ab = f_m_ab('ab_numbs', $id_tarifab, $c_ar['Comment'], $c_ar['ab_sum']);	
		//$m_ab = isset($GLOBALS['ab_numbs'])?($id_tarifab==6&&$c_ar['Comment']!=''?$c_ar['Comment']:round($c_ar['ab_sum']/2*(1+1/($GLOBALS['ab_numbs']>0?$GLOBALS['ab_numbs']:1)))):'';
					echo '<b>'.$row_rslt['name_ab'].' </b>', $m_ab, ' руб./мес.';
                 }
			}		 php?>
<?php /*	 php?>		<select name="id_tarifab" class='font8pt' id="id_tarifab" onchange='adj_con_tar();' <?php echo ($m_pay?'style="display:none"':''); php?>>
			echo "<option value=0>выбрать</option>";	//$i++
			do { 
			//		".strval($row_rslt['perstypes'])." ".strval($GLOBALS['TypePers'])."-  ($row_rslt['perstypes'] >= $GLOBALS['TypePers'])strval()
				echo $tp,$row_rslt['perstypes'],"<option value=".$row_rslt['id_tarifab']." ".(($row_rslt['id_tarifab']==$id_tarifab)?"selected":"").($tp>$row_rslt['perstypes']?" disabled='disabled' ":"")." >".$row_rslt['name_ab']."</option>";
				if ($row_rslt['id_tarifab']==$id_tarifab) { $nm_tarif = $row_rslt['name_ab']; }
				$ab_tarifs[] = $row_rslt;
			 } while ($row_rslt = mysql_fetch_assoc($rslt));
			$rows = mysql_num_rows($rslt);	 php?>
		</select>	<?php echo ($m_pay?'<b>&nbsp;'.$nm_tarif.'&nbsp;</b>':''); php?><?php 
		echo '<input name="h_ts" type="hidden" value="'.$rows.'" />';
		foreach ($ab_tarifs as $t_row) {
			echo '<input id="h_opl_'.$t_row['id_tarifab'].'" type="hidden" value="'.$t_row['opl_period'].'" />';//
			echo '<input id="h_con_'.$t_row['id_tarifab'].'" type="hidden" value="'.$t_row['con_sum'].'" />';//
			echo '<input id="h_ab_'.$t_row['id_tarifab'].'" type="hidden" value="'.$t_row['ab_sum'].'" />';//
		}	<?php */ php?>
</div></td> <!-- Сюда записать параметры подключения -->
	<td <?php if(!$m_pay || 1){ php?>width="0"<?php } php?> align="left"><div id="abon_pay">
	<?php	echo '<input name="abon_pay" size="4" type="hidden" />'; // type="text" <!-- onchange="adj_CPay()"руб.-->
//!		if (isset($a_cus[$Bill_Dog]['inet']) && !$a_cus[$Bill_Dog]['inet']) {
//			$m_ab = isset($GLOBALS['ab_numbs'])?(round(100*(1+1/($GLOBALS['ab_numbs']>0?$GLOBALS['ab_numbs']:1)))):'';
//	$a_cus[$Bill_Dog]['ab_sum']
				//echo "5! ->", isset($m_ab)?"+":"-"; 
				$m_ab = $GLOBALS['totalRows_customer']==0?"":f_m_ab('ab_numbs', $id_tarifab, $a_cus[$Bill_Dog]['Comment'], $a_cus[$Bill_Dog]['ab_sum']);
	//	$m_ab = isset($GLOBALS['ab_numbs'])?($id_tarifab==6&&$a_cus[$Bill_Dog]['Comment']!=''?$a_cus[$Bill_Dog]['Comment']:round($a_cus[$Bill_Dog]['ab_sum']/2*(1+1/($GLOBALS['ab_numbs']>0?$GLOBALS['ab_numbs']:1)))):'';	//totalRows_customer
//			$m_ab = isset($GLOBALS['ab_numbs'])?($id_tarifab==6&&$a_cus[$Bill_Dog]['Comment']!=''?$a_cus[$Bill_Dog]['Comment']:round($a_cus['ab_sum']/2*(1+1/($GLOBALS['ab_numbs']>0?$GLOBALS['ab_numbs']:1)))):'';	//totalRows_customer
			echo /*$m_ab, ' руб./мес.',*/'<input name="opl_mon" value="'.$m_ab.'" size=4 type="hidden" />'; //," руб./мес." type="hidden"
//!		}
	  php?> 
	</div></td>
	<?php $ar_c = array(''=>'333333', '0'=>'333333', '1'=>'33CC66', '2'=>'0000FF', '3'=>'00FFFF');  php?>
	<?php if($m_pay && 0){ php?>
		<td align="center"><div id="state" style="border:solid #<?php echo $ar_c[$state]  php?>">&nbsp;<strong><?php echo $ar_s[$state];  php?></strong>&nbsp;
		c <?php echo $Date_start_st;  php?>&nbsp;<input name="Date_start_st" value="<?php echo $Date_start_st;  php?>" type="hidden"/>
		<?php if ($state==2 && $Date_end_st=='') { // php?> за долг<?php } else {  php?>
			по <?php echo $Date_end_st; }  php?>&nbsp;<input name="Date_end_st" value="<?php echo $Date_end_st;  php?>" type="hidden"/></div></td>
	<?php } else {// php?>
		<td width="300" align="right"><div id="state" style="border:solid #<?php echo $ar_c[$state]  php?>">&nbsp;<strong><?php echo $ar_s[$state];  php?></strong>&nbsp;
        	c <input name="Date_start_st" value="<?php echo $Date_start_st;  php?>" size="8" type="date"/>
            по <input name="Date_end_st" value="<?php echo $Date_end_st;  php?>" size="8" onchange="document.forms.ulaForm.Date_pay.value=this.value;adj_CPay_act()" type="date"/></div></td>
	<?php } php?>
	<td align="left"><div id="Date_pay"> оплачено по <input name="Date_pay" value="<?php echo $Date_pay;  php?>" size="8" <?php if($m_pay && 0){ php?>type="hidden"<?php } php?>/>
		<?php if($m_pay && 0){ echo '<b>'.(empty($Date_pay)?'___':date("j ",strtotime($Date_pay)).$m[date("n",strtotime($Date_pay))].' '.date("Y", strtotime($Date_pay)).'г.').'</b>';
		//$Date_pay; 
		}
		if ($GLOBALS['totalRows_customer']>0 && $a_cus[$Bill_Dog]['dolg'] && $Date_end_st!='' && $m_ab>0 && $a_cus[$Bill_Dog]['inet']==0) {  php?><font size="3" style="background-color:#FF0000" color="#FFFF00"><br><b>Нет заявки на откл!</b></font>
			<!--<input name="B_add_off" type="button" onclick='ch_param("err_nic","","nNic");' value="+" />-->
            <?php //print_r($a_cus);
		if (!$m_pay)	put_noti2off ($Date_pay, $Bill_Dog, $a_cus[$Bill_Dog]['Cod_flat'], $a_cus[$Bill_Dog]['id_Podjezd'], $a_cus[$Bill_Dog]['flat'], $GLOBALS['tn']/*TabNum*/);
		} php?></div></td>
	<td><div id="rad"><?php /**/echo isset($a_cus[$Bill_Dog]['rad']) && $a_cus[$Bill_Dog]['rad']?"<b>R√":"R-";/**/ php?></div></td>
    <td align="right"><div id="frnd">
<?php if(!$m_pay || 1){ echo $is_frend=isset($a_cus[$Bill_Dog]['Bill_frend'])/*&&($frend=$a_cus[$Bill_Dog]['Bill_frend'])!=""*/?"друг: ":"";  php?>
    	<input name="Bill_frend" size="4" value="<?php echo $is_frend?$frend:""  php?>" <?php echo $GLOBALS['tp']<3?'onchange="adjastNet()"':'' php?>/>
<?php } php?>
	</div></td>
  </tr>
</table>
</div>

<?php ####################################################################################################### php?>
<div id="p_net" <?php if($GLOBALS['menu'] != 'pay') echo 'style="display:none"' php?> >
<?php /* php?><div id="nNic" <?php if (!(/*$m_pay && * /$a_cus[$Bill_Dog]['inet']==1)) { echo 'style="display:none"'; } php?>>
        <table bgcolor="#FF9900" width="800"><tr align="center" height="40">
            <td>Установить <input name="B_err_nic" type="button" onclick='ch_param("err_nic","","nNic");' value="соответствие сетевому нику из Ошибок базы" /></td>
            <td>или как доп.инет.учётка к абон.договору №&nbsp;
                <input name="NewBill" id="NewBill" value="<?php echo $Bill_Dog;  php?>" type="text" size="4" 
                    onchange='ch_param("Bill2acc_chk","nb1="+this.value+"&nb2="+document.forms.ulaForm.Bill_Dog.value,"dNewBill");'/></td>
            <td align="left"><div id="dNewBill"></div></td>
        </tr></table>
    </div><?php */ php?>
<table id="p_net_tab" width="800" border=0 style="background-color:#CCFFFF" <?php echo (($m_pay && $a_cus[$Bill_Dog]['inet']==1)?'style="display:none"':''); php?>>
  <tr>
    <td align="left">
      	<strong>Сеть: </strong>&nbsp;<?php echo ($m_pay?'':'&nbsp;подключ.'); //  php?>
		<?php echo ($m_pay?'<b>&nbsp;'.$nm_tarif.'&nbsp;</b>':'');  php?>
		Абон.тариф<b>
		<?php if ($id_tarifab>0) {
				if ($id_tarifab==3) { php?>
					<font size="+1" style="background-color:#FF0000" color="#FFFF00">
                    	&nbsp;<b><?php echo $row_rslt['name_ab'] php?>&nbsp</font></b>
                <?php } else {
					$c_ar = $a_cus[$Bill_Dog];
							//echo "6! ->", isset($m_ab)?"+":"-"; 
							$m_ab = f_m_ab('ab_numbs', $id_tarifab, $c_ar['Comment'], $c_ar['ab_sum']);	
		//$m_ab = isset($GLOBALS['ab_numbs'])?($id_tarifab==6&&$c_ar['Comment']!=''&&round($c_ar['Comment'])>0?$c_ar['Comment']:round($c_ar['ab_sum']/2*(1+1/($GLOBALS['ab_numbs']>0?$GLOBALS['ab_numbs']:1)))):'';
					echo '<b>'.$row_rslt['name_ab'].' </b>', $m_ab, ' руб./мес.';
                 }
                 
			}		 php?>
</td>
	<?php // $ar_c = array(''=>'333333', '0'=>'333333', '1'=>'33CC66', '2'=>'0000FF', '3'=>'00FFFF');  php?>
    <td align="center"><div id="p_state" style="border:solid #<?php echo $ar_c[$state]  php?>">&nbsp;<b><?php echo $ar_s[$state];  php?></b>&nbsp;
    c <?php echo $Date_start_st;  php?>&nbsp;
    <?php if ($state==2 && $Date_end_st=='') { // php?> за долг<?php } else {  php?>
        по <?php echo $Date_end_st; }  php?>&nbsp;
    </div></td>
	<td align="left"><div id="p_Date_pay"> оплачено по 
		<?php  echo '<b>'.(empty($Date_pay)?'___':date("j ", strtotime($Date_pay)).$m[date("n", strtotime($Date_pay))].' '.date("Y", strtotime($Date_pay)).'г.').'</b>';
		if ($GLOBALS['totalRows_customer']>0 && $a_cus[$Bill_Dog]['dolg'] && $Date_end_st!='' && $m_ab>0 && $a_cus[$Bill_Dog]['inet']==0) {  php?><font size="3" style="background-color:#FF0000" color="#FFFF00"><br><b>Нет заявки на откл!</b></font>
   <?php if ($m_pay)	put_noti2off ($Date_pay, $Bill_Dog, $a_cus[$Bill_Dog]['Cod_flat'], $a_cus[$Bill_Dog]['id_Podjezd'], $a_cus[$Bill_Dog]['flat'], $GLOBALS['tn']/*TabNum*/);
		} php?>
        <?php /**/echo isset($a_cus[$Bill_Dog]['rad']) && $a_cus[$Bill_Dog]['rad']?"<b>R√":"R-";/**/ php?>
    	</div>    
    </td>
  </tr>
</table>
</div>
</div>
<?php ####################################################################################################### php?>
<!--    <input name="dt3w2day2" type="button" id="dt3w2day2" onclick="javascript:document.forms['ulaForm'].tarifab_date.value=TODAY2" value="сегодня" /></td>-->
<?php	}
//============================================================================
function form_w3($From_Net, $Login, $id_tarif3w, $tarif3w_date, $a_cus1) { //require($frm_w3); //============================================================================
	$m_pay = $GLOBALS['menu']=='pay';
/*if ($totalRows_customer>0) {
	$From_Net = $a_cus[$Bill_Dog1]['From_Net'];
	$Login = $Logins[$Bill_Dog1][1]['Login'];
	$id_tarif3w = $Logins[$Bill_Dog1][1]['id_tarif3w'];
	$tarif3w_date = $Logins[$Bill_Dog1][1]['tarif3w_date'];
} else {
	$From_Net = "";
	$Login = "";
	$id_tarif3w = 0;
	$tarif3w_date = "";
}
'a_cus'][$GLOBALS['Bill_Dog1']][
*/ php?>
<div id="w3" border=1 style="background-color:#CCFFCC">
 <table id="inet_tab" width="800" border="0" <?php echo (($m_pay && $GLOBALS['inet1']==1)?'style="display:none"':''); php?>>
  <tr>
    <td width="106" align="<?php if ($m_pay && 0) { php?>right<?php }else{ php?>left<?php } php?>"><strong>Интернет&nbsp;
    	<button name="refr_3w" type=button onClick="f = document.forms.ulaForm; Bill_Dog = f_Bill_Dog();
		ch_param('refr_3w','tn='+f.TabNum+'&account='+val_nm(Bill_Dog, 'account'+(1*f.Login.selectedIndex+1)), 'inet_inf');"><img src="reload.png" align=middle alt="Обнови"></button>:</strong></td>
        
<?php /* php?>	<td width="35" align="right" <?php echo (($GLOBALS['menu']=='pay')?'':'width="40"'); php?>>логин </td><?php */ php?>
	<td width="220"><div id="Login" align="left<?php //if ($m_pay) {? ><?php }else{? >rihgt<?php } php?>">
<?php 	if (($GLOBALS['totalRows_customer']>0) && ($GLOBALS['Logins'][$GLOBALS['Bill_Dog1']]["Logins"]>0)) {
			$inp_sz = $GLOBALS['Logins'][$GLOBALS['Bill_Dog1']]["Logins"]; php?>
			<select name="Login" id="Login" size="<?php echo ''.$inp_sz.''; php?>" onchange="adjustLogin()" class="navText" >
<?php			for($i=1; $i<=$inp_sz; $i++){
				$Log = $GLOBALS['Logins'][$GLOBALS['Bill_Dog1']][$i];
				echo '<option value='.$Log['Login'].(($i ==1)?" selected":"").' >№'.$Log['account'].', '.$Log['Login'].', ',1*$Log['saldo'],' руб.'.'</option>';
			}	 php?>
			</select><?php //</td>
	/* php?>//		echo '<table><tr>';
			$sc1 = '';//логин 
			$sc2 = '';
			/*echo* / $ss = '< td rowspan="'.$inp_sz.'">< select name="Login" id="Login" class="navText" size="'.$inp_sz.'" onchange="adjustLogin()" >';
			for($i=1; $i<=$inp_sz; $i++){
				$Log = $GLOBALS['Logins'][$GLOBALS['Bill_Dog1']][$i];
				$sc1 .= ($i>1?'< tr>':'').'< td>'.$Log['account'].'< /td>'.($i>1?'< /tr>':'');
				/*echo* / $ss .= '< option value='.$Log['Login'].(($i ==1)?" selected":"").' >'.$Log['Login'].'</option>';
				$sc2 .= ($i>1?'< tr>':'').'< td>'.$Log['saldo'].' руб.'.'< /td>'.($i>1?'</tr>':'');
			}
			/*echo* / $ss .= '< /select></td>';
/*			$Log1 = $GLOBALS['Logins'][$GLOBALS['Bill_Dog1']][1];
			echo '<td>',1*$Log1['saldo'],' руб.'.$Log1['account'].'</td>';
			echo '<td rowspan="'.$inp_sz.'" valign="bottom">'.
				'<input name="addLogin" type="button" id="addLogin" onclick="faddLogin();" value="+"'.
						(($GLOBALS['menu']=='pay')?'style="display:none"':'').'/>'.
				'</td></tr>';
			for($i=1; $i<=$inp_sz; $i++){
				$Log = $GLOBALS['Logins'][$GLOBALS['Bill_Dog1']][$i];
				echo ($i>1?'<tr>':'').'<td>',1*$Log['saldo'],' руб.'.$Log['account'].'</td>'.($i>1?'</tr>':'');
			}	* /
			echo $sc1, $ss, $sc2;
			echo '< /tr>< /table>';<?php */
	/*		echo //'<td valign="bottom">'.
				'<input name="addLogin" type="button" id="addLogin" onclick="faddLogin();" value="+"'.
						(($GLOBALS['menu']=='pay')?'style="display:none"':'').'/>'.
				'</td>';//</tr>	*/
		} elseif ($m_pay) {	//echo '<b>логин отсутствует!</b>';	 php?>
<!--			<input type="button" onclick="faddLogin();" value="+" />-->
<?php		} else {
			echo $GLOBALS['totalRows_customer'] == 0?'':'<input name="nic2login" type="button" id="nic2login" onclick="f=document.forms.ulaForm;f.Login.value=f.Nic.value;adjastNet();" value="ник >" />'.
				'<input name="Login" type="text" value="'.$Login.'" onChange="adjastNet();" size="12" />';//
			}
	 php?>
    </div></td>
	<td width="540"><div id="nw3"<?php if ($GLOBALS['menu']!='recon') { echo 'style="display:none"'; } php?>>
	<table><tr>
    	<td id="daddLogin"><?php if ($GLOBALS['totalRows_customer']>0){ php?><input name="addLogin" type="button" onclick="faddLogin();" value="+"/><?php } php?></td><!-- id="addLogin"-->
	<?php /* php?>	<td align="left" <?php echo $m_pay && 0?'style="display:none"':''  php?>><div id="addLogin"></div></td><?php */ php?>
		<td align="center" id="tarif3w"><?php if ($GLOBALS['menu']!='pay' || 1) { php?>тариф<?php } php?>
    	<select name="id_tarif3w" class='headText' id="id_tarif3w" <?php echo $GLOBALS['tp']<3?"onchange='adjustTarif3w()'":"" php?> <?php echo $m_pay && 0?'style="display:none"':''  php?>>
      <?php
	  	$q_Tarif3w = "SELECT * FROM spr_tarif3w";
		$Tarif3w = mysql_query($q_Tarif3w) or die(mysql_error());
		$row_Tarif3w = mysql_fetch_assoc($Tarif3w);
		$totalRows_Tarif3w = mysql_num_rows($Tarif3w);
	do {
		echo "<option value=".$row_Tarif3w['id_tarif3w']." ".
			(($row_Tarif3w['id_tarif3w']==$id_tarif3w)?"selected":"").">".$row_Tarif3w['name_3w']."</option>";
    } while ($row_Tarif3w = mysql_fetch_assoc($Tarif3w));
  	$rows = mysql_num_rows($Tarif3w);
  	if($rows > 0) { mysql_data_seek($Tarif3w, 0); $row_Tarif3w = mysqli_fetch_assoc($Tarif3w);  }  php?>
      </select></td>
	<td align="left" id="d_t3w_date" <?php echo (($GLOBALS['menu']=='pay' && 0)?'style="display:none"':''); php?>><div>установлен с 
    <input name="tarif3w_date" id="tarif3w_date" value="<?php echo $tarif3w_date;  php?>" type="date" <?php echo $GLOBALS['tp']<3?'onChange="adjastNet()"':'' php?> size="10" /><!-- value=< ?php $DateNotify=date("Y-m-d"); echo $DateNotify ? >-->
<!--    <input name="dt3w2day" type="button" id="dt3w2day" onclick="javascript:document.forms['ulaForm'].tarif3w_date.value=TODAY2" value="сегодня" />--></div></td>
	<script language="JavaScript" type="text/javascript">
		document.write('OOOOOO<a title="Календарь" href="javascript:openCalendar(\'\', \'ulaForm\', \'tarif3w_date\', \'date\')"><img class="calendar" src="b_calendar.png" alt="Календарь"/></a>');
	</script>
    <td><?php if (!$m_pay || 1) { php?>из сети <?php } php?>
   	  <input name="From_Net" id="From_Net" type="text" <?php echo $m_pay && 0?'style="display:none"':''  php?> <?php echo $GLOBALS['tp']<3?'onChange="adjastNet()"':'' php?> value="<?php echo $From_Net php?>" size="7" />
    </td>
 <!--   <td <?php //echo (($GLOBALS['menu']=='pay')?'width="300"':'width="0"'); php?>></td>-->
</tr></table></div></td>
	</tr>
	<tr>
  	<td colspan="5"><div id="inet_inf"></div></td>
	</tr>
 </table>
 <div id="new_adr"></div>
</div>
<?php }
//}
/*"&*/
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
function sh_date($Dt) {
	return strftime("%d-%m-%Y",strtotime($Dt));
	//date("j ", strtotime($Dt)).$m[date("n", strtotime($Dt))].' '.date("Y", strtotime($Dat)).'г.';
}
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
function print_hid($id, $key, $val)
{
	$inp_name = 'h_'.$id.'_'.$key; // $inp_name.'='.
//	echo "<FONT size=-1>".$inp_name."=".$val." </FONT>";	//</br>
  	echo '<input name="'.$inp_name.'" id="'.$inp_name.'" value="'.$val.'" type="hidden"/>';//
}
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
function print_arr($ar)
{
	foreach ($ar as $k => $v) {
		echo '</br>['.$k.']:</br>';
		if (is_array($v)){ echo "||";
			foreach ($v as $key => $val) {
				if (is_array($val)){ echo "||";
					foreach ($val as $key2 => $val2) {
						echo '['.$key2.']='.$val2.',';
					}
				} else { echo '['.$key.']= '.$val.' '; }
			}
		} else { echo $v; }
	}
}
function f_m_ab ($ab_numbs,$id_tarifab,$Comment,$ab_sum) {
//	echo $ab_numbs," ",$GLOBALS[$ab_numbs]," ",$id_tarifab," ",$Comment," ",$ab_sum;
	//	"абонплата 1200руб."
	$get_com = $id_tarifab==6 /*&&$Comment!=''&& round($Comment)>0*/;
	$com_ab = $Comment!=''&& round($Comment)>0?round($Comment):$ab_sum;
//	$get_com = $id_tarifab==6&&$Comment!=''&& ($spos = strpos($Comment, "плата"))&&($epos = strpos($Comment, "руб"));
//	echo  $Comment,$spos+4,"=", $epos-$spos-4,"=", substr($Comment, $spos+4, $epos-$spos-4), "=",$Comment{1}, "=";
//$chars = preg_split('//', $Comment, -1, PREG_SPLIT_NO_EMPTY);
//print_r($chars);
	
	//$id_tarifab==6&&$Comment!=''&&round($Comment)>0?$Comment:
	return isset($GLOBALS[$ab_numbs])?($get_com?$com_ab:round($ab_sum/2*(1+1/($GLOBALS[$ab_numbs]>0?$GLOBALS[$ab_numbs]:1)))):'';
//	return isset($ab_numbs)?($get_com?round(substr($Comment, $spos+5, $epos-$spos+5)):round($ab_sum/2*(1+1/($ab_numbs>0?$ab_numbs:1)))):'';
}
/*========================================================================
/*    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        print "\t<tr>\n";
        foreach ($line as $col_value) { print "\t\t<td>$col_value</td>\n";  }
        print "\t</tr>\n";
    }
*/ 
/*<table width="200" border="1">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>*/ php?>
