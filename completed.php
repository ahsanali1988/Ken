<?php
/*

  Template Name: Score Counter Template

 */
redirectUser();
$eltdf_sidebar_layout = esmarts_elated_sidebar_layout();
get_header();

esmarts_elated_get_title();

get_template_part('slider');

do_action('esmarts_elated_action_before_main_content');

$current_user = wp_get_current_user();

$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "group_leader" || $roles[0] == "mini_admin")) {

    if ($roles[0] == "administrator" || $roles[0] == "mini_admin") {

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
    }
    $totalStudents = count($userarr);
    $count = 0;
    $completedCourse = 0;
    $expire = 0;
    $pendingAssignments = 0;
    if (count($userarr) > 0) {
        $usersID = array();
        $countuser = 0;
        foreach ($userarr as $user) {
            $usersID[$countuser] = $user->ID;
            $countuser++;
            $user_login_history = get_user_meta($user->ID, 'user_login_history');
            if (!isset($user_login_history[0]) && count($user_login_history[0]) == 0) {

                $lastLoginDisfference = strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($user->user_registered)));
                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                if ($lastLoginDays >= 14) {
                    $count++;
                }
            } else {
                $loginCount = count($user_login_history[0]);
                $lastlogin = $user_login_history[0][$loginCount - 1];
                $lastLoginDisfference = strtotime(date('Y-m-d')) - $lastlogin;
                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                if ($lastLoginDays >= 14) {
                    $count++;
                }
            }
            $completed = get_user_meta($user->ID, 'course_completed_4804');
            if (isset($completed[0]) && trim($completed[0]) != "") {
                $completedCourse++;
            }
            $lastLoginDisfference = strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($user->user_registered)));
            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
            if ($lastLoginDays >= 21) {
                $expire++;
            }
        }
        $update = get_option('attemptQuiz');
        $userEasay = explode(',', $update);
        $userPendId = "";
        foreach ($userEasay as $id) {
            if (in_array($id, $usersID)) {
                $userPendId = $userPendId != "" ? $userPendId . "-" . $id : $id;
                $quizData = get_user_meta($id, "quizDataUser");
                foreach ($quizData[0] as $quiz) {
                    $pendingAssignments++;
                }
            }
        }
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


    <div class="eltdf-container eltdf-default-page-template">
        <?php do_action('esmarts_elated_action_after_container_open'); ?>
        <div class="eltdf-container-inner clearfix">
            <div class="tab_wrap">
                <?php
                $courses = get_posts([
                    'post_type' => 'sfwd-courses',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'order' => 'ASC'
                ]);
                ?>
                <div class="inner_tab_link clearfix">
                    <ul>
                        <?php foreach ($courses as $course) { ?> 

                            <li class="<?php echo $course->ID == 4804 ? 'active' : "" ?>" onclick="updateStudent(<?php echo $course->ID ?>)" class="com"><a href="javascript:void(0)" role="tab" id="<?php echo $course->ID ?>" data-toggle="tab"><?php echo $course->post_title ?></a></li>
                        <?php } ?>
                        <!--   			<li><a href="#tab_2" role="tab" data-toggle="tab">Course two</a></li>
                                        <li><a href="#tab_3"  role="tab" data-toggle="tab">Course three</a></li>
                                        <li><a href="#tab_4"  role="tab" data-toggle="tab">Course four</a></li>-->
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="">
                        <div class="loader_wrap">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                        <ul class="students_counter clearfix" id="repl">
                            <li> <a class="inner" href="javascript:void(0)" onclick="submitForm('total')"> <span class="txt">Students <br>
                                        Enrolled</span> <strong class="counter" id="total"><?php echo $totalStudents; ?></strong> </a> </li>
                            <li> <a class="inner" href="javascript:void(0)" onclick="submitForm('inactive')"> <span class="txt">Students Inactive over two-weeks</span> <strong class="counter" id="inactive"><?php echo $count ?></strong> </a> </li>
                            <li> <a class="inner" href="javascript:void(0)" onclick="submitForm('completed')"> <span class="txt">Students Completed</span> <strong class="counter" id="completed"><?php echo $completedCourse ?></strong> </a> </li>
                            <?php if ($roles[0] == "mini_admin" || $roles[0] == "trainer" || $roles[0] == "administrator") { ?>
                                <li> <a class="inner" href="javascript:void(0)" onclick="pending('pending')"> <span class="txt">Assignments Pending</span> <strong class="counter" id="pending"><?php echo $pendingAssignments ?></strong> </a> </li>
                            <?php } ?>
                            <li> <a class="inner" href="javascript:void(0)" onclick="submitForm('expire')"> <span class="txt">Students near expiry</span> <strong class="counter" id="expire"><?php echo $expire ?></strong> </a> </li>
                            <?php if ($roles[0] == "mini_admin") { ?>
                                <li> <a class="inner link_new" href="#"><div class="inner_type"><span>+ New Course </span></div></a> </li>
                                <li> <a class="inner link_new" href="/member-registration-form/"><div class="inner_type"><span>+ New Enrolment</span></div> </a> </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!--          <div role="tabpanel" class="tab-pane fade" id="tab_2">Content goes here</div>
                              <div role="tabpanel" class="tab-pane fade" id="tab_3">Content goes here</div>
                              <div role="tabpanel" class="tab-pane fade" id="tab_4">Content goes here</div>-->
                </div>


            </div>
            <form method="post" action="<?php echo home_url('/student-list/') ?>">
                <input type="hidden" name="courseID" id="courseID" value="4804">
                <input type="hidden" name="type" id="type" value="">
                <input type="submit" value="submit" id="clickMe" style="display: none;">

            </form>
            <form method="post" action="<?php echo home_url('/assignments-pending/') ?>">
                <input type="hidden" name="userID" id="userID" value="<?php echo $userPendId; ?>">
                <input type="hidden" name="courseID" id="pendCourseID" value="4804">
                <input type="submit" value="submit" id="clickPen" style="display: none;">

            </form>

            <!--    
                <br><br><br><br> @Ahsan Remove Br after copy below content
                
            <ul class="students_counter clone clearfix">
                  <li> <a class="inner" href="javascript:;"> <span class="txt">Students <br>
                    Enrolled</span> <strong class="counter">7</strong> </a> </li>
                  <li> <a class="inner" href="javascript:;"> <span class="txt">Students Inactive over two-weeks</span> <strong class="counter">6</strong> </a> </li>
                  <li> <a class="inner" href="javascript:;"> <span class="txt">Students Completed</span> <strong class="counter">0</strong> </a> </li>
                  <li> <a class="inner" href="javascript:;"> <span class="txt">Students near expiry</span> <strong class="counter">6</strong> </a> </li>
                  <li> <a class="inner link_new" href="javascript:;"><div class="inner_type"><span>+ New Course </span></div></a> </li>
                  <li> <a class="inner link_new" href="javascript:;"><div class="inner_type"><span>+ New Enrolment</span></div> </a> </li>
                </ul>-->


        </div>
        <?php do_action('esmarts_elated_action_before_container_close'); ?>
    </div>

    <script>
        function updateStudent(courseID)
        {
            $('.loader_wrap').css({'display': 'block'});
            jQuery("#courseID").val(courseID)
            jQuery("#pendCourseID").val(courseID)
            var dataString = {action: 'userData', courseID: courseID};
            $.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: dataString,
                dataType: 'json',
                success: function (response) {

                    jQuery("#repl").html(response.result)
                    jQuery("#userID").val(response.userPendId)
                    $('.loader_wrap').css({'display': 'none'});
                    //                 jQuery("#total").html(response.total)
                    //                 jQuery("#inactive").html(response.inactive)
                    //                 jQuery("#completed").html(response.completed)
                    //                 jQuery("#expire").html(response.expire)

                }
            });
        }
        function submitForm(type) {
            //            alert(jQuery("#" + type).html())
            if (jQuery("#" + type).html() != "0")
            {
                jQuery("#type").val(type)
                jQuery("#clickMe").click();
            }

        }
        function pending(type) {
            //            alert(jQuery("#" + type).html())
            if (jQuery("#" + type).html() != "0")
            {
                jQuery("#clickPen").click();

            }
        }
    </script>
    <?php get_footer(); ?>
    <?php
} else {
    echo "<script>window.location.href = '" . home_url() . "'</script>";
    exit;
}
?>
