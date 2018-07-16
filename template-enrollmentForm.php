<?php
/*

  Template Name: Enrollment Form Email Template

 */
if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id']) != "") {
    $user_id = $_REQUEST['user_id'];
    $userData = get_user_by('id', $user_id);
    if ($userData) {
        $form1 = get_user_meta($user_id, 'form1');
//        $form2 = get_user_meta($user_id, 'form2');
//        $form3 = get_user_meta($user_id, 'form3');
//        $form4 = get_user_meta($user_id, 'form4');
        $subject = "Student Enrollment Form";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Key Institute <info@keyinstitute.com>' . " \r\n";
         $headers .= "Bcc: admin@keyinsitute.com.au\r\n";
        ?>

        <!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>User Detail</title>
                <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Open+Sans:300,400,600,700,800" rel="stylesheet">
                    <style type="text/css">
                        .ExternalClass { width: 100% !important; }
                        body {
                            font-family: 'Lato', Arial,Helvetica,sans-serif;
                            text-align: center;
                        }
                    </style>
            </head>-->
        <?php
        $body = '<body style="margin:0; padding:0; background:#fff;" link="#ffffff">
        <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
            <tr>
                <td>
                    <table width="600" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td valign="top" style="border: 2px solid #eee;padding: 44px 10px;">
                                <table width="800" cellspacing="0" cellpadding="0">

                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" align="center" style="border-bottom: 1px solid #ccc;padding-bottom: 25px;" >
                                                        <a href="'.home_url().'"><img src="http://members.keyinstitute.com.au/wp-content/uploads/2018/06/logo.png" width="139" height="72" border="0" title="logo" alt="Image" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:30px;">Welcome to Key Institute!</strong>
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:15px;">Getting started</strong>
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        To access and get started with your training, please follow this link: <a href ="www.keyinstitute.com.au">www.keyinstitute.com.au</a> and click the ‘login’ button located in the top right corner of the page. 
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        Your login details are listed below:
                                                    </td>`
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" align="center" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:30px;">User Detail</strong>
                                                    </td>`
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="left" valign="top" width="50%" style="padding-right: 10px;">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" colspan="2">
                                                                        <strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Personal Details</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        First Name
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.$form1[0]['firstName'].'
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Surname
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.$form1[0]['surname'].'
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Email
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.$form1[0]['email'].'
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Password
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.$form1[0]['password'].'
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Course Access
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.get_the_title(trim($form1[0]['access_course'])).'
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Study Schedule
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.$form1[0]['access_give'].'
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Employment Service
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        '.$form1[0]['employment_service'].'
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                  <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:30px;">Key Institute Support Team</strong>
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        If you require assistance please feel free to contact our team on 1300 471 660, Monday to Friday from 9am - 5pm (AEST). You can also email us at <a href="support@keyinstitute.com.au">support@keyinstitute.com.au
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        Best regards,
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 75px;" >
                                                        Please note this is an automated email, please do not reply
                                                    </td>`
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                            </table>
                                        </td>
                                    </tr>										
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>';
        $message = $body;
        mail($userData->user_email, $subject, $message, $headers);
    }
    echo "<script>window.location.href= '".home_url('/member-registration-form/?success=1')."' </script>";
    exit;
}

//</html>
