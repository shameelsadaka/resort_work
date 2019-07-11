<?php
error_reporting(E_ERROR | E_PARSE);
    function _w($string){
        return ucwords(str_replace("-"," ",$string));
    }
    function getTableFromArray($my_array){
        $ret =  '<table border="1">';
        $ret .= '  <tbody>';
            foreach ($my_array as $key=>$value){
                $ret .= '<tr>';
                $ret .= "<td>"._w($key)."</td><td>$value</td>";
                $ret .= '</tr>';
            }
        $ret .= '  </tbody>';
        $ret .= '</table>';
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
                "email"=>"shameelsadaka@gmail.com",//Admin Email
                "subject"=>"New Room Booking at Rainland by ".$_POST['customer-name'],//Subject
                "message"=>
                        "Hi,
                            There is a new room booking request from ".$_POST['customer-name'].",
                            The form submitted is given below.
                            
                            ".getTableFromArray($_POST)."

                            Request Timestamp : ".date("r")."                            
                       "
            ];
            mail($admin_mail['email'],$admin_mail['subject'],$admin_mail['message']);
        

            // Custoemr Message
            $custoemr_mail = [
                "email"=>$_POST['customer-email'],//Custoemr Email
                "subject"=>"Rainland Resort - Room Booking request is Recieved",//Subject
                "message"=>
                        "Hi ".$_POST['customer-name'].",
                            Thanks for booking rooms at Rainland Resort Athirappally. 
                            Your request is recieved, and we will call you soon for the confirmation.

                            Following are the details submitted by you,
                         
                            ".getTableFromArray($_POST)."


                            Regards,
                            Manager - Rainland Resort Athirappally

                       "
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