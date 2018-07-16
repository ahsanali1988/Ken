<?php
/*

  Template Name: Acceptance Leader Template

 */
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "group_leader" )) {
    if (isset($_REQUEST['form5']) && trim($_REQUEST['form5']) != "") {
        if (isset($_REQUEST['acceptTrainer']) && trim($_REQUEST['acceptTrainer']) != "") {
            update_user_meta($current_user->ID, 'enrolment-acceptance', $_REQUEST);
        }
    }
    $enrolmentAcceptance = get_user_meta($current_user->ID, 'enrolment-acceptance');
    if (isset($enrolmentAcceptance[0]) && count($enrolmentAcceptance[0]) > 0) {
        echo "<script>window.location.href= '" . home_url() . "/dashboard/'</script>";
        exit;
    }
    ?>

    <div class="container eltdf-row-grid-section">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="wpb_text_column wpb_content_element">
                        <div class="wpb_wrapper"><h3>Client Use Policy</h3></div>
                    </div>
                    <div class="main-member-container" id="main-member-container">
                        <p>By confirming my enrolment, I agree to the following:</p>
                        <ul>
                            <li>You acknowledge that Key Institute own all copyright, content and material on Key Institute`s website and Student Management System.</li>
                            <li>You agree that you will use the Trainer access to Key Institute`s Student Management System solely for the purpose of assessing student`s competency of units and providing assistance and feedback to students.</li>
                            <li>You will not, without Key institute`s written consent print, copy, remove branding from, distribute or provide copies of the content to any person other than distribution to other trainers who are also training in that unit, or students who are enrolled in that unit.</li>
                            <li>You agree that you will not or attempt to extract the source code of Key Institute`s Learning Management System. </li>
                            <li>You agree that you will not allow any other person to access your account at any time without written consent from Key Institute. Key Institute hold the right to collect data related to access locations of users for the purpose of protecting it`s security.</li>
                            <li>You will not use Key Institute`s Student Management System to contact students for any other reason than for the purpose of assessing student`s competency of units and providing assistance and feedback to students.</li>
                            <li>You agree that at any time Key Institute may remove or alter your access to Key Institute`s Student Management System.</li>
                            <li>Key Institute have no obligation to provide uninterrupted access to the Services and although we will do our best to provide continuous access, and the Services may, from time to time, be inaccessible to users.</li>
                            <li>As a user of Key Institute's services, you agree that you will not use the Services for an illegal or unlawful purpose, or in a way that encourages criminal activity.</li>
                        </ul>
                        <!--<p>I have read and agree to the Terms and Conditions</p>-->
                        <form action="" method="post" name="form1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="accept">I have read and agree to the Terms and Conditions</label>
                                        <input type="checkbox" class="" required="" name="acceptTrainer">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="eltdf-contact-form-animation pull-right">
                                    <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                    <input type="submit" class="wpcf7-form-control wpcf7-submit" value="Accept"/>
                                </div>
                            </div>
                            <input type="hidden" name="form5" value="2"> 
                            <input type="hidden" name="currentDate" value="<?php echo strtotime(date('Y-m-d')) ?>"> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .main-member-container {
            color: #000;
            font-family: Montserrat,sans-serif;
            font-size: 12px;
        }
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
    </style>
    <?php get_footer(); ?>

    <?php
} else {
    echo "<script>window.location.href = '" . home_url() . "'</script>";
    exit;
}
?>