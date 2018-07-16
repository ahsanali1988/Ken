<!DOCTYPE html>
<html <?php language_attributes(); ?>>
   
    <head>
        <style>
            #nav-menu-item-5094,#mobile-menu-item-5094,#mobile-menu-item-5041, #nav-menu-item-5041,#mobile-menu-item-5014 ,#nav-menu-item-5014,#mobile-menu-item-5015 ,#nav-menu-item-5015, #mobile-menu-item-5023,#nav-menu-item-5023, #mobile-menu-item-5040,#nav-menu-item-5040, #mobile-menu-item-5038,#nav-menu-item-5038, #mobile-menu-item-5039,#nav-menu-item-5039{
                display: none;
            }
        </style>
        <?php
        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "mini_admin")) {
            ?>
            <style>
                #nav-menu-item-5094,#mobile-menu-item-5094,#mobile-menu-item-5015,#nav-menu-item-5015, #mobile-menu-item-5014,#nav-menu-item-5014, #mobile-menu-item-5023,#nav-menu-item-5023, #mobile-menu-item-5040,#nav-menu-item-5040, #mobile-menu-item-5038,#nav-menu-item-5038, #mobile-menu-item-5039,#nav-menu-item-5039{
                    display: inherit;
                }
            </style>
        <?php }
         if ((is_user_logged_in()) && ($roles[0] == "mini_admin")) {
            ?>
            <style>
                #nav-menu-item-5094,#mobile-menu-item-5094{
                    display: none;
                }
            </style>
        
         <?php } ?>
        <?php
        if ((is_user_logged_in()) && ($roles[0] == "trainer" || $roles[0] == "group_leader")) {
            ?>
            <style>
                #mobile-menu-item-5014,#nav-menu-item-5014, #mobile-menu-item-5023,#nav-menu-item-5023, #mobile-menu-item-5038,#nav-menu-item-5038, #mobile-menu-item-5015,#nav-menu-item-5015{
                    display: inherit;
                }
            </style>
<?php } ?>
        <?php
        if ((is_user_logged_in()) && ($roles[0] == "subscriber")) {
            ?>
            <style>
                #mobile-menu-item-5041,#nav-menu-item-5041, #mobile-menu-item-5014,#nav-menu-item-5014, #mobile-menu-item-5023,#nav-menu-item-5023, #mobile-menu-item-5015,#nav-menu-item-5015, #mobile-menu-item-4506,#nav-menu-item-4506{
                    display: inherit !important;
                }
            </style>
<?php } ?>
        <?php if (is_user_logged_in()) { ?>
            <style>
                #mobile-menu-item-4797,#nav-menu-item-4797, #mobile-menu-item-4505,#nav-menu-item-4505, #mobile-menu-item-4912,#nav-menu-item-4912, #mobile-menu-item-4506,#nav-menu-item-4506{
                    display: none;
                }
            </style>
<?php } ?>
 <?php if ((is_user_logged_in()) && ($roles[0] == "administrator" || $roles[0] == "trainer" || $roles[0] == "group_leader" || $roles[0] == "mini_admin")) { ?> 
        <script>
            if (window.location.href == "<?php echo home_url("/")?>") {
    	
                window.location.href = "<?php echo home_url("/dashboard/")?>";
            }
        </script>
    <?php }
    ?> 
         <?php if ((is_user_logged_in()) && ($roles[0] == "subscriber")) { ?> 
        <script>
            if (window.location.href == "<?php echo home_url("/")?>") {
    	
                window.location.href = "<?php echo home_url("/all-courses/")?>";
            }
        </script>
        <script>
            if (window.location.href == "<?php echo home_url("/dashboard/")?>") {
    	
                window.location.href = "<?php echo home_url("/all-courses/")?>";
            }
        </script>
    <?php }
    ?> 
        <?php
        /**
         * esmarts_elated_action_header_meta hook
         *
         * @see esmarts_elated_header_meta() - hooked with 10
         * @see esmarts_elated_user_scalable_meta - hooked with 10
         * @see eltdf_core_set_open_graph_meta - hooked with 10
         */
        do_action('esmarts_elated_action_header_meta');

        wp_head();
        ?>
    </head>
    <body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
        <?php
        /**
         * esmarts_elated_action_after_body_tag hook
         *
         * @see esmarts_elated_get_side_area() - hooked with 10
         * @see esmarts_elated_smooth_page_transitions() - hooked with 10
         */
        do_action('esmarts_elated_action_after_body_tag');
        ?>

        <div class="eltdf-wrapper">
            <div class="eltdf-wrapper-inner">
                <?php
                /**
                 * esmarts_elated_action_after_wrapper_inner hook
                 *
                 * @see esmarts_elated_get_header() - hooked with 10
                 * @see esmarts_elated_get_mobile_header() - hooked with 20
                 * @see esmarts_elated_back_to_top_button() - hooked with 30
                 * @see esmarts_elated_get_header_minimal_full_screen_menu() - hooked with 40
                 */
                do_action('esmarts_elated_action_after_wrapper_inner');
                ?>

                <div class="eltdf-content" <?php esmarts_elated_content_elem_style_attr(); ?>>
                    <div class="eltdf-content-inner">