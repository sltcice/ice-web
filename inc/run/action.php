<?php
include "connect.php";
include "functions.php";
session_start();
// if(isset($_SESSION['user_id'])){
// 	header("Location: index.php?l=s");
// }
// PHP Mailer



print_r($_POST);

die();
if(isset($_POST['loginsubmit'])){
  logout();
	$username = $_POST['loginusername'];
	$password = $_POST['loginpassword'];
  // echo $uname." ".$password;
  $user_data = login($username, $password, $conn);
  $_SESSION['user_data'] = $user_data;
  if($_SESSION['user_data']['login']){
     header("Location: ../../?page=profile&login_sucess");
  }

}elseif(isset($_POST['verify'])){
	$username = $_POST['username'];
	$email = $_POST['email'];
  $otp = $_POST['otp'];
  $user_data = verifyEmail($username, $email, $otp, $conn);
  $_SESSION['user_data'] = $user_data;
  print_r($user_data);
  if($_SESSION['user_data']['verify']){
    $mail->addAddress($_SESSION['user_data']['email'], $_SESSION['user_data']['username']);
    $mail->Subject = 'SLTC BRS Registration';
    $mail->Body    = 'Dear '.$_SESSION['user_data']['username'].', Your Email verifyed successfull. Now you can login SLTC BRS. https://brs.tute.lk?page=login';
    if($mail->send()){
      logout();
      header("Location: ../index.php?page=account&emailverifyed");
    }else{
      header("Location: ../index.php?page=login&register&emailerror");
    }
     header("Location: ../index.php?page=account&verify_sucess");
  }

}elseif(isset($_POST['registersubmit'])){
  // echo "register";
// ====================Register===============
	$firstname = $_POST['registerfirstname'];
	$lastname = $_POST['registerlastname'];
	$dob = $_POST['registerdob'];
	$sltcindex = $_POST['registersltcindex'];
  $email = $_POST['registeremail'];
  $sltcemail = $_POST['registeremailsltc'];
  $phone = $_POST['registerphone'];
  $batch = $_POST['registerbatch'];
  $username = $_POST['registerusername'];
	$password = $_POST['registerpassword'];
  $OTPcode = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
  $register_data = register($username, $firstname, $lastname, $email, $phone, $batch, $password, $OTPcode, $conn);
  print_r($register_data);
  $_SESSION['register_data'] = $register_data;
  if(isset($_SESSION['register_data']['register'])){
    $mail->addAddress($_SESSION['register_data']['email'], $_SESSION['register_data']['username']);
    $mail->Subject = 'SLTC BRS Registration';
    $mail->Body    = 'Dear '.$_SESSION['register_data']['username'].', Please confirm youre email address. youre OTP code is: '.$_SESSION['register_data']['OTP'];
    if($mail->send()){
      header("Location: ../index.php?page=verify&register&sendverify");
    }else{
      header("Location: ../index.php?page=login&register&emailerror");
    }
    
  }
  // $user_data = login($uname, $password, $conn);
  // $_SESSION['user_data'] = $user_data;
  // if($_SESSION['user_data']['login']){
  //    header("Location: ../index.php?page=login&login_sucess");
  // }
}elseif(isset($_POST['book'])){
  $book = bookABicycle($_POST['bid'], $_SESSION['user_data']['user_id'], $_POST['brdate'], $_POST['brtime'], $_POST['bhdate'], $_POST['bhtime'], $_POST['comment'], $conn);
  if($book['msg']){
    if(isset($book['bookid'])){
      $mail->addAddress($_SESSION['user_data']['email'], $_SESSION['user_data']['username']);
      $mail->Subject = 'Bicycle Booking Success.';
      $mail->Body    = "Wait to admin approve,
      inquery number is: -- ".$book['bookid']."
      bicycle id: -- ".$_POST['bid']."
      Required on: -- ".$_POST['brdate']."
      Required at: -- ".$_POST['brtime']."
      Handover on: -- ".$_POST['bhdate']."
      Handover at: -- ".$_POST['bhtime'];
      if($mail->send()){
        header("Location: ../index.php?page=booking&date=".$book['date']."&time=".$book['time']."&emailsent");
      }else{
        header("Location: ../index.php?page=booking&date=".$book['date']."&time=".$book['time']."&emailerror");
      }
    }else{
      header("Location: ../index.php?page=booking&date=".$book['date']."&time=".$book['time']."&emailerror");
    }
  }else{
    header("Location: ../index.php?page=booking&Error");
  }
}elseif(isset($_POST['badd'])){
  $addb = addABicycle($_POST['bname'],$_POST['btype'], $_POST['bnumber'], $_POST['comment'], $_SESSION['user_data']['user_id'], $conn);
  if($addb ['msg']){
    header("Location: ../index.php?page=bsetup&adedsuccess");
  }else{
    header("Location: ../index.php?page=bsetup&Error");
  }
}else{

  // header("Location: ../index.php?page=login&error=wk");
}

if(isset($_GET['logout'])){
  logout();
}

