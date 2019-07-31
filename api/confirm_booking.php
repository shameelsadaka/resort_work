<?php
require("config_mail.php");

error_reporting(E_ERROR | E_PARSE);
    function _w($string){
        return ucwords(str_replace("-"," ",$string));
    }
    function getTableFromArray($my_array){
        foreach ($my_array as $key=>$value){
            $ret .= _w($key)." : ".$value;
            $ret .= '<br/>';
        }
        return $ret;
    }
    try {
        if(
            isset(
                $_POST['customer-name'],
                $_POST['customer-email'],
                $_POST['customer-phone'],
                $_POST['person-count'],
                $_POST['date-start'],
                $_POST['date-end']
            )
        ){
            // Admin Message
            $admin_mail = [

                "email"=>ADMIN_MAIL,
                "subject"=>"New Room Booking at Rainland by ".$_POST['customer-name'],//Subject

                    "message"=>
                    "Hi Admin, \n".
                    "There is a new room booking request from ".$_POST['customer-name']." ,\n".
                    "The form submitted is given below.\n".
                    getTableFromArray($_POST).

                    "\n\nRequest Timestamp : ".date("r")
            ];

            mail($admin_mail['email'],$admin_mail['subject'],$admin_mail['message']);
        

            // Custoemr Message
            $custoemr_mail = [
                "email"=>$_POST['customer-email'],//Custoemr Email
                "subject"=>"Rainland Resort - Room Booking request is Recieved",//Subject
                "message"=>
                        "Hi ".$_POST['customer-name'].",\n".
                        "Thanks for booking rooms at Rainland Resort Athirappally. \n".
                        "Your request is recieved, and we will call you soon for the confirmation.\n".

                        "Following are the details submitted by you,\n".
                         
                        getTableFromArray($_POST).


                        "Regards,\n".
                        "Manager - Rainland Resort Athirappally\n"
            ];
            mail($custoemr_mail['email'],$custoemr_mail['subject'],$custoemr_mail['message']);


            // echo $admin_mail['message']. "<br/>" .$custoemr_mail['message'];
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