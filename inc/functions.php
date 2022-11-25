<?php

function login($username, $password, $conn) {
      //read from database
      $query = "SELECT * FROM users WHERE username='$username' OR email='$username' OR phone='$username' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if($result)	{
        if($result && mysqli_num_rows($result) > 0)	{
          $user_data = mysqli_fetch_assoc($result);
          // echo $user_data['username'];
          // echo $user_data['password'];
          // echo $user_data['id'];
          if($user_data['password'] === $password){
            // session_start();
            // $_SESSION['user_id'] = $user_data['user_id'];
            // $user_id = $user_data['id'];
            // echo "Login Success!";
            return array("login" => true, "user_id" => $user_data['id'], "username" => $user_data['username'], "email" => $user_data['email'], "firstname" => $user_data['firstname'], "lastname" => $user_data['lastname'], "phone" => $user_data['phone'],"usertype" => $user_data['usertype'], "reg_date" => $user_data['reg_date'], "last_login" => $user_data['last_login'], 'status'=>$user_data['status']);
            // header("Location: ../index.php?page=login&login_sucess");

            
          }else{
            header("Location: ../index.php?page=login&error=wc");
          }
        }else{
        header("Location: ../index.php?page=login&error=wc");


        }
      }      
}

function logout(){
  if (isset($_SESSION['user_data'])){
    session_destroy();
      foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
      }
      header("location: ../index.php");
    }else{
      header("location: ../index.php");
    }
}

function register($username, $firstname, $lastname, $email, $phone, $batch, $password, $OTPcode, $conn){
  $register = null;
  $errormsg = null;
  $msg = null;
  $query = "SELECT * FROM users WHERE (email='$email' OR username='$username' OR phone='$phone')";
	$result = mysqli_query($conn, $query);
  if($result){//check entered value in database
    if($result && mysqli_num_rows($result) > 0)	{//have account
      $user_data = mysqli_fetch_assoc($result);
      if ($user_data['phone'] == $phone) {
        $errormsg .= "-"."That phone number taken. Try another."."<br>";
      }
      if ($user_data['email'] == $email) {
        $errormsg .= "-"."That email address taken. Try another."."<br>";
      }
      if ($user_data['username'] == $username) {
        $errormsg .= "-"."That username taken. Try another."."<br>";
      }
      $register = false;
    }else{
      $sqlq = "INSERT INTO users (username, firstname, 	lastname, email, phone, batch, password, otp, status) VALUES('$username', '$firstname', '$lastname',  '$email', '$phone', '$batch', '$password', '$OTPcode', 0);";
      echo $sqlq;
      if ($conn->query($sqlq) === TRUE) {//record added
        $msg = "New user record created successfully<br>Registeration Successfull!..<br>Now you can login in our system";
        $register = true;

      }else{
        $errormsg = "No record found...<br>";
        $register = false;
      }

    }
  }else{
    $msg = "Database Error";
    $register = false;
  }
  return array("status" => true, "register" =>  $register, "errormsg" => $errormsg, "msg" => $msg,"username" => $username, "email" => $email, "phone" => $phone, 'OTP' => $OTPcode);
}

function avaBicycle($date, $time, $conn){
  $query = "SELECT * FROM bicycles WHERE status=1";
  $query_run = mysqli_query($conn, $query);
  $print_data = ""; //for error
    
    if(mysqli_num_rows($query_run) > 0)
    {   $record = false;
        $bookCard = "";
        foreach($query_run as $items)
        {
            $id = $items['id'];
            $name = $items['name'];
            $type = $items['type'];
            $b_num = $items['b_num'];
            $datetime = $date." ".$time;
            $query2 = "SELECT * FROM booking WHERE bid = $id AND required <= '$datetime' AND handover >= '$datetime'";
            $query_run2 = mysqli_query($conn, $query2);

            $print_data .= '_'.mysqli_num_rows($query_run2);//for error

            if(mysqli_num_rows($query_run2) === 0){
              $bookCard .='<div class="book-card">
                              <div class="up">
                                      <h4>
                                          '.$name.'
                                          <br>
                                          '.$type.'
                                          <br>
                                          '.$b_num.'
                                      </h4>

                                  </div>
                                  <div class="down">
                                      <a href="?page=booking&bicycle='.$id.'&date='.$date.'&time='.$time.'">
                                          <button>
                                              Available
                                          </button>
                                      </a>
                                  </div>
                            </div>';
              $record = true;
            }
        }
    }
    return array("record" => $record, "book_card" => $bookCard, 'print_data' => $print_data, 'date' => $date);
}

