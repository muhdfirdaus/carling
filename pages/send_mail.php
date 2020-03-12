<?php
session_start();
include('../dist/includes/mail_config.php');
include('../dist/includes/dbcon.php');
$branch = $_SESSION['branch'];
// $email = $_SESSION['email'];
$email =$_POST['email'];
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$query=mysqli_query($con,"select * from product  where branch_id='$branch' and remark like 'active%' and due_date <= DATE_ADD(CURDATE(),INTERVAL 30 DAY) order by equip_id");

$temporaryFolder = "tmp/";
if (!file_exists($temporaryFolder)) {
mkdir($temporaryFolder,0775,true);
}
$fp = fopen('tmp/overdue_tmp.csv', 'w+');

$content = "";
while($row=mysqli_fetch_field($query)){
    if(strlen($content)>1)
    { $content .= ", "; }
    $content .= $row->name;
}
$data[0] = array($content);
fputcsv($fp, $data[0]);
$content = "";
while($row=mysqli_fetch_array($query, MYSQLI_NUM)){
    $inside = "";
    for($i=0; $i<count($row); $i++){
        if($i>0)
        { $inside .= ", "; }
        $inside .= $row[$i];
    }
    fputcsv($fp, array($inside));
}

//Load Composer's autoloader
require '../vendor/autoload.php';
$receiverEmail = $email;
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $mHost;  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $mUname;                 // SMTP username
    $mail->Password = $mPass;                           // SMTP password
    $mail->SMTPSecure = $mSMTP;                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $mPort;         
    $mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);                           // TCP port to connect to

    //Recipients
    $mail->setFrom($mUname, 'CCMS-Mail');
    $mail->addAddress($receiverEmail, $_SESSION['name']);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('tmp/overdue_tmp.csv');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Overdue Item';
    $mail->Body    = 'This is the list of <b>overdue</b> item for your attention as of '.date('d-m-Y');
    $mail->AltBody = 'This is the list of overdue item for your attention as of '.date('d-m-Y');
    $mail->Body    .= '<br><br><i>CCMS System</i>';
    $mail->AltBody .= '<br><br><i>CCMS System</i>';

    $mail->send();
    echo'<script type="text/javascript">
	alert("Message has been sent");
	window.history.back();
	</script>';
} catch (Exception $e) {
    // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    echo'<script type="text/javascript">
	alert("Message could not be sent.");
	window.history.back();
	</script>';
}




?>