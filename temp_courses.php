<?php
/*

  Template Name: Main Courses

 */

$eltdf_sidebar_layout = esmarts_elated_sidebar_layout();



get_header();

esmarts_elated_get_title();

get_template_part('slider');

do_action('esmarts_elated_action_before_main_content');
$current_user = wp_get_current_user();
?>

<div class="eltdf-container eltdf-default-page-template">
    <?php do_action('esmarts_elated_action_after_container_open'); ?>
    <div class="eltdf-container-inner clearfix">
        <div class="courses_wrap">
            <div class="row">
                <?php $count = 1; ?>
                <?php wp_reset_query(); ?>
                <?php $custom_query = new WP_Query(array('post_type' => 'sfwd-courses', 'showposts' => 12)); ?>
                <?php if ($custom_query->have_posts()): while ($custom_query->have_posts()): $custom_query->the_post(); ?>
                        <?php
                        $bool = false;
                        $postMeta = get_post_meta($post->ID, '_sfwd-courses');
                        if (isset($postMeta[0]['sfwd-courses_course_access_list']) && trim($postMeta[0]['sfwd-courses_course_access_list']) != "") {
                            $usersAccess = explode(',', $postMeta[0]['sfwd-courses_course_access_list']);
                            if (count($usersAccess) > 0) {
                                if (in_array($current_user->ID, $usersAccess)) {
                                    $bool = true;
                                }
                            } else {
                                if ($current_user->ID == $postMeta[0]['sfwd-courses_course_access_list']) {
                                    $bool = true;
                                }
                            }
                        }
                        ?>
                        <?php if ($bool) { ?>
                            <?php $progress = learndash_course_progress(array("user_id" => $current_user->ID, "course_id" => $post->ID, "array" => true)); ?>
                            <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                            <div class="col-sm-4"> <a  class="inner" href="<?php the_permalink(); ?>" draggable="false">
                                    <figure> <img src="<?php echo $src[0]; ?>" class="img-responsive" draggable="false"> </figure>
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                    <p style="display:none;"><?php echo get_post_meta($post->ID, 'short_description', true); ?></p>
                                    <div class="progress_wrap">
                                        <em><?php echo $progress['percentage']?>%</em>
                                        <div class="course_progress">  <span style="width: <?php echo $progress['percentage']?>%;"></span>
                                        </div>
                                        <h5>Course Status</h5>
                                    </div>
                                </a> </div>
                            <?php if ($count == 3) { ?>
                            </div>
                            <div class="row">
                            <?php } ?>
                            <?php
                            $count++;
                        }
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
    <?php do_action('esmarts_elated_action_before_container_close'); ?>
</div>
<?php get_footer(); ?>
