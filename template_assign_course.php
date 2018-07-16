<?php
/*

  Template Name: Assign Course

 */
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
$msg = false;
//echo date("Y-m-d",1530899330);
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "group_leader" || $roles[0] == "mini_admin")) {
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
    $user_id = "";
    if (isset($_REQUEST['form1']) && trim($_REQUEST['form1']) != "") {
        $user = get_user_by("email", $_REQUEST['email']);
        if (isset($user) && !empty($user)) {
            $parentID = get_user_meta($user->ID, 'parentID');
            if ($parentID[0] == $current_user->ID) {
                $meta = get_post_meta(trim($_REQUEST['access_course']), '_sfwd-courses');
                $course_access_list = explode(',', $meta[0]['sfwd-courses_course_access_list']);
                if (!in_array($user->ID, $course_access_list)) {
                    ld_update_course_access($user->ID, trim($_REQUEST['access_course']), $remove = false);
                    $msg = "Course assign successfully!";
                } else {
                    $msg = "User has already access for this course.";
                }
            } else {
                $msg = "You are not the perant of this user.";
            }
        } else {
            $msg = "User not found.";
        }
    }
    ?>

    <div class="container eltdf-row-grid-section">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <?php
                    if (isset($msg) && trim($msg) != "") {
                        echo '<strong class="f-sub-heading">' . $msg . '</strong>';
                    }
                    ?>
                    <div class="wpb_text_column wpb_content_element">
                        <div class="wpb_wrapper" style="text-align: center"><h3>Assign Course</h3></div>
                    </div>
                    <div class="main-member-container" id="main-member-container">
                        <form action="" method="post" name="form1">

                            <div class="panel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <strong class="f-sub-heading">Details</strong>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="email" class="control-label">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control"  required="" value="<?php echo isset($_REQUEST['email']) && trim($_REQUEST['email']) != "" ? $_REQUEST['email'] : "" ?>"  />
                                                </div>
                                            </div>
                                            <?php
                                            $courses = get_posts([
                                                'post_type' => 'sfwd-courses',
                                                'post_status' => 'publish',
                                                'posts_per_page' => -1,
                                                'order' => 'ASC'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="access-give" class="control-label">Give Course Access</label>
                                                    <select name="access_course"  class="form-control"  required="">
                                                        <option value="">Please Select Course</option>
                                                        <?php foreach ($courses as $course) { ?> 
                                                            <option value=" <?php echo $course->ID ?> " <?php echo $_REQUEST['access_course'] == $course->ID ? "selected" : "" ?> > <?php echo $course->post_title ?> </option>; 
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="eltdf-contact-form-animation pull-right">
                                    <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                    <input type="submit" class="wpcf7-form-control wpcf7-submit" value="ADD"/>
                                </div>
                            </div>
                            <input type="hidden" id="form-id" name="form1" value="1" />
                            <input type="hidden" id="form-id" name="one" value="1" />
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