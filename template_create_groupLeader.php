<?php
/*

  Template Name: Add Group Leaders

 */
redirectUser();
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "mini_admin")) {
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
    $msg = false;
    $error = false;
    if (isset($_REQUEST['form1']) && trim($_REQUEST['form1']) != "") {
        $check = username_exists($_REQUEST['user_name']);
        if (!empty($check)) {
            $suffix = 2;
            while (!empty($check)) {
                $alt_ulogin = $_REQUEST['user_name'] . '-' . $suffix;
                $check = username_exists($alt_ulogin);
                $suffix++;
            }
            $_REQUEST['user_name'] = $alt_ulogin;
        }

        $email = trim($_REQUEST['email']);

        $password = wp_generate_password();
        $user_id = wp_create_user($_REQUEST['user_name'], $password, $email);
        if (!isset($user_id->errors['existing_user_email'][0]) && trim($user_id->errors['existing_user_email'][0]) == "") {
            print_r($user_id->errors['existing_user_email'][0]);
            if ($user_id) {

                $access_group['group_leader'] = true;
                $id = wp_insert_post(array('post_title' => 'keyinstitute-' . $user_id, 'post_status' => 'publish', 'post_type' => 'groups'));
                update_post_meta($id, 'group_leader_id', $user_id);
                update_user_meta($user_id, 'parentID', $current_user->ID);
                update_user_meta($user_id, 'group_leader_form', $_REQUEST);
                update_user_meta($user_id, "wp_capabilities", $access_group);
                update_user_meta($user_id, 'learndash_group_leaders_' . $id, $id);
                update_post_meta($id, 'learndash_group_users_' . $id, $groupUsers);
                ld_update_course_access($user_id, 4804, $remove = false);
                ld_update_course_group_access(4804, $id);

                $subject = "Group Leader";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: Key Institute <info@keyinstitute.com>' . " \r\n";
                 $headers .= "Bcc: admin@keyinsitute.com.au\r\n";
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
                                                        <a href="' . home_url() . '"><img src="http://members.keyinstitute.com.au/wp-content/uploads/2018/06/logo.png" width="139" height="72" border="0" title="logo" alt="Image" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" align="center" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:30px;">Group Leader Details</strong>
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
                                                                        Name
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['user_name'] . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Surname
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['surname'] . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Phone Number
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['phn_number'] . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Email
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $email . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Password
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $password . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Group Name
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        keyinstitute- ' . $user_id . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Company Name
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['comp_name'] . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Address
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['address'] . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Suburb
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['suburb'] . '
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        State
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['state'] . '
                                                                    </td>
                                                                </tr>
                                                                 <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Postcode
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $_REQUEST['postcode'] . '
                                                                    </td>
                                                                </tr>
                                                            </tbody>
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
                mail($email, $subject, $message, $headers);
                $msg = true;
            }
        } else {
            $error = true;
        }
    }
    ?>

    <div class="container eltdf-row-grid-section">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <?php
                    if ($msg) {
                        echo '<strong class="f-sub-heading" style="text-align: center">Group Leader added successfully!</strong>';
                    }
                    if ($error) {
                        echo '<strong class="f-sub-heading" style="text-align: center;background-color: #FF002D;">' . $user_id->errors['existing_user_email'][0] . '</strong>';
                    }
                    ?>
                    <div class="wpb_text_column wpb_content_element">
                        <div class="wpb_wrapper" style="text-align: center"><h3>Add Group Leader</h3></div>
                    </div>
                    <div class="main-member-container" id="main-member-container">
                        <form action="" method="post">
                            <div class="panel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <strong class="f-sub-heading">Details</strong>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Name</label>
                                                    <input type="text" name="user_name" class="form-control"  required="" value=""  autofocus=""/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Surname</label>
                                                    <input type="text" name="surname"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Phone Number</label>
                                                    <input type="text" name="phn_number"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Email</label>
                                                    <input type="email" name="email"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Company Name</label>
                                                    <input type="text" name="comp_name"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Address</label>
                                                    <input type="text" name="address"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Suburb</label>
                                                    <input type="text" name="suburb"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">State</label>
                                                    <input type="text" name="state"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Postcode</label>
                                                    <input type="text" name="postcode"  class="form-control"  required="" value=""  />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="eltdf-contact-form-animation pull-right">
                                    <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                    <input type="submit" class="wpcf7-form-control wpcf7-submit" value="Add"/>
                                </div>
                            </div>
                            <input type="hidden" id="form-id" name="form1" value="1" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

    //    jQuery(document).ready(function () {
    //        jQuery('#member-button-click').on('click', function () {
    //            var form_id = jQuery('#form-id').val();
    //            if (form_id == 1) {
    //                var dataString = {action: 'member_multiple_form_registration', form: jQuery('#form-id').val(), email: jQuery('#email').val(), username: jQuery('#user-name').val(), password: jQuery('#password').val()};
    //                $.ajax({
    //                    url: "/wp-admin/admin-ajax.php",
    //                    type: 'POST',
    //                    data: dataString,
    //                    dataType: 'json',
    //                    success: function (response) {
    //                        console.log(response);
    //                    }
    //                });
    //            } else if (form_id == 2) {
    //
    //            } else if (form_id == 3) {
    //
    //            }
    //        });
    //    });
    </script>
    <style type="text/css">
        .form-control {
            display: block;
            width: 100%;
            height: 35px !important;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            -webkit-border-radius: 4px !important;
            -moz-border-radius: 4px !important;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            font-family: Montserrat,sans-serif;
            margin: 0 0 15px !important;
            line-height: 35px;
        }
        .pull-right {float: right;}
        strong.f-sub-heading {
            display: block;
            padding: 10px;
            margin: 20px 0;
            background: #5270ff;
            color: #fff;
            font-family: Montserrat,sans-serif;
            clear: both;
        }
        label.control-label {
            font-family: Montserrat,sans-serif;
            font-size: 14px;
            color: #000;
            line-height: 18px;
            display: inline-block;
        }
        .panel {
            padding: 0 0 50px;
            overflow: hidden;
            clear: both;
        }
        .sub-txt {
            display: block;
            padding: 5px 0 15px;
            font-size: 75%;
            line-height: 1.5;
        }
        .formWizar {
            text-align: center;
            list-style: none;
            padding:  0 0 30px;
            margin: 0;
        }
        .formWizar li {
            display: inline-block;
            vertical-align: top;
            padding: 0 5%;
            position: relative;
        }
        .formWizar li span {
            display: block;
            width: 40px;
            height: 40px;
            background: #ddd;
            color: #000;
            line-height: 40px;
            border-radius: 100%;
            z-index: 9;
            position: relative;
        }
        .formWizar li.active span{ background: #5270ff; color: #fff;}
        .formWizar li.done span { background: #00d2c8; color: #fff;}
        .formWizar li::after {
            content:  '';
            border-bottom: 5px solid #ddd;
            position:  absolute;
            top: 18px;
            left: 50%;
            width:  100%;
            margin-left: -90%;
        }
        .formWizar li:first-child::after {
            border: none;
        }
        .formWizar li.active::after {border-bottom-color:#4360e8; }
        .formWizar li.done::after {
            border-bottom-color: #00d2c8;
        }
        .row {
            clear: both;
        }
    </style>
    <?php get_footer(); ?>

<?php
} else {
    echo "<script>window.location.href = '" . home_url() . "'</script>";
    exit;
}
?>