function bookingTable($userid, $conn){
    $query = "SELECT * FROM booking WHERE uid=$userid ORDER BY oder DESC";
    $query_run = mysqli_query($conn, $query);
    $tbody = "";
    if(mysqli_num_rows($query_run) > 0){
      foreach($query_run as $items){
        $id = $items['id'];
        $bid = $items['bid'];
        $uid = $items['uid'];
        $required = strtotime($items['required']);
        $handover = strtotime($items['handover']);
        $comment = $items['comment'];
        $oder = $items['oder'];
        $status = $items['status'];
        $tbody .= '<tr>';
        $tbody .= '<td>'.$bid.'</td><td>'.date("Y-m-d", $required).'</td><td>'.date("H:i:s", $required).'</td><td>'.date("Y-m-d", $handover).'</td><td>'.date("H:i:s", $handover).'</td>';
        $tbody .= '</tr>';
      }
      return $tbody;
    }else{
      return "<tr><td colspan='5'>No booking data.</td></tr>";
    }

}

function bookingApprovalTable($status, $conn){
  $query = "SELECT * FROM booking WHERE status=$status ORDER BY oder DESC";
  $query_run = mysqli_query($conn, $query);
  $tbody = "";
  if(mysqli_num_rows($query_run) > 0){
    foreach($query_run as $items){
      $id = $items['id'];
      $bid = $items['bid'];
      $uid = $items['uid'];
      $query2 = "SELECT * FROM users WHERE id='$uid' LIMIT 1";
      $result2 = mysqli_query($conn, $query2);
      if($result2)	{
        if($result2 && mysqli_num_rows($result2) > 0)	{
          $userdata = mysqli_fetch_assoc($result2);
          $username = $userdata['username'];
          $phone = $userdata['phone'];
        }else{
          $username = "No 1";
          $phone = "No 1";
        }
      }else{
        $username = "No 2";
        $phone = "No 2";
      }
      $required = strtotime($items['required']);
      $handover = strtotime($items['handover']);
      $comment = $items['comment'];
      $oder = $items['oder'];
      $status = $items['status'];
      $tbody .= '<tr>';
      if($status == 1){
        $tbody .= '<td>'.$id.'</td><td>'.date("Y-m-d", $required).'</td><td>'.date("H:i:s", $required).'</td><td>'.date("Y-m-d", $handover).'</td><td>'.date("H:i:s", $handover).'</td><td>'.$username.'</td><td>'.$phone.'</td><td><form action="inc/action.php" method="post"><button type="submit" class="apprbtn" value="'.$id.'" name="bapprove">Approve</button></form></td><td><form action="inc/action.php" method="post"><button class="cnclbtn" type="submit" value="'.$id.'" name="bcancel">Cancel</button></form></td>';
      }elseif($status == 4){
        $rented = strtotime($items['rented']);
        $tbody .= '<td>'.$bid.'</td><td>'.date("Y-m-d", $rented).'</td><td>'.date("H:i:s", $rented).'</td><td>'.date("Y-m-d", $handover).'</td><td>'.date("H:i:s", $handover).'</td>';
      }elseif($status == 5){
        $rented = strtotime($items['rented']);
        $returned = strtotime($items['returned']);
        $tbody .= '<td>'.$bid.'</td><td>'.date("Y-m-d", $rented).'</td><td>'.date("H:i:s", $rented).'</td><td>'.date("Y-m-d", $returned).'</td><td>'.date("H:i:s", $returned).'</td>';
      }
      $tbody .= '</tr>';
  
    }
    return $tbody;
  }else{
    if($status == 1){
      return "<tr><td colspan='9'>No approval data.</td></tr>";
    }elseif($status == 4){
      return "<tr><td colspan='5'>No rented data.</td></tr>";
    }elseif($status == 5){
      return "<tr><td colspan='5'>No returned data.</td></tr>";
    }
  }

}

function bookABicycle($bid, $uid, $brdate, $brtime, $bhdate, $bhtime, $comment, $conn){
  $brdatetime = $brdate." ".$brtime;
  $bhdatetime = $bhdate." ".$bhtime;
  $msg = false;
  $sqlq = "INSERT INTO booking (bid, uid, required, handover, comment, status) VALUES('$bid', '$uid', '$brdatetime', '$bhdatetime', '$comment', 1);";
  if ($conn->query($sqlq) === TRUE) {//record added
    $query = "SELECT id FROM booking WHERE uid=$uid ORDER BY oder DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result)	{
      if($result && mysqli_num_rows($result) > 0)	{
        $bookid = mysqli_fetch_assoc($result)['id'];
      }else{
        $bookid = false;
      }
    }else{
      $bookid = false;
    }
    
    $msg = true;
  }else{
    $msg = false;
    $bookid = false;
  }
  return array('msg' => $msg, 'date' => $brdate, 'time' => $brtime, 'bookid' => $bookid);
}

