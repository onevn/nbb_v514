<?php
/**
 * @author		NetBanBe
 * @copyright	2005 - 2012
 * @website		http://netbanbe.net
 * @Email		nwebmu@gmail.com
 * @HotLine		094 92 92 290
 * @Version		v5.12.0722
 * @Release		22/07/2012
 
 * WebSite hoan toan duoc thiet ke boi NetBanBe.
 * Vi vay, hay ton trong ban quyen tri tue cua NetBanBe
 * Hay ton trong cong suc, tri oc NetBanBe da bo ra de thiet ke nen NWebMU
 * Hay su dung ban quyen duoc cung cap boi NetBanBe de gop 1 phan nho chi phi phat trien NWebMU
 * Khong nen su dung NWebMU ban crack hoac tu nguoi khac dua cho. Nhung hanh dong nhu vay se lam kim ham su phat trien cua NWebMU do khong co kinh phi phat trien cung nhu san pham tri tue bi danh cap.
 * Cac ban hay su dung NWebMU duoc cung cap boi NetBanBe de NetBanBe co dieu kien phat trien them nhieu tinh nang hay hon, tot hon.
 * Cam on nhieu!
 */
 
	if (!defined('NetNWEB')) die("Ban khong co quyen truy cap he thong");
    
    $getcontent_url = $server_url . "/sv_chopl.php";
    $getcontent_data = array(
        'login'    =>  $_SESSION['mu_username'],
        'action'    =>  'mypl',
        
        'string_login'    =>  $_SESSION['checklogin'],
        'passtransfer'    =>  $passtransfer
    );
    
    $reponse = _getContent($getcontent_url, $getcontent_data, $getcontent_method, $getcontent_curl);

	if ( empty($reponse) ) $error_module = "Server bảo trì.";
	elseif($reponse == "login_other") {
		$error_module = "<font size='3' color='red'>Tài khoản đã được đăng nhập trên trình duyệt khác hoặc máy tính khác.</font>";
		session_destroy();
	}
	else {
		$info = read_TagName($reponse, 'info', 1);
		if ($info == 'OK') {
			$mypl = read_TagName($reponse, 'mypl', 1);
            $mystore = read_TagName($reponse, 'mystore', 1);
            $mystore_arr = json_decode($mystore, true);
            foreach($mystore_arr as $k => $v) {
                $mystore_arr[$k]['huyban'] = "";
                if($mystore_arr[$k]['dangban'] == 1) {
                    $mystore_arr[$k]['huyban'] = "<br /><input type='button' class='btn_huyban' id='btn_huyban_". $mystore_arr[$k]['id'] ."' store_id='". $mystore_arr[$k]['id'] ."' value='Hủy Bán' /><br /><span id='huypl_view_". $mystore_arr[$k]['id'] ."'></span>";
                }
            }
		}
		else $error_module = $reponse;
	}
    
$page_template = "templates/chopl/banpl.tpl";
?>