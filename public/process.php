<?php
if( isset($_POST) ){

  //form validation vars
  $formok = true;
  $errors = array();

  //sumbission data
  $ipaddress = $_SERVER['REMOTE_ADDR'];
  $date = date('m/d/Y');
  $time = date('H:i:s');

  //form data
  $email = $_POST['email'];

  //validate form data

  //validate email address is not empty
  if(empty($email)){
    $formok = false;
    $errors[] = "You have not entered an email address";
  //validate email address is valid
  }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $formok = false;
    $errors[] = "You have not entered a valid email address";
  }

  //send email if all is ok
  if($formok){
    $headers = "From: website@website.com" . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $emailbody = "<p>You have recieved a new message from the inquiries form on your website.</p>
            <p><strong>Email Address: </strong> {$email} </p>
            <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";

    mail("\jacemontoya@hotmail.com","New Inquiry",$emailbody,$headers);

  }

  //what we need to return back to our form
  $returndata = array(
    'posted_form_data' => array(
      'email' => $email
    ),
    'form_ok' => $formok,
    'errors' => $errors
  );


  //if this is not an ajax request
  if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){
    //set session variables
    session_start();
    $_SESSION['cf_returndata'] = $returndata;

    //redirect back to form
    header('location: ' . $_SERVER['HTTP_REFERER']);
  }
}
