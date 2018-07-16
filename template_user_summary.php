<?php

/*
  Template Name: User Summary
 */

get_header(); 
$userID = get_current_user_id();
$udata = get_userdata($userID);

$user_login_history = get_user_meta($userID, 'user_login_history');
//echo '<pre>';
//print_r(date('Y-m-d',  strtotime($udata->user_registered)));
//print_r($user_login_history);
//exit;
 $enrolled  = date('Y-m-d',  strtotime($udata->user_registered));
 
 $addMonth = strtotime($enrolled);
 
 $target = date("Y-m-d", strtotime("+1 month", $addMonth));
echo '<h3>Timeline</h3><br/>';
echo "Enrolled<br/>";
echo $enrolled;
echo '<br/>';
echo "Course Start Date<br/>";
echo $enrolled;
echo '<br/>';
echo "Target Date<br/>";
echo $target;
echo '<br/>';

echo '<h3>Current</h3><br/>';


?>


<?php
get_footer();