if(isset($_POST['bapprove'])){
  $inqid = $_POST['bapprove'];
  echo approveOrCancel($inqid, 2, $conn);
  $query = "SELECT * FROM booking WHERE id=$inqid LIMIT 1";
  $result = mysqli_query($conn, $query);
  if($result)	{
    if($result && mysqli_num_rows($result) > 0)	{
      $bookdata = mysqli_fetch_assoc($result);

      
      $query2 = "SELECT * FROM users WHERE id=".$bookdata['uid'].";";
      $result2 = mysqli_query($conn, $query2);
      if($result2){
        if($result2 && mysqli_num_rows($result2) > 0)	{
          $udata = mysqli_fetch_assoc($result2);
          $uid = $udata['id'];
          $uemail = $udata['email'];
          $uname = $udata['username'];


      
      $mail->addAddress($uemail, $uname);
      $mail->Subject = 'Admin Approved Youre Request...';
      $mail->Body    = "Now admin approved youre request,
inquery number is: -- ".$bookdata['id']."
bicycle id: -- ".$bookdata['bid']."
Required on: -- ".$bookdata['required']."
Handover on: -- ".$bookdata['handover'];
      if($mail->send()){
        header("Location: ../index.php?page=bapproval&approved_success&emailsent");
      }else{
        header("Location: ../index.php?page=bapproval&approved_success&emailerror");
      }
    }
  }
    }else{
      $bookid = false;
    }
  }else{
    $bookid = false;
  }
  
}elseif(isset($_POST['bcancel'])){
  $inqid = $_POST['bcancel'];
  approveOrCancel($inqid, 3, $conn);
  $query = "SELECT * FROM booking WHERE id=$inqid LIMIT 1";
  $result = mysqli_query($conn, $query);
  if($result)	{
    if($result && mysqli_num_rows($result) > 0)	{
      $bookdata = mysqli_fetch_assoc($result);

      $query2 = "SELECT * FROM users WHERE id=".$bookdata['uid'].";";
      $result2 = mysqli_query($conn, $query2);
      if($result2){
        if($result2 && mysqli_num_rows($result2) > 0)	{
          $udata = mysqli_fetch_assoc($result2);
          $uid = $udata['id'];
          $uemail = $udata['email'];
          $uname = $udata['username'];


          $mail->addAddress($uemail, $uname);

      $mail->Subject = 'Admin canceled Youre Request...';
      $mail->Body    = "Now admin canceled youre request,
inquery number is: -- ".$bookdata['id']."
bicycle id: -- ".$bookdata['bid']."
Required on: -- ".$bookdata['required']."
Handover on: -- ".$bookdata['handover'];
      if($mail->send()){
        header("Location: ../index.php?page=bapproval&canceled_success&emailsent");
      }else{
        header("Location: ../index.php?page=bapproval&canceled_success&emailerror");
      }
    }
  }
    }else{
      $bookid = false;
    }
  }else{
    $bookid = false;
  }
}elseif(isset($_POST['brented'])){
  $inqid = $_POST['brented'];
  approveOrCancel($inqid, 4, $conn);
  $query = "SELECT * FROM booking WHERE id=$inqid LIMIT 1";
  $result = mysqli_query($conn, $query);
  if($result)	{
    if($result && mysqli_num_rows($result) > 0)	{
      $bookdata = mysqli_fetch_assoc($result);

      $query2 = "SELECT * FROM users WHERE id=".$bookdata['uid'].";";
      $result2 = mysqli_query($conn, $query2);
      if($result2){
        if($result2 && mysqli_num_rows($result2) > 0)	{
          $udata = mysqli_fetch_assoc($result2);
          $uid = $udata['id'];
          $uemail = $udata['email'];
          $uname = $udata['username'];



          $mail->addAddress($uemail, $uname);

      $mail->Subject = 'Rented bicycle - BRS SLTC';
      $mail->Body    = "Now rented bicycle,
inquery number is: -- ".$bookdata['id']."
bicycle id: -- ".$bookdata['bid']."
Required on: -- ".$bookdata['required']."
Rented on: -- ".$bookdata['rented']."
Handover on: -- ".$bookdata['handover'];
      if($mail->send()){
        header("Location: ../index.php?page=imanage&rented_success&emailsent");
      }else{
        header("Location: ../index.php?page=imanage&rented_success&emailerror");
      }
    }
  }
    }else{
      $bookid = false;
    }
  }else{
    $bookid = false;
  }
}elseif(isset($_POST['breturned'])){
  $inqid = $_POST['breturned'];
  approveOrCancel($inqid, 5, $conn);
  $query = "SELECT * FROM booking WHERE id=$inqid LIMIT 1";
  $result = mysqli_query($conn, $query);
  if($result)	{
    if($result && mysqli_num_rows($result) > 0)	{
      $bookdata = mysqli_fetch_assoc($result);

      $query2 = "SELECT * FROM users WHERE id=".$bookdata['uid'].";";
      $result2 = mysqli_query($conn, $query2);
      if($result2){
        if($result2 && mysqli_num_rows($result2) > 0)	{
          $udata = mysqli_fetch_assoc($result2);
          $uid = $udata['id'];
          $uemail = $udata['email'];
          $uname = $udata['username'];


          $mail->addAddress($uemail, $uname);

      $mail->Subject = 'Rented bicycle - BRS SLTC';
      $mail->Body    = "Now rented bicycle,
inquery number is: -- ".$bookdata['id']."
bicycle id: -- ".$bookdata['bid']."
Required on: -- ".$bookdata['required']."
Rented on: -- ".$bookdata['rented']."
Handover on: -- ".$bookdata['handover']."
Returned on: -- ".$bookdata['returned'];
      if($mail->send()){
        header("Location: ../index.php?page=rmanage&returned_success&emailsent");
      }else{
        header("Location: ../index.php?page=rmanage&returned_success&emailerror");
      }

    }}
    }else{
      $bookid = false;
    }
  }else{
    $bookid = false;
  }
}


if(isset($_POST['lan'])){
  lanChange($_POST['lan']);
}

// $date = '2022-10-17 11:00:00';
// print_r(avaBicycle($date, $conn));



?>