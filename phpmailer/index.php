<?php
 
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'paurushankit5@gmail.com';                 // SMTP username
$mail->Password = '21feb1993';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('info@getindustrialproducts.com', 'GETINDUSTRIALPRODUCTS');
$mail->addAddress('paurush.oph@gmail.com', 'Joe User');     // Add a recipient
$mail->addAddress('onlinepromotionhouse@gmail.com');               // Name is optional
//$mail->addAddress('onlinepromotionhouse@gmail.com');               // Name is optional
$mail->addReplyTo('paurushankit5@gmail.com', 'Paurush');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';

$mail->Body   .= '<div style="width:100%; border:0px solid black">
	<div style="margin:0px;width:100%; border-bottom:1px solid black">
		<div style="padding:20px;width:50%;">
			<a href="http://getindustrialproducts.com/"><img src="http://getindustrialproducts.com/img/logo2.png" alt="GIP Logo"></a>
		</div>
	</div>
	<div style="width:100%;margin:0px;">
		 
		 
		<center><h1 style="color:#2699FF;font-size:50px;">Welcome to GIP</h1></center>
		<br>
		 <center><h1 style="color:black;">We are Working For</h1></center>
		 <br>
		 <div style="margin-left:100px;margin-right:100px;">
			<div style="width:33%;height:auto;float:left">
				<center><img src="http://getindustrialproducts.com/b2badmin/images/1/industrial_banner.jpg"  
												style="height:180px; width:300px"/>
												<h2><a href="http://getindustrialproducts.com/subcategory-list.php?id=1">Industrial Machinery and Tools</a></h2></center>
			</div>
			<div style="width:33%;height:auto;float:left">
				<center><img src="http://getindustrialproducts.com/b2badmin/images/2/BoltSlider1-1.jpg"  
												style="height:180px; width:300px"/>
												 <h2><a href="http://getindustrialproducts.com/subcategory-list.php?id=2">Industrial Machinery and Tools</a></h2></center>
			</div>
			<div style="width:33%;height:auto;float:left">
				<center><img src="http://getindustrialproducts.com/b2badmin/images/3/mechanical-parts-and-spares.jpg"  
												style="height:180px; width:300px"/>
												<h2><a href="http://getindustrialproducts.com/subcategory-list.php?id=3">Industrial Machinery and Tools</a></h2></center>
			</div>			
		 </div>
		 <div style="width:100%;clear:both;margin:0px 100px;">
		 <br>
		 <br>
			<h3><a href="http://getindustrialproducts.com/seller" style="border-radius:10px solid red;background-color:red; padding:20px; color:white">Click Here</a>
			to register Yourself and sell and buy industrial products with an ease.</h3>
			<br>
			<br>
			<br>
			<br>
			<br>
		 </div>
		 
	</div>
</div>';
 

 

$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
echo $mail->Body;
 
?>