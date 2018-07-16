<?php

/*

  Template Name: 2 week email

 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$trainers = get_users(array('role' => "trainer"));

foreach ($trainers as $trainer) {
    $posts = get_posts(array('post_type' => "sfwd-courses"));

    foreach ($posts as $post) {
        $userarr = get_users(array(
            "role" => "subscriber",
            'meta_query' => array(
                array(
                    'key' => 'parentID',
                    'value' => $trainer->ID,
                ),
                array(
                    'key' => 'course_' . $post->ID . '_access_from',
                    'value' => '',
                    'compare' => '!='
                ),
        )));
        foreach ($userarr as $user) {
            $user_course_access = get_user_meta($user->ID, 'course_' . $post->ID . '_access_from');
            $user_course_access[0] = date("Y-m-d", $user_course_access[0]);
            $user_course_access[0] = strtotime($user_course_access[0]);
            $lastLoginDisfference = strtotime(date('Y-m-d')) - $user_course_access[0];
            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
            if ($lastLoginDays >= 21) {
                // Expire users Email will implement here//
                
            }
        }
    }
}
?>