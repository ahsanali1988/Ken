<?php
/*

  Template Name: Register Form

 */
get_header();
$current_user = wp_get_current_user();
$roles = $current_user->roles;
if ((is_user_logged_in()) && ($roles[0] == "subscriber" )) {

    if (!function_exists('wp_handle_upload')) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
    $user_id = "";
    if (isset($_REQUEST['form2']) && trim($_REQUEST['form2']) != "") {

        update_user_meta($current_user->ID, 'form2', $_REQUEST);
    }
    if (isset($_REQUEST['form3']) && trim($_REQUEST['form3']) != "") {

        update_user_meta($current_user->ID, 'form3', $_REQUEST);
    }
    if (isset($_REQUEST['form4']) && trim($_REQUEST['form4']) != "") {

        // upload files //
        $uploadedfile = $_FILES['file1'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
        if ($movefile && !isset($movefile['error'])) {
            $_REQUEST['file1'] = $movefile['url'];
        }
        $uploadedfile = $_FILES['file2'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
        if ($movefile && !isset($movefile['error'])) {
            $_REQUEST['file2'] = $movefile['url'];
        }
        // upload files end //
        update_user_meta($current_user->ID, 'form4', $_REQUEST);
    }
    if (isset($_REQUEST['form5']) && trim($_REQUEST['form5']) != "") {
        if (isset($_REQUEST['Signature']) && trim($_REQUEST['Signature']) != "") {
            update_user_meta($current_user->ID, 'enrolment-acceptance', $_REQUEST);
        }
         $form2 = get_user_meta($current_user->ID, 'form2');
        $form3 = get_user_meta($current_user->ID, 'form3');
        $form4 = get_user_meta($current_user->ID, 'form4');
        $subject = "Student Enrollment Form";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Key Institute <info@keyinstitute.com>' . " \r\n";
        $headers .= "Bcc: admin@keyinsitute.com.au\r\n";
        $body = '<body style="margin:0; padding:0; background:#fff;" link="#ffffff">
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
	<tr>
		<td>
			<table width="600" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td style="padding: 30px 15px 0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #575757;">
						<p style="text-align: center; margin: 0 0 15px;">To view this message in your browser please <a href="#"><span style="color: #2b6d85">click here</span></a></p>
					</td>
				</tr>
				<tr>
					<td valign="top" style="border: 2px solid #eee;padding: 44px 10px;">
						<table width="800" cellspacing="0" cellpadding="0">
							
							<tr>
								<td>
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td valign="top" align="center" style="border-bottom: 1px solid #ccc;padding-bottom: 25px;" >
												<a href="'.home_url().'"><img src="http://members.keyinstitute.com.au/wp-content/uploads/2018/06/logo.png" width="139" height="72" border="0" title="logo" alt="Image" /></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td valign="top" align="center" style="padding-bottom: 25px;padding-top: 25px;" >
												<strong style="display:block;font-size:30px;">User Detail</strong>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
							<tr>
								<td align="left" style="padding-top:20px;">
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td align="left" valign="top" width="50%" style="padding-right: 10px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">What is the address of your usual residence?</strong>
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Building/Property name
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['property_name'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Flat/Unit details
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['unit_details'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Street or lot number
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['street_lot'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Street name
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['street_name'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Suburb, locality or town
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['suburb_locality'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																State/territory
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['state_territory'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Postcode
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['postcode'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td align="left" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">What is your postal address (if different from above)?</strong>
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Building/Property name
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['property_name1'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Flat/Unit details
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['unit_details1'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Street or lot number
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['street_lot1'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Street name
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['street_name1'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Postal delivery information
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['po_box'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Suburb, locality or town
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['suburb_locality1'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																State/territory
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['state_territory1'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																Postcode
															</th>
															<td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form2[0]['postcode1'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td align="left" valign="top" width="50%" style="padding-right: 10px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Language and Cultural Diversity</strong>
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">In which country were you born?</strong>
																'.$form2[0]['count_born'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Do you speak a language other than English at home?</strong>
																'.$form2[0]['more_english'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Are you of Aboriginal or Torres Strait Islander origin?</strong>
																'.$form2[0]['torres_island'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td align="left" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td valign="top" align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Disability</strong>
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Do you consider yourself to have a disability, impairment or long-term condition?</strong>
																'.$form2[0]['diability'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">
																	If you indicated the presence of a disability, impairment or long-term condition, please select the area(s) in the following list:
																</strong>
																'.$form2[0]['disability_list'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">If you answered YES to the above question do you require any assistance to participate in this course?</strong>
																'.$form2[0]['participate'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td align="left" valign="top" width="50%" style="padding-right: 10px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Schooling</strong>
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">What is your highest COMPLETED school level?</strong>
																'.$form3[0]['school_level'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Are you still enrolled in secondary or senior secondary education?</strong>
																'.$form3[0]['secondary_level'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td align="left" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td valign="top" align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Previous Qualifications Achieved</strong>
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Have you SUCCESSFULLY completed any of the following qualifications listed below?</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['qualification'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Bachelor Degree or Higher Degree</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['higher_degree'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Advanced Diploma or Associate Degree</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['advanced_degree'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Diploma (or Associate Diploma)</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['diploma'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Certificate IV (or Advanced Certificate/Technician)</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['certificate_iv'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Certificate III (or Trade Certificate)</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['certificate_iii'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Certificate II</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['certificate_ii'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Certificate I</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['certificate_i'].'
															</td>
														</tr>
														<tr>
															<th align="left" style="padding:10px;border-bottom:1px solid #ccc;">Certificates other than the above</th>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																'.$form3[0]['certificate_above'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td align="left" valign="top" width="50%" style="padding-right: 10px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Employer Details</strong>
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Enter your current employment information (where applicable)</strong>
																'.$form3[0]['organization_name'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Your position</strong>
																'.$form3[0]['your_position'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Supervisor name</strong>
																'.$form3[0]['supervisor_name'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Employers street address</strong>
																'.$form3[0]['street_address'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Suburb, locality or town</strong>
																'.$form3[0]['suburb_locality'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">State/territorys</strong>
																'.$form3[0]['state_territory'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Postcode</strong>
																'.$form3[0]['postcode'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Telephone</strong>
																'.$form3[0]['telephone'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Fax</strong>
																'.$form3[0]['fax'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Email</strong>
																'.$form3[0]['Email'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Website</strong>
																'.$form3[0]['website'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>

											<td align="left" valign="top" width="50%" style="padding-right: 10px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td valign="top" align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Study Reason</strong>
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Study Reason - Of the following categories, which BEST describes your main reason for undertaking this course / traineeship /apprenticeship? </strong>
																'.$form4[0]['study_reason'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td align="left" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td valign="top" align="left" colspan="2">
																<strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">Unique Student Identifier</strong>
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">I already have a USI (copy number below) </strong>
																'.$form4[0]['usi_number'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Please supply two forms of identification from the list below </strong>
																'.$form4[0]['usi_identification'].'
															</td>
														</tr>
														<tr>
															<td valign="top" align="left" style="padding:10px;border-bottom:1px solid #ccc;">
																<strong style="display:block;">Nominate your preferred method of contact by the USI Office - for notification of your USI Number & for access to your account: </strong>
																'.$form4[0]['nominate_usi'].'
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>										
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>';
        $message = $body;
        mail($current_user->user_email, $subject, $message, $headers);
    }
    $enrolmentAcceptance = get_user_meta($current_user->ID, 'enrolment-acceptance');
    if (isset($enrolmentAcceptance[0]) && count($enrolmentAcceptance[0]) > 0) {
        echo "<script>window.location.href= '" . home_url() . "/all-courses/'</script>";
        exit;
    }
    ?>

    <div class="container eltdf-row-grid-section">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="wpb_text_column wpb_content_element">
                        <div class="wpb_wrapper" style="text-align: center"><h3>User Detail</h3></div>
                    </div>
                    <div class="main-member-container" id="main-member-container">
                        <?php if (trim($_REQUEST['one']) == "") { ?>
                            <ul class="formWizar">
                                <li class="active"><span>1</span></li>
                                <li><span>2</span></li>
                                <li><span>3</span></li>
                                <li><span>4</span></li>
                            </ul>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-sm-12">

<!--                                        <p>
                                            Please provide the physical address (street number and name not post office box) where you usually reside rather than any temporary address at which you reside for training, work or other purposes before returning to your home. <br>
                                            If you are from a rural area use the address from your state or territory's 'rural property addressing' or 'numbering' system as your residential street address. <br>
                                            Building/property name is the official place name or common usage name for an address site, including the name of a building, Aboriginal community, homestead, building complex, agricultural property, park or unbounded address site.
                                        </p>-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <strong class="f-sub-heading">What is the address of your usual residence?</strong> 
                                        <div class="form-group">
                                            <label for="residence" class="control-label">Building/Property name</label>
                                            <input type="text" id="property-name" name="property_name" class="form-control"  required="" value=""  placeholder="Building/Property name" />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Flat/Unit details</label>
                                                    <input type="text" id="unit-details" name="unit_details" class="form-control"  required="" value=""  placeholder="Flat/Unit details" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Street or lot number </label>
                                                    <input type="text" id="street-lot" name="street_lot" class="form-control"  required="" value=""  placeholder="(e.g. 205 or Lot 118)" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Street name</label>
                                                    <input type="text" id="street-name" name="street_name" class="form-control"  required="" value=""  placeholder="Street name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Suburb, locality or town</label>
                                                    <input type="text" id="suburb-locality" name="suburb_locality" class="form-control"  required="" value=""  placeholder="Suburb, locality or town" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">State/territory</label>
                                                    <input type="text" id="state-territory" name="state_territory" class="form-control"  required="" value=""  placeholder="State/territory" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Postcode</label>
                                                    <input type="text" id="postcode" name="postcode" class="form-control"  required="" value=""  placeholder="Postcode" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <strong class="f-sub-heading">What is your postal address (if different from above)?</strong>
                                        <div class="form-group">
                                            <label for="residence" class="control-label">Building/Property name</label>
                                            <input type="text" id="property-name1" name="property_name1" class="form-control"  value=""  placeholder="Building/Property name" />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Flat/Unit details</label>
                                                    <input type="text" id="unit-details1" name="unit_details1" class="form-control"   value=""  placeholder="Flat/Unit details" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Street or lot number </label>
                                                    <input type="text" id="street-lot1" name="street_lot1" class="form-control"   value=""  placeholder=" (e.g. 205 or Lot 118)" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Street name</label>
                                                    <input type="text" id="street-name1" name="street_name1" class="form-control"   value=""  placeholder="Street name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Postal delivery information </label>
                                                    <input type="text" id="po-box" name="po_box" class="form-control"   value=""  placeholder=" (e.g. PO Box 254)" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Suburb, locality or town</label>
                                                    <input type="text" id="suburb-locality1" name="suburb_locality1" class="form-control"  value=""  placeholder="Suburb, locality or town" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">State/territory</label>
                                                    <input type="text" id="state-territory1" name="state_territory1" class="form-control"  value=""  placeholder="State/territory" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="residence" class="control-label">Postcode</label>
                                                    <input type="text" id="postcode1" name="postcode1" class="form-control"  value=""  placeholder="Postcode" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <strong class="f-sub-heading">Language and Cultural Diversity</strong>
                                        <div class="form-group">
                                            <label for="count-born" class="control-label">In which country were you born?</label>
                                            <select name="count_born" id="count-born" class="form-control"  required="">
                                                <option value="">Please Select</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Other – please specify">Other - please specify</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="more-english" class="control-label">Do you speak a language other than English at home?</label>
                                            <select name="more_english" id="more-english" class="form-control"  required="">
                                                <option value="">Please Select</option>
                                                <option value="No – English only">No - English only</option>
                                                <option value="Yes – please specify">Yes - please specify</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="torres-island" class="control-label">Are you of Aboriginal or Torres Strait Islander origin?</label>
                                            <select name="torres_island" id="torres-island" class="form-control"  required="">
                                                <option value="">Please Select</option>
                                                <option value="No">No</option>
                                                <option value="Yes, Aboriginal">Yes, Aboriginal</option>
                                                <option value="Yes, Torres Strait Islander">Yes, Torres Strait Islander</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <strong class="f-sub-heading">Disability</strong>
                                        <div class="form-group">
                                            <label for="disablity" class="control-label">Do you consider yourself to have a disability, impairment or long-term condition?</label>
                                            <select name="diability" id="diability" class="form-control"  required="">
                                                <option value="">Please Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No (Go to the next section)">No (Go to the next section)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="disability-list" class="control-label">If you indicated the presence of a disability, impairment or long-term condition, please select the area(s) in the following list:</label>
                                            <select name="disability_list" id="disability-list" class="form-control"  >
                                                <option value="">Please Select</option>
                                                <option value="Hearing/deaf">Hearing/deaf</option>
                                                <option value="Physical">Physical</option>
                                                <option value="Intellectual">Intellectual</option>

                                                <option value="Learning">Learning</option>
                                                <option value="Mental illness">Mental illness</option>
                                                <option value="Acquired brain impairment">Acquired brain impairment</option>
                                                <option value="Vision">Vision</option>
                                                <option value="Medical condition">Medical condition</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="participate" class="control-label">If you answered YES to the above question do you require any assistance to participate in this course?</label>
                                            <select name="participate" id="participate" class="form-control" >
                                                <option value="">Please Select</option>
                                                <option value="No">No</option>
                                                <option value="Yes (We\ll arrange a meeting to discuss this with you)">Yes (We\ll arrange a meeting to discuss this with you)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="eltdf-contact-form-animation pull-right">
                                        <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                        <input type="submit" class="wpcf7-form-control wpcf7-submit" value="NEXT"/>
                                    </div>
                                </div> 



                                <input type="hidden" id="form-id" name="form2" value="1" />
                                <input type="hidden" id="form-id" name="one" value="1" />
                            </form>
                        <?php } ?>
                        <?php if (isset($_REQUEST['form2']) && trim($_REQUEST['form2']) != "") { ?>
                            <ul class="formWizar">
                                <li class="done"><span>1</span></li>
                                <li class="active"><span>2</span></li>
                                <li><span>3</span></li>
                                <li><span>4</span></li>
                            </ul>
                            <form action="" method="post">
                                <strong class="f-sub-heading">Schooling</strong>

                                <div class="form-group">
                                    <label for="school-level" class="control-label">
                                        What is your highest COMPLETED school level?
                                        <span class="sub-txt">
                                            If you are currently enrolled in secondary education, the Highest school level completed refers to the highest school level you have actually completed and not the level you are currently undertaking. For example, if you are currently in Year 10 the Highest school level completed is Year 9.
                                            <br>(Tick ONE box only)
                                        </span>
                                    </label>

                                    <select name="school_level" id="school-level" class="form-control"  required="">
                                        <option value="">Please Select</option>
                                        <option value="Completed Year 12">Completed Year 12</option>
                                        <option value="Completed Year 11">Completed Year 11</option>
                                        <option value="Completed Year 10">Completed Year 10</option>
                                        <option value="Completed Year 9 or equivalent">Completed Year 9 or equivalent</option>
                                        <option value="Completed Year 8 or lower">Completed Year 8 or lower</option>
                                        <option value="Never attended school">Never attended school</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="secondary_level" class="control-label">Are you still enrolled in secondary or senior secondary education?</label>
                                    <select name="secondary_level" id="secondary-level" class="form-control"  required="">
                                        <option value="">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <strong class="f-sub-heading">Previous Qualifications Achieved</strong>

                                <div class="form-group">
                                    <label for="qualification" class="control-label">Have you SUCCESSFULLY completed any of the following qualifications listed below?</label>
                                    <select name="qualification" id="qualification" class="form-control"  required="">
                                        <option value="">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <!-- <ul style="list-style: none">
                                    Yes (if yes, please enter one of these Prior Education Achievement Recognition Identifiers any applicable qualification level.)
                                    <li>
                                        A - Australian
                                    </li>
                                    <li>
                                        E - Australian equivalent
                                    </li>
                                    <li>
                                        I - International
                                    </li>
                                </ul> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="higher-degree" class="control-label">Bachelor Degree or Higher Degree</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="higher_degree" id="higher-degree" class="form-control" >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="advanced-degree" class="control-label">Advanced Diploma or Associate Degree</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="advanced_degree" id="advanced-degree" class="form-control" >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="diploma" class="control-label">Diploma (or Associate Diploma)</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="diploma" id="diploma" class="form-control" >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="certificate-iv" class="control-label">Certificate IV (or Advanced Certificate/Technician)</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="certificate_iv" id="certificate-iv" class="form-control"  >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="certificate-iii" class="control-label">Certificate III (or Trade Certificate)</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="certificate_iii" id="certificate-iii" class="form-control"  >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="certificate-ii" class="control-label">Certificate II</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="certificate_ii" id="certificate-ii" class="form-control"  >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="certificate-i" class="control-label">Certificate I</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="certificate_i" id="certificate-i" class="form-control"  >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="certificate-above" class="control-label">Certificates other than the above</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="certificate_above" id="certificate-above" class="form-control" >
                                                        <option value="">Please Select</option>
                                                        <option value="Australian">Australian</option>
                                                        <option value="Australian equivalent">Australian equivalent</option>
                                                        <option value="International">International</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <strong class="f-sub-heading">Employer Details</strong>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employ-info" class="control-label">Enter your current employment information (where applicable)</label>
                                            <input type="text" class="form-control"   name="organization_name" placeholder="Employer organisation name"  value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="your-position" class="control-label">Your position</label>
                                            <input type="text" class="form-control"   name="your_position" placeholder="Your position"  value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="supervisor-name" class="control-label">Supervisor name</label>
                                            <input type="text" class="form-control"  name="supervisor_name" placeholder="Supervisor name"  value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="street-address" class="control-label">Employers street address</label>
                                            <input type="text" class="form-control"  name="street_address" placeholder="Employers street address"  value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="suburb-locality" class="control-label">Suburb, locality or town</label>
                                            <input type="text" class="form-control"   name="suburb_locality" placeholder="Suburb, locality or town"  value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state-territory" class="control-label">State/territorys</label>
                                            <input type="text" class="form-control"   name="state_territory" placeholder="State/territorys"  value="" />
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="postcode" class="control-label">Postcode</label>
                                            <input type="text" class="form-control"   name="postcode" placeholder="Postcode"  value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telephone" class="control-label">Telephone</label>
                                            <input type="text" class="form-control"   name="telephone" placeholder="Telephone"  value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax" class="control-label">Fax</label>
                                            <input type="text" class="form-control"  name="fax" placeholder="Fax"  value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="control-label">Email</label>
                                            <input type="text" class="form-control"  name="Email" placeholder="Email"  value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website" class="control-label">Website</label>
                                            <input type="text" class="form-control"  name="website" placeholder="Website"  value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="eltdf-contact-form-animation pull-right">
                                                <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                                <input type="submit" class="wpcf7-form-control wpcf7-submit" value="NEXT"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="form-id" name="form3" value="1" />
                                <input type="hidden" id="form-id" name="one" value="1" />
                            </form>
                        <?php } ?>
                        <?php if (isset($_REQUEST['form3']) && trim($_REQUEST['form3']) != "") { ?>
                            <ul class="formWizar">
                                <li class="done"><span>1</span></li>
                                <li class="done"><span>2</span></li>
                                <li class="active"><span>3</span></li>
                                <li><span>4</span></li>
                            </ul>
                            <form action="" method="post" enctype="multipart/form-data">
                                <strong class="f-sub-heading">Study Reason</strong>
                                <div class="form-group">
                                    <span class="sub-txt">Study Reason - Of the following categories, which BEST describes your main reason for undertaking this course / traineeship /apprenticeship? <br>(Tick ONE box only)</span>
                                    <select name="study_reason" id="study-reason" class="form-control"  required="">
                                        <option value="">Please Select</option>
                                        <option value="To get a job">To get a job</option>
                                        <option value="To develop my business">To develop my business</option>
                                        <option value="To start my own business">To start my own business</option>
                                        <option value="To try for a different career">To try for a different career</option>
                                        <option value="To get a better job or promotion">To get a better job or promotion</option>
                                        <option value="It was a requirement of my job">It was a requirement of my job</option>
                                        <option value="I wanted extra skills for my job">I wanted extra skills for my job</option>
                                        <option value="To get into another course of study">To get into another course of study</option>
                                        <option value="For personal interest or self-development">For personal interest or self-development</option>
                                        <option value="Other reasons">Other reasons</option>
                                    </select>
                                </div>
                                <strong class="f-sub-heading">Unique Student Identifier</strong>
                                <span class="sub-txt">From 1 January 2015, KEY INSTITUTE RTO can be prevented from issuing you with a nationally recognised VET qualification or statement of attainment when you complete your course if you do not have a Unique Student Identifier (USI). If you have not yet obtained a USI you can apply for it directly at <a href="http://www.usi.gov.au/create-your-USI/" target="_blank">http://www.usi.gov.au/create-your-USI/</a> on computer or mobile device. Please note that if you would like to specify your gender as 'other' you will need to contact the USI Office for assistance. <br> To enable KEY INSTITUTE to enrol you in a course, you must either supply us with your USI (which we will verify) or give us permission to create a USI on your behalf.</span>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">I already have a USI (copy number below)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="usi_number" class="form-control"  required="" placeholder="x-x-x-x-x-x-x-x-x-x" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qualification" class="control-label">Please supply two forms of identification from the list below </label>
                                    <select name="usi_identification" id="usi-identification" class="form-control"  required="">
                                        <option value="">Please Select</option>
                                        <option value="Drivers Licence">Drivers Licence</option>
                                        <option value="Medicare Card">Medicare Card</option>
                                        <option value="Australian Passport">Australian Passport</option>
                                        <option value="Full Birth Certificate (Australian)">Full Birth Certificate (Australian)</option>
                                        <option value="Immicard">Immicard</option>
                                        <option value="Citizenship Certificate">Citizenship Certificate</option>
                                        <option value="Certificate of Registration by Descent">Certificate of Registration by Descent</option>
                                        <option value="Visa (with non-Australian Passport of International Students)">Visa (with non-Australian Passport of International Students)</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qualification" class="control-label">Upload Form 1</label>
                                            <input type="file" class="form-control"  required="" name="file1"  value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qualification" class="control-label">Upload Form 2</label>
                                            <input type="file" class="form-control"  required="" name="file2"  value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qualification" class="control-label">Nominate your preferred method of contact by the USI Office - for notification of your USI Number & for access to your account:</label>
                                    <select name="nominate_usi" id="nominate-usi" class="form-control"  required="">
                                        <option value="">Please Select</option>
                                        <option value="Email">Email</option>
                                        <option value="Phone">Phone</option>
                                        <option value="Mail">Mail</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="eltdf-contact-form-animation pull-right">
                                        <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                        <input type="submit" class="wpcf7-form-control wpcf7-submit" value="NEXT"/>
                                    </div>
                                </div>
                                <input type="hidden"  name="form4" value="1" />
                                <input type="hidden"  name="one" value="1" />
                            </form>
                        <?php } ?>
                        <?php if (isset($_REQUEST['form4']) && trim($_REQUEST['form4']) != "") { ?>
                            <ul class="formWizar">
                                <li class="done"><span>1</span></li>
                                <li class="done"><span>2</span></li>
                                <li class="done"><span>3</span></li>
                                <li class="active"><span>4</span></li>
                            </ul>
                            <div class="container eltdf-row-grid-section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="wpb_text_column wpb_content_element">
                                                <div class="wpb_wrapper"><h3>Enrolment Acceptance</h3></div>
                                            </div>
                                            <div class="main-member-container" id="main-member-container">
                                                <p>By confirming my enrolment, I agree to the following:</p>
                                                <ul>
                                                    <li>I have read and accept Key Instituteâ€™s Privacy Policy</li>
                                                    <li>I have read Key Instituteâ€™s Student Handbook and I understand the requirements of this course</li>
                                                    <li>I agree that I will not plagiarise the work of others or participate in any unauthorized collusion when completing and submitting my coursework.</li>
                                                    <li>I agree that Key Institute will not be liable for any plagiarism or other forms of fraudulent activity or acts caused by me during the completion of my course.</li>
                                                    <li>I agree to adhere to study schedules, where a study schedule has been applied.</li>
                                                    <li>I agree to notify Key Institute of any change to my personal details.</li>
                                                    <li>I consent to sharing my course progress information, which may include my personal information with the relevant parties listed including (but not limited to) Jobs Services Australia provider, or my Disability Employment Services / Disability Assistance provider.</li>
                                                </ul>
                                                <p>I agree that Key Institute may from time to time update these terms and conditions relating to its courses, which shall be deemed to be accepted by me after receiving written notice from Key Institute and including by way of electronic mail or email.</p>
                                                <form action="" method="post" name="form1">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="username" class="control-label">Applicant Signature:</label>
                                                                <input type="text" class="form-control"  name="Signature">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="username" class="control-label">Date:</label>
                                                                <input type="text" class="form-control"  name="date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="eltdf-contact-form-animation pull-right">
                                                            <!--<a href="javascript:coid(0)" class="wpcf7-form-control wpcf7-submit" >Next</a>-->
                                                            <input type="submit" class="wpcf7-form-control wpcf7-submit" value="FINISH"/>
                                                        </div>
                                                    </div>
                                                    <input type="hidden"  name="form5" value="1" />
                                                    <input type="hidden"  name="one" value="1" />
                                                    <input type="hidden"  name="user_date" value="<?php echo strtotime(date('Y-m-d')) ?>" />
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        //    jQuery(document).ready(function () {
        //        jQuery('#member-button-click').on('click', function () {
        //            var form_id = jQuery('#form-id').val();
        //            if (form_id == 1) {
        //                var dataString = {action: 'member_multiple_form_registration', form: jQuery('#form-id').val(), email: jQuery('#email').val(), username: jQuery('#user-name').val(), password: jQuery('#password').val()};
        //                $.ajax({
        //                    url: "/wp-admin/admin-ajax.php",
        //                    type: 'POST',
        //                    data: dataString,
        //                    dataType: 'json',
        //                    success: function (response) {
        //                        console.log(response);
        //                    }
        //                });
        //            } else if (form_id == 2) {
        //
        //            } else if (form_id == 3) {
        //
        //            }
        //        });
        //    });
    </script>
    <style type="text/css">
        .form-control {
            display: block;
            width: 100%;
            height: 35px !important;
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
        .pull-right {float: right;}
        strong.f-sub-heading {
            display: block;
            padding: 10px;
            margin: 20px 0;
            background: #5270ff;
            color: #fff;
            font-family: Montserrat,sans-serif;
            clear: both;
        }
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
        .sub-txt {
            display: block;
            padding: 5px 0 15px;
            font-size: 75%;
            line-height: 1.5;
        }
        .formWizar {
            text-align: center;
            list-style: none;
            padding:  0 0 30px;
            margin: 0;
        }
        .formWizar li {
            display: inline-block;
            vertical-align: top;
            padding: 0 5%;
            position: relative;
        }
        .formWizar li span {
            display: block;
            width: 40px;
            height: 40px;
            background: #ddd;
            color: #000;
            line-height: 40px;
            border-radius: 100%;
            z-index: 9;
            position: relative;
        }
        .formWizar li.active span{ background: #5270ff; color: #fff;}
        .formWizar li.done span { background: #00d2c8; color: #fff;}
        .formWizar li::after {
            content:  '';
            border-bottom: 5px solid #ddd;
            position:  absolute;
            top: 18px;
            left: 50%;
            width:  100%;
            margin-left: -90%;
        }
        .formWizar li:first-child::after {
            border: none;
        }
        .formWizar li.active::after {border-bottom-color:#4360e8; }
        .formWizar li.done::after {
            border-bottom-color: #00d2c8;
        }
        .row {
            clear: both;
        }
    </style>
    <?php get_footer(); ?>

    <?php
} else {
    echo "<script>window.location.href = '" . home_url() . "'</script>";
    exit;
}
?>