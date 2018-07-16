<?php
/*

  Template Name: Contact Form Template

 */
get_header();

?>

<div class="container eltdf-row-grid-section">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="wpb_text_column wpb_content_element">
                    <div class="wpb_wrapper"><h3>Contact Us</h3></div>
                </div>
                <div class="main-member-container" id="main-member-container">
                	<div class="contactForm">
                    	<form action="" method="post" name="form1">
    	                	<div class="row">
    	                		<div class="col-md-12">
    	                			<div class="form-group">
                                        <label for="username" class="control-label">Subject:</label>
    	                				<input type="text" class="form-control">
    	                			</div>
    	                		</div>
    	                		<div class="col-md-12">
    	                			<div class="form-group">
                                        <label for="username" class="control-label">Message:</label>
    	                				<textarea class="form-control"></textarea>
    	                			</div>
    	                		</div>
    	                	</div>
                            <div class="form-group">
                                <div class="eltdf-contact-form-animation pull-right">
                                    <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                    <input type="submit" class="wpcf7-form-control wpcf7-submit" value="Submit"/>
                                </div>
                            </div>
    	                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.contactForm {
    max-width: 500px;
    margin: 0 auto;
}
.main-member-container {
    color: #000;
    font-family: Montserrat,sans-serif;
    font-size: 12px;
}
.form-control {
    display: block;
    width: 100%;
    height: 35px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc !important;
    border-radius: 4px !important;
    -webkit-border-radius: 4px !important;
    -moz-border-radius: 4px !important;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    font-family: Montserrat,sans-serif;
    margin: 0 0 15px !important;
    line-height: 35px;
}
textarea.form-control {
    min-height: 100px;
    resize: vertical;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.wpb_wrapper {text-align: center;}
label.control-label {
    font-family: Montserrat,sans-serif;
    font-size: 14px;
    color: #000;
    line-height: 18px;
    display: inline-block;
}
.panel {
    padding: 0 0 50px;
    overflow: hidden;
    clear: both;
}
</style>
<?php get_footer(); ?>