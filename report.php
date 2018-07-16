<?php
/*

  Template Name: Dail Report Template

 */
redirectUser();
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if (is_user_logged_in()) {
    if ($roles[0] == "subscriber") {
        $userarr = $current_user;
        $nRole = 'student';
    } else if ($roles[0] == "administrator" || $roles[0] == "mini_admin") {
        $userarr = get_users(
                array(
                    "role" => "subscriber",
                    'meta_query' => array(
                        array(
                            'key' => 'course_4804_access_from',
                            'value' => '',
                            'compare' => '!='
                        ),
                    )
                )
        );

        $nRole = 'student1111';
    } else {
        $userarr = get_users(array(
            "role" => "subscriber",
            'meta_query' => array(
                array(
                    'key' => 'parentID',
                    'value' => $current_user->ID,
                ),
                array(
                    'key' => 'course_4804_access_from',
                    'value' => '',
                    'compare' => '!='
                ),
        )));
        $nRole = $userarr[0]->roles[0];
    }
    ?>

    <style>
        .loader_wrap{

            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 250;
            display:none;

        }
        .spinner {
            width: 70px;
            height: 25px;
            text-align: center;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
        }

        .spinner > div {
            width: 18px;
            height: 18px;
            background-color: #5270ff;

            border-radius: 100%;
            display: inline-block;
            -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        }

        .spinner .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .spinner .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        @-webkit-keyframes sk-bouncedelay {
            0%, 80%, 100% { -webkit-transform: scale(0) }
            40% { -webkit-transform: scale(1.0) }
        }

        @keyframes sk-bouncedelay {
            0%, 80%, 100% { 
                -webkit-transform: scale(0);
                transform: scale(0);
            } 40% { 
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
            }
        }
    </style>

    <div class="container eltdf-row-grid-section">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-default">
                    <div class="wpb_text_column wpb_content_element">
                        <div class="wpb_wrapper"><h3>User Report</h3></div>
                    </div>
                    <?php if (isset($userarr) && count($userarr) > 0 && $nRole != "trainer" && $nRole != "group_leader") { ?>
                        <?php
                        $courses = get_posts([
                            'post_type' => 'sfwd-courses',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'order' => 'ASC'
                        ]);
                        ?>
                        <div class="tab_wrap">
                            <?php if ($roles[0] != "subscriber") { ?>
                                <div class="inner_tab_link clearfix">
                                    <ul>
                                        <?php foreach ($courses as $course) { ?> 

                                            <li class="com <?php echo $course->ID == 4804 ? 'active' : "" ?>" onclick="updateStudent(<?php echo $course->ID ?>)"><a href="javascript:void(0)" role="tab" id="<?php echo $course->ID ?>" data-toggle="tab"><?php echo $course->post_title ?></a></li>
                                        <?php } ?>
                                        <!--   			<li><a href="#tab_2" role="tab" data-toggle="tab">Course two</a></li>
                                                        <li><a href="#tab_3"  role="tab" data-toggle="tab">Course three</a></li>
                                                        <li><a href="#tab_4"  role="tab" data-toggle="tab">Course four</a></li>-->
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="tab-content">
                                <div class="loader_wrap">
                                    <div class="spinner">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </div>
                                <div class="main-member-container" id="main-member-container">

                                    <div class="section-report">
                <!--                        <p>Hello Dhaval,</p>
                                        <p>We hope you are well.</p>
                                        <p>Please see the below client report based on your current active alffie students. This report will provide you with a weekly snapshot based on all active students under your management.</p>
                                        <p>If you would like to discuss any students that may be of concern listed on the below report, please contact our friendly support team on 1300 253 343 and we will be happy to assist.</p>
                                        <h3>Weekly Report - Client Update</h3>-->
                                        <div class="table-responsive">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Student Email</th>
                                                        <th>Course Name</th>
                                                        <th>Start Date</th>
                                                        <th>Target Date</th>
                                                        <th>Status</th>
                                                        <th>Current Course Progress</th>
                                                        <th>Hours Reported</th>
                                                        <th>Attendance</th>
                                                        <th>Last Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="repl">
                                                    <?php
                                                    $countend = 0;
                                                    foreach ($userarr as $user) {
                                                        if ($countend > 0 && $nRole == 'student') {
                                                            break;
                                                        }
                                                        $countend++;

                                                        $userID = $user->ID;


                                                        $udata = get_userdata($userID);
                                                        $form1 = get_user_meta($userID, 'form1');
                                                        $form2 = get_user_meta($userID, 'form2');
                                                        $form3 = get_user_meta($userID, 'form3');
                                                        $form4 = get_user_meta($userID, 'form4');


                                                        $user_login_history = get_user_meta($userID, 'user_login_history');

                                                        $enrolled = date('Y-m-d', strtotime($udata->user_registered));
                                                        $addMonth = strtotime($enrolled);
                                                        $target = date("Y-m-d", strtotime("+1 month", $addMonth));

// calculate user attendance till current date//
                                                        $today = strtotime(date("Y-m-d"));
                                                        $datediff = $today - strtotime(date('Y-m-d', strtotime($udata->user_registered)));
                                                        $totalDays = round($datediff / (60 * 60 * 24));
                                                        $totalDays++;
//                                                    if($user->ID == 44)
//                                                    {
//                                                        echo $totalDays;
//                                                        echo '<br>';
//                                                        echo count($user_login_history[0]);
//                                                    }
//                                                if ($totalDays == 0) {
//                                                    $totalDays = 1;
//                                                }

                                                        if (isset($user_login_history[0]) && count($user_login_history[0]) > 0) {
                                                            $attendance = intVal(count($user_login_history[0]) * 100 / $totalDays);
                                                        } else {
                                                            $attendance = 0;
                                                        }
// end //
// calculate user last login hostory//
                                                        $lastLogin = "Not logged in yet";
                                                        if (count($user_login_history[0]) > 0) {
                                                            $user_login_history_count = count($user_login_history[0]);

                                                            $lastLoginStr = $user_login_history[0][$user_login_history_count - 1];


                                                            $lastLoginDisfference = $today - $lastLoginStr;
                                                            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                                            if ($lastLoginDays == 0) {
                                                                $lastLogin = "Today";
                                                            } else {
                                                                $lastLogin = $lastLoginDays . " days ago";
                                                            }
                                                        }
// end //

                                                        $courseID = trim($form1[0]['access_course']);
                                                        $has_access = sfwd_lms_has_access($courseID, $userID);

// calculate course total time and user completed time//
                                                        $lessons = learndash_get_lesson_list($courseID);
                                                        $topicsIDs = array();
                                                        $totalHours = 0;
                                                        $course_progress = get_user_meta($userID, "_sfwd-course_progress");
                                                        $courseHrs = 0;
                                                        $compHrs = 0;
                                                        foreach ($lessons as $lesson) {
                                                            $topics = learndash_get_topic_list($lesson->ID);
                                                            foreach ($topics as $topic) {
                                                                $topicHrs = get_post_meta($topic->ID, 'expected-duration');
                                                                $topicHrs[0];

                                                                $hrs = explode(":", $topicHrs[0]);
                                                                $topicHrs[0] = ($hrs[0] * 3600) + ($hrs[1] * 60);

                                                                if (isset($course_progress[0][$courseID]['topics'][$lesson->ID][$topic->ID]) && $course_progress[0][$courseID]['topics'][$lesson->ID][$topic->ID] == 1) {
                                                                    $compHrs = $compHrs + $topicHrs[0];
                                                                }
                                                                $courseHrs = $courseHrs + $topicHrs[0];
                                                            }
                                                        }
                                                        $compHrshrs = floor($compHrs / 3600);
                                                        $compHrsimints = floor(($compHrs / 60) % 60);
                                                        $compHrs = $compHrshrs . ":" . $compHrsimints;

                                                        $compHrshrs = floor($courseHrs / 3600);
                                                        $compHrsimints = floor(($courseHrs / 60) % 60);
                                                        $courseHrs = $compHrshrs . ":" . $compHrsimints;
// end //

                                                        $progress = learndash_course_progress(array("user_id" => $userID, "course_id" => $courseID, "array" => true));
                                                        ?>
                                                        <tr>
                                                            <?php  if ($roles[0] == "subscriber") { ?>
                                                            <td><?php echo isset($form1[0]['firstName']) && trim($form1[0]['firstName']) != "" ? $form1[0]['firstName'] : "" ?></td>
                                                            <?php } else { ?>
                                                            <td><a href="javascript:void(0)" onclick="submitForm(<?php echo $user->ID ?>)" style="color: #5270FF"><?php echo isset($form1[0]['firstName']) && trim($form1[0]['firstName']) != "" ? $form1[0]['firstName'] : "" ?></a></td>
                                                            <?php } ?>
                                                            <td><a href="mailto:<?php echo isset($form1[0]['email']) && trim($form1[0]['email']) != "" ? $form1[0]['email'] : "" ?>"><?php echo isset($form1[0]['email']) && trim($form1[0]['email']) != "" ? $form1[0]['email'] : "" ?></a></td>
                                                            <td><?php echo isset($courseID) && trim($courseID) != "" ? get_the_title($courseID) : "" ?></td>
                                                            <td><?php echo $enrolled ?></td>
                                                            <td><?php echo $target ?></td>
                                                            <td><?php echo $has_access && $has_access == 1 ? "Active" : "Inactive" ?></td>
                                                            <td><?php echo $progress['percentage']; ?>%</td>
                                                            <td><?php echo $compHrs . " of " . $courseHrs ?></td>
                                                            <td><?php echo $attendance ?>%</td>
                                                            <td><?php echo $lastLogin ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                <!--                        <p>Kind regards,</p>
                                        <p>Support Team</p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="<?php echo home_url('/student-profile/') ?>">
                            <input type="hidden" name="studentID" id="studentID" value="">
                            <input type="submit" value="submit" id="clickMe" style="display: none;">

                        </form>
                        <?php
                    } else {
                        echo 'No User Found';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateStudent(courseID)
        {
            $('.loader_wrap').css({'display': 'block'});
            jQuery("#courseID").val(courseID)
            var dataString = {action: 'reportbyCourse', courseID: courseID};
            $.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    $('.loader_wrap').css({'display': 'none'});
                    jQuery("#repl").html(response.result)
                    //                 jQuery("#total").html(response.total)
                    //                 jQuery("#inactive").html(response.inactive)
                    //                 jQuery("#completed").html(response.completed)
                    //                 jQuery("#expire").html(response.expire)

                }
            });
        }
        function submitForm(studentID) {
    //            alert(jQuery("#" + type).html())

            jQuery("#studentID").val(studentID)
            jQuery("#clickMe").click();


        }
    </script>
    <style type="text/css">
        .main-member-container {
            color: #000;
            font-family: Montserrat,sans-serif;
            font-size: 12px;
        }
        .panel {
            padding: 0 0 50px;
            overflow: hidden;
            clear: both;
        }
        .table-responsive {
            max-width: 100%;
            overflow: auto;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            border-spacing: 0;
            border: none;
            border-collapse: separate;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            text-align: center;
        }
        .table>thead:first-child>tr:first-child>th {
            border-top: 0;
        }
        .table>thead>tr>th {
            vertical-align: middle;
            border-bottom: 2px solid #ddd;
            padding: 5px;
        }

    </style>
    <?php get_footer(); ?>

    <?php
} else {
    echo "<script>window.location.href = '" . home_url() . "'</script>";
    exit;
}
?>