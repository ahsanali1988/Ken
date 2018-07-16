<?php
/*

  Template Name: All Students

 */
?>
<style>
.eltdf-title-holder {
	display: none !important;
}
</style>
<?php
$eltdf_sidebar_layout = esmarts_elated_sidebar_layout();


redirectUser();
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "group_leader" || $roles[0] == "mini_admin")) {
    esmarts_elated_get_title();

    get_template_part('slider');

    do_action('esmarts_elated_action_before_main_content');


//echo '<pre>';
//print_r($blogusers);
//exit;

    if (isset($_REQUEST['id']) && trim($_REQUEST['id']) != "") {
        $msg = "";
        if (wp_delete_user($_REQUEST['id'])) {
            $msg = "User deleted successfully!";
        }
    }
    if (isset($_REQUEST['user_name']) && trim($_REQUEST['user_name']) != "") {
        $bbb = array('role' => 'subscriber', 'search' => $_REQUEST['user_name'] . '*');
        if ($roles[0] == "administrator") {
           $trainers = get_users(array('role' => 'subscriber', 'search' => $_REQUEST['user_name'] . '*')); 
        } else {
            $trainers = get_users(array('role' => 'subscriber', 'search' => $_REQUEST['user_name'] . '*', 'meta_key' => "parentID", 'meta_value' => $current_user->ID));
        }
    } else {
        if ($roles[0] == "trainer" || $roles[0] == "group_leader") {
            $trainers = get_users(array("role" => "subscriber", 'meta_key' => "parentID", 'meta_value' => $current_user->ID));
        } else {
            $trainers = get_users(array("role" => "subscriber"));
        }
    }
//echo '<pre>';
//print_r($trainers[0]->data->display_name);
//exit;
    ?>

<div class="eltdf-container eltdf-default-page-template">
<?php do_action('esmarts_elated_action_after_container_open'); ?>
<div class="eltdf-container-inner clearfix">
  <?php
            if ($msg) {
                echo '<div class="successMsg">' . $msg . '</div>';
            }
            ?>
  <div class="trainer_wrap">
    <div class="inner_header clearfix">
      <form method="post" action="">
        <div class="row">
          <div class="col-sm-8">
            <h3>Search Students</h3>
            <div class="row">
              <div class="col-sm-8">
                <input type="text" value="<?php echo isset($_REQUEST['user_name']) && trim($_REQUEST['user_name']) != "" ? $_REQUEST['user_name'] : "" ?>" class="form-control" placeholder="Name" name="user_name">
              </div>
              <!--                        <div class="col-sm-6">
                                                                    <input type="text" class="form-control" placeholder="Course Name">
                                                            </div>--> 
              
            </div>
          </div>
          <div class="col-sm-4">
            <div class="btn_wrap clone">
            <div class="row">
            	<div class="col-sm-6">
                	<a class="btn_1" href="/member-registration-form/">+ New Student</a>
                </div>
                <div class="col-sm-6">
                	<a class="btn_1" href="/assign-course/">+ Assign Course</a>
                </div>
            </div>
            
              <input type="submit" class="btn_1" value="Search">
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php
                if (count($trainers) > 0) {
                    ?>
    <div class="content_area">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Managed By</th>
              <!--<th>Edit</th>-->
              <!--<th>Progress</th>-->
              <th>Last Activity</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
                                foreach ($trainers as $trainer) {
                                    $user_login_history = get_user_meta($trainer->ID, 'user_login_history');
                                    $lastLogin = "Not logged in yet";
                                    if (count($user_login_history[0]) > 0) {
                                        $user_login_history_count = count($user_login_history[0]);

                                        $lastLoginStr = $user_login_history[0][$user_login_history_count - 1];

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
                                    $progress = learndash_course_progress(array("user_id" => $trainer->ID, "course_id" => 4804, "array" => true));
                                    ?>
            <tr>
                <td><a href="javascript:void(0)" onclick="submitForm(<?php echo $trainer->ID ?>)" style="color: #5270FF"><?php echo $trainer->data->display_name ?></a></td>
              <td><?php echo $parentuser->display_name ?></td>
              <!--                        <td>Edit</td>-->
              <!--<td><?php echo $progress['percentage']; ?>%</td>-->
              <td><?php echo $lastLogin ?></td>
              <td><a href="/students/?id=<?php echo $trainer->ID ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
      <form method="post" action="<?php echo home_url('/student-profile/') ?>">
            <input type="hidden" name="studentID" id="studentID" value="">
            <input type="submit" value="submit" id="clickMe" style="display: none;">

        </form>
       <script>
  
        function submitForm(studentID) {
    //            alert(jQuery("#" + type).html())

            jQuery("#studentID").val(studentID)
            jQuery("#clickMe").click();


        }
    </script>
    <?php
                } else {
                    echo "No Record Found!";
                }
                ?>
  </div>
</div>
<?php do_action('esmarts_elated_action_before_container_close'); ?>
<?php get_footer(); ?>
<?php
    } else {
        echo "<script>window.location.href = '" . home_url() . "'</script>";
        exit;
    }
    ?>
