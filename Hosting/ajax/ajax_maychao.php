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
 

$action = $_GET['action'];

switch ($action){ 
	case 'xoay_longcondor':
        $getcontent_url = $server_url . "/sv_maychao.php";
        $getcontent_data = array(
            'login'    =>  $_SESSION['mu_username'],
            'name'    =>  $_SESSION['mu_nvchon'],
            'action'    =>  'longcondor_quay',
            
            'pagesv'	=>	'sv_longcondor',
            'string_login'    =>  $_SESSION['checklogin'],
            'passtransfer'    =>  $passtransfer
        );
        
        $reponse = _getContent($getcontent_url, $getcontent_data, $getcontent_method, $getcontent_curl);
        
        if ( empty($reponse) ) $error_module = "Server bảo trì.";
        elseif($reponse == "login_other") {
        	$error_module = "Tài khoản đã được đăng nhập trên trình duyệt khác hoặc máy tính khác.";
        	session_destroy();
        }
        else {
        	if ( read_TagName($reponse, 'info', 1) == 'OK' ) {
                $success = read_TagName($reponse, 'success', 1);
                switch ($success){ 
                	case 0:
                        $msg = "Item bị thay đổi. Vui lòng load lại chức năng để cập nhập Item mới.";
                	break;
                
                	case 1:
                        $msg = "Ép thành công. Đã nhận được 1 Lông Vũ Condor.";
                	break;
                
                	case 2:
                        $msg = "Ép Lông vũ Condor thất bại. Toàn bộ Item bị mất.";
                	break;
                }
                echo "|OK|$success|$msg|";
        	} else echo $reponse;
        }
    break;
}





?>