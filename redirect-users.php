<?php
/*

  Template Name: Users Redirect

 */

$current_user = wp_get_current_user();
$roles = $current_user->roles;
if (($roles[0] != "administrator" && $roles[0] != "mini_admin")) {
    $enrolmentAcceptance = get_user_meta($current_user->ID, 'enrolment-acceptance');
    if (isset($enrolmentAcceptance[0]) && count($enrolmentAcceptance[0]) > 0) {
        if ($roles[0] == "group_leader" || $roles[0] == "trainer") {
            echo "<script>window.location.href= '" . home_url() . "/dashboard/'</script>";
            exit;
        }else{
             echo "<script>window.location.href= '" . home_url() . "/all-courses/'</script>";
            exit;
        }
    } else {
        if ($roles[0] == "trainer") {
            echo "<script>window.location.href= '" . home_url() . "/trainer-acceptance/'</script>";
            exit;
        } else if ($roles[0] == "group_leader") {
            echo "<script>window.location.href= '" . home_url() . "/leader-acceptance/'</script>";
            exit;
        } else {
            echo "<script>window.location.href= '" . home_url() . "/enrolment-acceptance/'</script>";
            exit;
        }
    }
}else{
    echo "<script>window.location.href= '" . home_url() . "/dashboard/'</script>";
            exit; 
}