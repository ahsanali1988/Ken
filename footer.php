<script src="<?php bloginfo('template_url');?>/assets/js/bootstrap.min.js"></script>
<script>
    jQuery(document).ready(function ()
    {
        
        jQuery('#redirect').val('<?php echo home_url("/users-redirect/")?>');
        jQuery('.eltdf-register-opener').attr('href', '/contact-us/');
        jQuery('.eltdf-register-opener').removeAttr('data-modal');
        jQuery('.eltdf-register-opener').on('click', function () {
            window.location.href = "<?php echo home_url("/contact-us/")?>";
        })
    })</script>
<?php
do_action('esmarts_elated_get_footer_template');