function approveOrCancel($inqid, $status, $conn){
    if($status == 1){
      $sql = "UPDATE booking SET status='$status' WHERE id='$inqid' LIMIT 1";
    }elseif($status == 4){
      $sql = "UPDATE booking SET status='$status', rented=Now() WHERE id='$inqid' LIMIT 1";
    }elseif($status == 5){
      $sql = "UPDATE booking SET status='$status', returned=Now() WHERE id='$inqid' LIMIT 1";
    }else{
      $sql = "UPDATE booking SET status='$status' WHERE id='$inqid' LIMIT 1";
    }
    if ($conn->query($sql) === TRUE) {
        return "<center><div class='error' style=' border:1px solid #a33a3a; color: #270;  background-color: #DFF2BF; border-radius:1px;padding:5px;margin:2px 10px%'>Moved to Accepted successfully</div><br>";
      }
    else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

function lanChange($lan){
  $_SESSION['lan'] = $lan;
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function  bTable($conn){
    $query = "SELECT * FROM bicycles;";
    $query_run = mysqli_query($conn, $query);
    $tbody = "";
    if(mysqli_num_rows($query_run) > 0){
      foreach($query_run as $items){
        $id = $items['id'];
        $bname = $items['name'];
        $btype = $items['type'];
        $bnum = $items['b_num'];
        $status = $items['status'];
        $regdate = $items['reg_date'];
        $comment = $items['comment'];
        $tbody .= '<tr>';
        $tbody .= '<td>'.$id.'</td><td>'.$bname.'</td><td>'.$btype.'</td><td>'.$bnum.'</td><td>'.$regdate.'</td><td>'.$comment.'</td>';
        $tbody .= '</tr>';
      }
      return $tbody;
    }else{
      return "<tr><td colspan='6'>No booking data.</td></tr>";
    }
}

function addABicycle($bname, $btype, $bnum, $comment, $uid, $conn){
  $msg = false;
  $sqlq = "INSERT INTO bicycles(name, type, b_num, comment, uid, status) VALUES('$bname', '$btype', '$bnum', '$comment', '$uid', 1);";
  if ($conn->query($sqlq) === TRUE) {//record added
    $msg = true;
  }else{
    $msg = false;
  }
  return array('msg' => $msg);
}

function inqFind($inqid, $conn){
  $query = "SELECT * FROM booking WHERE id='$inqid' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if($result)	{
        if($result && mysqli_num_rows($result) > 0)	{
          $bdata = mysqli_fetch_assoc($result);
          return array("inqu" => true, "inqid" => $inqid, "bid" => $bdata['bid'], "uid" => $bdata['uid'], "oder" => $bdata['oder'],"required" => $bdata['required'], "handover" => $bdata['handover'],"rented" => $bdata['rented'],"returned" => $bdata['returned'], "comment" => $bdata['comment']);
        }else{
          return array("inqu" => false, "inqid" => $inqid, "error"=> "wr");
        }
      }else{
        return array("inqu" => false, "inqid" => $inqid, "error"=> "wr");
      }
}

function verifyEmail($username, $email, $otp, $conn){
  $query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $query);
      if($result)	{
        if($result && mysqli_num_rows($result) > 0)	{
          $user_data = mysqli_fetch_assoc($result);
          if($user_data['OTP'] === $otp){
            $uid = $user_data['id'];
            $sql = "UPDATE users SET status=1, OTP=null WHERE id='$uid' LIMIT 1";
            if ($conn->query($sql) === TRUE) {
              return array("verify" => true, "user_id" => $user_data['id'], "username" => $user_data['username'], "email" => $user_data['email'], "phone" => $user_data['phone'],"usertype" => $user_data['usertype'], "reg_date" => $user_data['reg_date'], "last_login" => $user_data['last_login'], 'status'=>$user_data['status']); 
            }
          else {
              return "Error: " . $sql . "<br>" . $conn->error;
          }
          }else{
            header("Location: ../index.php?page=verify&error=wc");
          }
        }else{
        header("Location: ../index.php?page=verify&error=wc");
        }
      }
    }
?>