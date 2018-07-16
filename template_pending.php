<?php
/*

  Template Name: Assignments Pending

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



redirectUser();
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "mini_admin")) {
    if (isset($_REQUEST['userID']) && trim($_REQUEST['userID']) != "") {
        $userPendId = explode('-', $_REQUEST['userID']);

        $trainers = get_users(array('include' => $userPendId));
        ?>

        <div class="eltdf-container eltdf-default-page-template">
            <?php do_action('esmarts_elated_action_after_container_open'); ?>
            <div class="eltdf-container-inner clearfix">
                <?php
                if ($_REQUEST['type'] == "total") {
                    echo '<div class="successMsg"><b>Assignments Pending</b></div>';
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
                                            <th>Student Name</th>
                                            <th>Course</th>
                                            <th>Lesson Name</th>
                                            <th>Download</th>
                                            <th>Date Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tempArr = array();
                                        foreach ($trainers as $trainer) {
                                            $quizz = get_user_meta($trainer->ID, "quizDataUser");
                                            foreach ($quizz[0] as $key => $quiz) {
                                                $today = strtotime(date("Y-m-d"));
                                                $lastLoginDisfference = $today - $quiz['submitted'];
                                                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                                if ($lastLoginDays == 0) {
                                                    $lastLogin = "Today";
                                                } else {
                                                    $lastLogin = $lastLoginDays . " days ago";
                                                }

                                                $form4 = get_user_meta($trainer->ID, 'form4');
                                                ?>
                                                <tr>
                                                    <td><a href="javascript:void(0)" onclick="submitForm(<?php echo $trainer->ID ?>)" style="color: #5270FF"><?php echo $trainer->display_name ?></a></td>
                                                    <td><?php echo $quiz['courseName'] ?></td>
                                                    <td><?php echo $quiz['lessonName'] ?></td>
                                                    <td><a href="<?php echo $form4[0]['file1']?>" target="_blank" style="font-size:20px;" title="File 1"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                    <a href="<?php echo $form4[0]['file2']?>" target="_blank" style="font-size:20px;" title="File 2"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td><?php echo $lastLogin ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
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
                function downloadFiles(id) {
                    alert('sss')
                    jQuery("click1-"+id).click();
                    jQuery("click2-"+id).click();
                }
            </script>
            <?php get_footer(); ?>
            <?php
        } else {
            echo "<script>window.location.href = '" . home_url() . "'</script>";
            exit;
        }
    } else {
        echo "<script>window.location.href = '" . home_url() . "'</script>";
        exit;
    }
    ?>
