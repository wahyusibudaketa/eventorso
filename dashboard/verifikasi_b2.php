<!DOCTYPE HTML>
<?php
session_start();
if(!isset($_SESSION['eventorso_iduser'])){
  header("location:../login/");
}
require_once ("../config/config.php");

if(isset($_POST['sendcode'])){
date_default_timezone_set('Etc/UTC');
require_once "../phpmail/PHPMailerAutoload.php";
$mail = new PHPMailer;
$body             = file_get_contents('contents.html');
// $body             = eregi_replace("[\]",'',$body); bananacreativehuis@gmail.com orangila2016

$mail->isSMTP();
$mail->SMTPDebug = 1;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'TLS';
$mail->SMTPAuth = true;
$mail->Username = "bananacreativehuis@gmail.com";
$mail->Password = "orangila2016";
$mail->setFrom('support@eventorso.com', 'Support Center Eventorso');
$mail->addReplyTo('support@eventorso.com', 'Support Center Eventorso');
$mail->addAddress($_POST['s_email'], 'Vendor Event');
$mail->Subject = 'Kode Verifikasi Akun Eventorso';
$mail->msgHTML($body);
$mail->AltBody = 'This is a plain-text message body';
// $mail->addAttachment('../web/images/logo.png');

if (!$mail->send()) {
    echo "KODE VERIFIKASI GAGAL TERKIRIM";
} else {
    echo "KODE VERIFIKASI SUDAH TERKIRIM";
}
}


    $data=array("");
    $query="SELECT a.id,a.api,a.activation,a.email,a.password 
            FROM troopers a, tb_cities b, tb_category_service c
            WHERE a.id_city=b.id
            AND a.id_service=c.id
            AND a.id='$_SESSION[eventorso_iduser]'";
    $res=$db->fetch_multiple_rows($data,$query);
    $count=$res->rowCount();

?>
<html>
	<head>

    <title>Event Vendors Market Place</title>
    <meta charset="UTF-8">
    <meta property="og:type" content="website" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0" />
    <meta name="description" content="" />
    <link href="../web/css/application.css" type="text/css" version="desktop" method="normal" rel="stylesheet">
    <link href="../web/images/favicon.png" type="image/x-icon" rel="shortcut icon"/>
        
        <style type="text/css">
    .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
    </style>

<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>

<!-- UPLOAD IMAGE ONE -->
<script type="text/javascript" >
 $(document).ready(function() { 
    $('#photoimg').live('change', function(){
        $("#preview").html('');
        $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
        $("#imageform").ajaxForm({
          target: '#preview'
        }).submit();

    });

  }); 
</script>

 <script type="text/javascript">
        function OnClickButton () {
          $.post('savesetting.php',{post_email:$('#pemail').val(),
                                          post_sandi:$('#psandi').val()
                        });
            // alert ("You clicked on the button!");
            window.location.assign("setting.php"); 
        }
    </script>

</head>

	<body>
		<br>
				

    <header id="header2" class="l-header2 pos-fixed new" style="height:70px;">
      <div class="box2 p2-0 m2-auto wrapper2 relative " ng-controller="MenuController as menuCtrl">
        <nav id="main-menu2" class="left brandon f-s-11" style="margin-top: 10px;">
            <a target="_top" class="bs_logo left-none" href="../" title="Event Vendor Directory"></a>
            <!-- <a target="_top" href="#" style="text-transform: uppercase;"><h5>HOT VENDORS</h5></a> -->
            <!-- <a target="_top" href="#" style="text-transform: uppercase;"><h5>HOT SERVICE</h5></a> -->
            <!-- <a target="_top" href="#" style="text-transform: uppercase;"><h5>GUIDE EVENT</h5></a> -->
        </nav>
        <nav style="margin-top: 15px;" id="sub-menu-not-login" class="right f-brandon f-td-n">

          <?php
            if(isset($_SESSION['eventorso_session'])){
              if($_SESSION['eventorso_level']=="0"){
          ?>

          <ul id="sub-menu" class="right ng-scope">
            <li class="pic"><img src="../web/images/pic.jpg"></li>
            <li class="dropdown">
              <a target="_self" class="profile dropdown-toggle ng-scope" id="profile" href="../">
                <span class="ng-binding"><?php echo $_SESSION['eventorso_fullname'];?></span>
                <b class="bs-icon-down"></b>
              </a>

              <ul class="dropdown-menu2" role="menu" aria-labelledby="profile">
                <div ng-if="menuCtrl.isVendor()" class="ng-scope">
                  <li><a rel="nofollow" href="" target="_self">
                    <span><img src="web/images/favicon.png" height="20" width="20"></span>My Dashboard</a>
                  </li>
                </div>
                <li class="divider"></li>
                <li><a rel="nofollow" ng-click="menuCtrl.naviLogout()" href="../logout.php" target="_self">
                  <span><img src="../web/images/favicon.png" height="20" width="20"></span>Logout</a>
                </li>
              </ul>
            </li>
          </ul>
      
          <?php
            }else{
          ?>

          <ul id="sub-menu" class="right ng-scope" ng-if="(menuCtrl.isLogged() menuCtrl.isVerified())">
            <li class="pic"><img src="../web/images/pic.jpg"></li>
            <li class="dropdown">
              <a target="_self" class="profile dropdown-toggle ng-scope" id="profile" href="">
                <span class="ng-binding"><?php echo $_SESSION['eventorso_business_name'];?></span>
                <b class="bs-icon-down"></b>
              </a>

              <ul class="dropdown-menu2" role="menu" aria-labelledby="profile">
                <div ng-if="menuCtrl.isVendor()" class="ng-scope">
                  <li><a rel="nofollow" href="" target="_self"><span><img src="../web/images/favicon.png" height="20" width="20"></span>My Dashboard</a></li>
                  <li><a target="_blank" href="../explore/?view=<?php echo $_SESSION['eventorso_iduser'];?>"><span><img src="../web/images/favicon.png" height="20" width="20"></span>View My Explore</a></li>
                  <li><a rel="nofollow" href="add_brosur.php" target="_self"><span><img src="../web/images/favicon.png" height="20" width="20"></span>Upload New Brosur</a></li>
                </div>

                <li class="divider"></li>
                <li><a href="../logout.php" target="_self"><span><img src="../web/images/favicon.png" height="20" width="20"></span>Logout</a></li>
              </ul>
            </li>
          </ul>

            <?php
               }
             }else{
            ?>
            
            <a href="../register/vendor" class="register b-vendor brandon bold">Join vendor</a>
            <a href="../login" class="brandon bold">Login</a>
              <?php
            }
          ?>
        </nav>
      </div>
    </header>

