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
$leng_cuphap = strlen($cuphap);
if($leng_cuphap == 0) echo "<center><font color='red'>Chưa thiết lập cấu hình SMS. Vui lòng liên hệ BQT để được hỗ trợ.</font></center>";
else {

if (isset($_POST['action']))
{
	$action = $_POST['action'];

	if ($action == 'changepass1')
	{
		$pass1new = $_POST['pass1new'];
		$pass1new_verify = $_POST['pass1new_verify'];
		
		$leng_pass1new = strlen($pass1new);
		
		if( $sendsv === false ) { $notice = "Tốc độ xử lý của bạn quá nhanh, vui lòng chờ vài giây rồi tiếp tục thực hiện."; }
		elseif(empty($pass1new)) {
			$notice = "Chưa nhập Mật khẩu Web mới";
		}
		elseif(empty($pass1new_verify)) {
			$notice = "Chưa xác minh Mật khẩu Web mới";
		}
		elseif (preg_match("/[^a-zA-Z0-9_$]/", $pass1new))
			{
				$notice = "<font size='4' color='red'>Dữ liệu lỗi - Mật khẩu Webmới chỉ được sử dụng kí tự a-z, A-Z, số (1-9) và dấu _.</font>";
			}
		elseif (preg_match("/[^a-zA-Z0-9_$]/", $pass1new_verify))
			{
				$notice = "<font size='4' color='red'>Dữ liệu lỗi - Xác minh Mật khẩu Web chỉ được sử dụng kí tự a-z, A-Z, số (1-9) và dấu _.</font>";
			}
		elseif ($pass1new != $pass1new_verify)
			{
				$notice = "<font size='4' color='red'>Dữ liệu lỗi - Mật khẩu Web mới và Xác minh mật khẩu Web mới không trùng khớp.</font>";
			}
		elseif($leng_pass1new<4)
			{
				$notice = "<font size='4' color='red'>Dữ liệu lỗi - Mật khẩu Web mới phải có ít nhất 4 kí tự.</font>";
			}
		else {
			
			$getcontent_url = $server_url . "/sms_web.php";
            $getcontent_data = array(
                'login'    =>  $_SESSION['mu_username'],
                'KeyXuLy'    =>  'CHANGEPASS1',
                'pass1new'    =>  $pass1new,
                'string_login'    =>  $_SESSION['checklogin'],
                'passtransfer'    =>  $passtransfer
            ); 
            
            $reponse = _getContent($getcontent_url, $getcontent_data, $getcontent_method, $getcontent_curl);

			if ( empty($reponse) ) $notice = "<font size='3' color='red'>Server bảo trì.</font>";
			elseif($reponse == "login_other") {
				$notice = "<font size='3' color='red'>Tài khoản đã được đăng nhập trên trình duyệt khác hoặc máy tính khác.</font>";
				session_destroy();
			}
			else {
				$info = explode('<nbb>',$reponse);
				if($info[1] == 'OK') {
					
					$notice = "<font color='black'>Vui lòng dùng SĐT của tài khoản nhắn tin với cú pháp bên dưới để hoàn tất</font><br>
						<font color='red'><b>VNU&nbsp;&nbsp;&nbsp;$cuphap&nbsp;&nbsp;&nbsp;$info[2]</b></font>&nbsp;&nbsp;&nbsp;gửi&nbsp;&nbsp;&nbsp;<font color='blue'><b>8185</b></font> <font color='gray'><i>(Phí nhắn tin : 1.000 VNĐ)</i></font><br>
						<font color='black'>Thời gian chờ tin nhắn chứng thực : 60 phút (sau 60 phút, yêu cầu sẽ bị hủy bỏ)</font>";
				}
				else $notice = $reponse;
			}
		}
	}
}

$page_template = "templates/acc_manager/changepass1.tpl";
}
?>