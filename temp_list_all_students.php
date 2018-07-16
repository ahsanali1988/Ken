<?php
/*

  Template Name: Students List

 */
?>
<style>
    .eltdf-title-holder {
        display: none !important;
    }
</style>
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$eltdf_sidebar_layout = esmarts_elated_sidebar_layout();


redirectUser();
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "group_leader" || $roles[0] == "mini_admin")) {
    esmarts_elated_get_title();

    get_template_part('slider');

    do_action('esmarts_elated_action_before_main_content');

    if ($roles[0] == "trainer" || $roles[0] == "group_leader") {
//        $trainers = get_users(array("role" => "subscriber", 'meta_key' => "parentID", 'meta_value' => $current_user->ID));
        $trainers = get_users(array(
            "role" => "subscriber",
            'meta_query' => array(
                array(
                    'key' => 'parentID',
                    'value' => $current_user->ID,
                ),
                array(
                    'key' => 'course_' . $_REQUEST["courseID"] . '_access_from',
                    'value' => '',
                    'compare' => '!='
                ),
        )));
    } else {
        $trainers = get_users(
                array(
                    "role" => "subscriber",
                    'meta_query' => array(
                        array(
                            'key' => 'course_' . $_REQUEST["courseID"] . '_access_from',
                            'value' => '',
                            'compare' => '!='
                        ),
                    )
                )
        );
//        $trainers = get_users(array("role" => "subscriber"));
    }
//    echo '<pre>';
//print_r($trainers);
//exit;
    ?>

    <div class="eltdf-container eltdf-default-page-template">
        <?php do_action('esmarts_elated_action_after_container_open'); ?>
        <div class="eltdf-container-inner clearfix">
            <?php
            if ($_REQUEST['type'] == "total") {
                echo '<div class="successMsg"><b>Students Enrolled</b></div>';
            }
            if ($_REQUEST['type'] == "inactive") {
                echo '<div class="successMsg"><b>Students Inactive over two-weeks</b></div>';
            }
            if ($_REQUEST['type'] == "completed") {
                echo '<div class="successMsg"><b>Students Completed</b></div>';
            }
            if ($_REQUEST['type'] == "expire") {
                echo '<div class="successMsg"><b>Students near expiry</b></div>';
            }
            ?>
            <div class="trainer_wrap">

                <?php
                if (count($trainers) > 0) {
                    ?>
                    <div class="content_area">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Managed By</th>
                                        <th>Last Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tempArr = array();
                                    foreach ($trainers as $trainer) {
                                        $user_course_access = get_user_meta($trainer->ID, 'course_' . $_REQUEST["courseID"] . '_access_from');
                                        $user_course_access[0] = date("Y-m-d", $user_course_access[0]);
                                        $user_course_access[0] = strtotime($user_course_access[0]);
                                        $bool = false;
                                        
                                        $countDays = 0;
                                        $user_login_history = get_user_meta($trainer->ID, 'user_login_history');
                                        $loginDate = 0;
                                        foreach ($user_login_history[0] as $key => $login) {
                                            if ($login >= $user_course_access[0]) {

                                                $loginDate = $key;
                                                $countDays++;
                                            }
                                        }
                                        if ($_REQUEST['type'] == "total") {
                                            $bool = true;
                                        } else if ($_REQUEST['type'] == "inactive") {
                                            if ($countDays == 0) {

                                                $lastLoginDisfference = strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', $user_course_access[0]));
                                                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                                if ($lastLoginDays >= 14) {
                                                    $bool = true;
                                                }
                                            } else {
                                                $loginCount = $countDays;
                                                $lastlogin = $user_login_history[0][$loginDate];
                                                $lastLoginDisfference = strtotime(date('Y-m-d')) - $lastlogin;
                                                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                                if ($lastLoginDays >= 14) {
                                                    $bool = true;
                                                }
                                            }
                                        } else if ($_REQUEST['type'] == "completed") {
                                            $completed = get_user_meta($trainer->ID, 'course_completed_' . $_REQUEST['courseID']);
                                            if (isset($completed[0]) && trim($completed[0]) != "") {
                                                $bool = true;
                                            }
                                        } else if ($_REQUEST['type'] == "expire") {
                                            $lastLoginDisfference = strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', $user_course_access[0]));
                                            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                            if ($lastLoginDays >= 21) {
                                                $bool = true;
                                            }
                                        }
                                        if (!$bool) {
                                            continue;
                                        }
                                        $user_login_history = get_user_meta($trainer->ID, 'user_login_history');
                                        $lastLogin = "Not logged in yet";
                                        if ($countDays > 0) {
                                            $user_login_history_count = count($user_login_history[0]);

                                            $lastLoginStr = $countDays == 0 ? $loginDate : $user_login_history[0][$loginDate];

                                            $today = strtotime(date("Y-m-d"));
                                            $lastLoginDisfference = $today - $lastLoginStr;
                                            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                            if ($lastLoginDays == 0) {
                                                $lastLogin = "Today";
                                            } else {
                                                $lastLogin = $lastLoginDays . " days ago";
                                            }
                                        }
                                        $parent = get_user_meta($trainer->ID, 'parentID');
                                        $parentuser = get_user_by('id', $parent[0]);
                                        ?>
                                        <tr>
                                            <td><a href="javascript:void(0)" onclick="submitForm(<?php echo $trainer->ID ?>)" style="color: #5270FF"><?php echo $trainer->data->display_name ?></a></td>
                                            <td><?php echo $trainer->data->user_email ?></td>
                                            <td><?php echo $parentuser->display_name ?></td>
                                            <td><?php echo $lastLogin ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "No Record Found!";
                }
                ?>
            </div>
        </div>
        <form method="post" action="<?php echo home_url('/student-profile/') ?>">
            <input type="hidden" name="studentID" id="studentID" value="">
            <input type="submit" value="submit" id="clickMe" style="display: none;">

        </form>
        <?php do_action('esmarts_elated_action_before_container_close'); ?>
        <script>
            function submitForm(studentID) {
                //            alert(jQuery("#" + type).html())

                jQuery("#studentID").val(studentID)
                jQuery("#clickMe").click();


            }
        </script>
        <?php get_footer(); ?>
        <?php
    } else {
        echo "<script>window.location.href = '" . home_url() . "'</script>";
        exit;
    }
    ?>