<header id="subheader2" style="height: 0px; margin-top:10px;" class="l-header2 new pos-fixed" ng-controller="vendorSearchController as vendorSearch">
            <div id="dashboard-pagesub2" class="box no-padding line-bottom bg2-white" js-fixed-on-scroll="#subheader-container" fos-liveupdate="" fos-offset="#subheader-dashboard">
                <div class="box wrapper no-padding">
                    <ul class="menu_tab_new">
                        <li class="right mt_7 nohover">
                          <?php
                            if($_SESSION['eventorso_level']==0){

                            }else{
                              ?>
                            <a href="../explore/?view=<?php echo $_SESSION['eventorso_iduser'];?>" target="_self">
                                <button class="btn btn-stronk with-border right w-140 btn-no-sidepadding btn-loader" >VIEW EXPLORE</button>
                            </a>
                              <?php
                            }
                          ?>
                        </li>
                        <li js-tab="" tab-anchor="#profile"><a href="index.php">My Profile</a></li>
                        <?php 
                            if($_SESSION['eventorso_level']==0){
                                echo '<li js-tab="" tab-anchor="#myevent"><a href="myevent.php">My Event</a></li>';
                            }else{
                                echo '<li js-tab="" tab-anchor="#brosur"><a href="brosur.php">My Brosur</a></li>';
                            }
                        ?>
                        <li js-tab="" tab-anchor="#Pengaturan"><a href="setting.php">PENGATURAN</a></li>
                        <li js-tab="" tab-anchor="#verivikasi" class="is-active"><a href="">VERIFIKASI</a></li>

                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
</header>
<!--  -->
<?php
      while ($key=$res->fetch()) {
      
        
?>
<div id="edit-profile" class="box no-padding wrapper mb-50 tab-content" style="display:block;margin-top: 70px;">
    <div id="edit-1" class="box no-padding right form" style="width: inherit;">
        
                        <div id="business_detail" class="brandon small line-bottom pb-10">STATUS AKUN</div>


                            <div class="row mt-10">
                                <p>AKUN ANDA BELUM VERIFIKASI...!</p>
                                <p>SEGERA LAKUKAN VERIFIKASI, KODE VERIFIKASI DIKIRIM KE EMAIL ANDA</p>
                            </div>

                            <div class="row mt-10">
                                <label>
                                    <!-- <span class="form-title icon-required">Email</span> -->
                                    <input placeholder="Masukan kode verifikasi" id="pcode" value="" name="xcode" class="ng-pristine ng-valid ng-valid-required">
                                        
                                </label>
                                <p class="form-msg">Email tidak boleh kosong</p>
                            </div>

                            <div>
                               <button onclick="" class="btn with-border w-130">VERIFIKASI </button>
                             </div>

<br>

                            <div class="row mt-10">
                                <p>Kenapa Harus Verfikasi..?</p>
                                <p>1. Memastikan Bahawa Anda adalah Vendor Aktif Eventorso.</p>
                                <p>2. Brosur Anda dapat dilihat oleh Pengunjung Eventorso.</p>
                                <p>3. Menjaga Keamanan Data dan Informasi yang Anda buat di Eventorso.</p>
                            </div>


                            <div class="row mt-20">
                                <p>JIKA ANDA TIDAK MENERIMA EMAIL VERIFIKASI, KLIK TOMBOL "KIRIM KODE" DI BAWAH.</p>
                            
                                <p>KODE VERIFIKASI AKAN DIKIRIM KE EMAIL ANDA</p>

                            </div>
                
        <form class="form" name="form_login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input name="s_email" value="<?php echo $key->email;?>" style="display:gone;">
                                        
                                  <div>
                                    <button type="submit" name="sendcode" class="btn with-border w-130">KIRIM KODE</button>
                                  </div>
                                </form>
                    </div>
                </div>
<?php
}
?>
<!--  -->

</body>
</html>