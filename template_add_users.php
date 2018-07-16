<?php
/*

  Template Name: Add Users

 */
redirectUser();
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "group_leader" || $roles[0] == "mini_admin")) {
    $admin = false;
    $trainer = false;
    $groupLeader = false;
    if ($roles[0] == "administrator") {
        $admin = true;
    } else {
        if ($roles[0] == "trainer") {
            $trainer = true;
        } else {
            if ($roles[0] == "group_leader") {
                $groupLeader = true;
            }
        }
    }
    ?>

    <div class="container eltdf-row-grid-section">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="wpb_text_column wpb_content_element">
<!--                        <div class="wpb_wrapper" style="text-align: center"><h3>Add Users</h3></div>-->
                    </div>
                    <div class="main-member-container" id="main-member-container">
                        <div class="panel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <strong class="f-sub-heading">Add Users</strong>
                                    <div class="row">
                                        <?php if ($admin || $groupLeader || $trainer) { ?>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <a itemprop="url" href="<?php echo home_url('/member-registration-form/') ?>" target="_self" class="eltdf-btn eltdf-btn-medium eltdf-btn-solid eltdf-btn-default eltdf-hover-animation">
                                                        <span class="eltdf-btn-text">Add Students</span>
                                                        <span class="eltdf-btn-hover-item"></span>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php } ?>
                                        <?php if ($admin) { ?>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <a itemprop="url" href="<?php echo home_url('/add-group-leaders/') ?>" target="_self" class="eltdf-btn eltdf-btn-medium eltdf-btn-solid eltdf-btn-default eltdf-hover-animation">
                                                        <span class="eltdf-btn-text">Add Group Leaders</span>
                                                        <span class="eltdf-btn-hover-item"></span>
                                                    </a>
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <a itemprop="url" href="<?php echo home_url('/add-new-trainer/') ?>" target="_self" class="eltdf-btn eltdf-btn-medium eltdf-btn-solid eltdf-btn-default eltdf-hover-animation">
                                                        <span class="eltdf-btn-text">Add Trainer</span>
                                                        <span class="eltdf-btn-hover-item"></span>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </div>

                            </div>
                        </div>
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