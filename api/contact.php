<?php
require("config_mail.php");

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: Rainland Resort Athirappilly <'.ADMIN_SENDER_MAIL.'>';


error_reporting(E_ERROR | E_PARSE);
    function _w($string){
        return ucwords(str_replace("-"," ",$string));
    }
    try {
        if(
            isset(
                $_POST['name'],
                $_POST['email'],
                $_POST['mobile'],
                $_POST['subject'],
                $_POST['message']
            )
        ){
            
            $admin_mail = [
                "email"=>ADMIN_MAIL,
                "subject"=>"Message from Rainland Resort Website User",//Subject
                "message"=>
                "Hi Admin, <br/><br/>".
                "There is a message from <b>".$_POST['name']."</b> through rainlandresortathirappilly.com ,<br/>".
                "The details are shown below.<br/><br/>".

                "<b>Sender</b> : ".$_POST['name']."<br/>".
                "<b>Email</b> : ".$_POST['email']."<br/>".
                "<b>Mobile</b> : ".$_POST['mobile']."<br/><br/>".
                "<b>Subject</b> : ".$_POST['subject']."<br/>".
                "<b>Message</b> : <br/> <p>".$_POST['message']."</i><br/>".


                "<br/><br/>Request Timestamp : ".date("r")
            ];

            mail($admin_mail['email'],$admin_mail['subject'],$admin_mail['message'],implode("\r\n", $headers));
        
            echo 'success';
        }
        else{
            throw new Exception("Some required data are missing");
        }

    }
    catch(Exception $e) {
        echo json_encode(['success'=>0,'message'=>$e->getMessage()]);
    }
?>