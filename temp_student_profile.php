<?php
/*

  Template Name: Student Profile

 */
redirectUser();
if (isset($_REQUEST['studentID']) && trim($_REQUEST['studentID']) != "") {
    get_header();
    $userID = $_REQUEST['studentID'];
    $udata = get_userdata($userID);
    $form1 = get_user_meta($userID, 'form1');
    $form2 = get_user_meta($userID, 'form2');
    $form3 = get_user_meta($userID, 'form3');
    $form4 = get_user_meta($userID, 'form4');
    $user_login_history = get_user_meta($userID, 'user_login_history');
    $lastLogin = "Not logged in yet";
    if (isset($user_login_history[0]) && count($user_login_history[0]) > 0) {
        $lastLogin = $user_login_history[0][count($user_login_history[0]) - 1];
        $lastLogin = date("d-M-Y", $lastLogin);
    }
    ?>

    <style>

        .spinner {
            width: 70px;
            height: 25px;
            text-align: center;
            display:inline-block;
            margin-left:10px;
            display:none;
        }

        .spinner > div {
            width: 18px;
            height: 18px;
            background-color: #5270ff;

            border-radius: 100%;
            display: inline-block;
            -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        }

        .spinner .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .spinner .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        @-webkit-keyframes sk-bouncedelay {
            0%, 80%, 100% { -webkit-transform: scale(0) }
            40% { -webkit-transform: scale(1.0) }
        }

        @keyframes sk-bouncedelay {
            0%, 80%, 100% { 
                -webkit-transform: scale(0);
                transform: scale(0);
            } 40% { 
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
            }
        }


    </style>

    <div class="eltdf-container eltdf-default-page-template">
        <?php do_action('esmarts_elated_action_after_container_open'); ?>
        <div class="eltdf-container-inner clearfix">
            <div class="tab_wrap">
                <div class="inner_tab_link clearfix">
                    <ul>
                        <li class="active"><a href="#tab_1" role="tab" data-toggle="tab">Student Overview</a></li>
                        <li><a href="#tab_2" role="tab" data-toggle="tab">Enrolment details</a></li>
                        <li><a href="#tab_3" role="tab" data-toggle="tab">Identification</a></li>
                        <li><a href="#tab_4"  role="tab" data-toggle="tab">Assignments</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="tab_1">
                        <div class="table-responsive">
                            <table class="table_style_1 text-left">
                                <tbody>
                                    <tr>
                                        <th width="250">Name:</th>
                                        <td><?php echo $form1[0]['firstName'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number: </th>
                                        <td><?php echo $form3[0]['telephone'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email: </th>
                                        <td><?php echo $form1[0]['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Address: </th>
                                        <td><?php echo $form3[0]['street_address'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Active:</th>
                                        <td><?php echo $lastLogin ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_2">
                        <div class="table-responsive">
                            <div class="assignment_wrap"><div class="inner" style="text-align: center"><a href="<?php echo home_url('/pdf/?info=enr_') . $userID ?>"  target="_blank" class="btn_1" >Download enrollment</a></div></div>
                            <table class="table_style_1 enrollment_data text-left " width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px; background: #fff;"><table class="table_style_1 text-left enrollment_data" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">What is the address of your usual residence?</strong></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Building/Property name </th>
                                                    <td threegn="left" ><?php echo $form2[0]['property_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Flat/Unit details </th>
                                                    <td threegn="left" ><?php echo $form2[0]['unit_details'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street or lot number </th>
                                                    <td threegn="left" ><?php echo $form2[0]['street_lot'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street name </th>
                                                    <td threegn="left" ><?php echo $form2[0]['street_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Suburb, locthreety or town </th>
                                                    <td threegn="left" ><?php echo $form2[0]['suburb_locthreety'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > State/territory </th>
                                                    <td threegn="left" ><?php echo $form2[0]['state_territory'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Postcode </th>
                                                    <td threegn="left" ><?php echo $form2[0]['postcode'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">What is your postal address (if different from above)?</strong></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Building/Property name </th>
                                                    <td threegn="left" ><?php echo $form2[0]['property_name1'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Flat/Unit details </th>
                                                    <td threegn="left" ><?php echo $form2[0]['unit_details1'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street or lot number </th>
                                                    <td threegn="left" ><?php echo $form2[0]['street_lot1'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street name </th>
                                                    <td threegn="left" ><?php echo $form2[0]['street_name1'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Postal delivery information </th>
                                                    <td threegn="left" ><?php echo $form2[0]['po_box'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Suburb, locthreety or town </th>
                                                    <td threegn="left" ><?php echo $form2[0]['suburb_locthreety1'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > State/territory </th>
                                                    <td threegn="left" ><?php echo $form2[0]['state_territory1'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Postcode </th>
                                                    <td threegn="left" ><?php echo $form2[0]['postcode1'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Language and Cultural Diversity</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">In which country were you born?</strong> <?php echo $form2[0]['count_born'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Do you speak a language other than English at home?</strong> <?php echo $form2[0]['more_english'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Are you of Aboriginal or Torres Strait Islander origin?</strong> <?php echo $form2[0]['torres_island'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Disability</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Do you consider yourself to have a disability, impairment or long-term condition?</strong> <?php echo $form2[0]['diability'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;"> If you indicated the presence of a disability, impairment or long-term condition, please select the area(s) in the following list: </strong> <?php echo $form2[0]['disability_list'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">If you answered YES to the above question do you require any assistance to participate in this course?</strong> <?php echo $form2[0]['participate'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Schooling</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">What is your highest COMPLETED school level?</strong> <?php echo $form3[0]['school_level'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Are you still enrolled in secondary or senior secondary education?</strong> <?php echo $form3[0]['secondary_level'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Previous Quthreefications Achieved</strong></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Have you SUCCESSFULLY completed any of the following quthreefications listed below?</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['quthreefication'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Bachelor Degree or Higher Degree</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['higher_degree'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Advanced Diploma or Associate Degree</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['advanced_degree'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Diploma (or Associate Diploma)</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['diploma'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate IV (or Advanced Certificate/Technician)</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['certificate_iv'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate III (or Trade Certificate)</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['certificate_iii'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate II</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['certificate_ii'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate I</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['certificate_i'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificates other than the above</th>
                                                    <td vthreegn="top" threegn="left" ><?php echo $form3[0]['certificate_above'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Employer Details</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Enter your current employment information (where applicable)</strong> <?php echo $form3[0]['organization_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Your position</strong> <?php echo $form3[0]['your_position'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Supervisor name</strong> <?php echo $form3[0]['supervisor_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Employers street address</strong>
                                                        <?php echo $form3[0]['street_address'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Suburb, locthreety or town</strong> <?php echo $form3[0]['suburb_locthreety'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">State/territorys</strong> <?php echo $form3[0]['state_territory'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Postcode</strong> <?php echo $form3[0]['postcode'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Telephone</strong> <?php echo $form3[0]['telephone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Fax</strong> <?php echo $form3[0]['fax'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Email</strong> <?php echo $form3[0]['Email'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Website</strong> <?php echo $form3[0]['website'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                      <!--                                    <td threegn="left" vthreegn="top"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Employment</strong></td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td vthreegn="top" threegn="left" > xxxx </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table></td>--> 
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Study Reason</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Study Reason - Of the following categories, which BEST describes your main reason for undertaking this course / traineeship /apprenticeship? </strong> <?php echo $form4[0]['study_reason'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table class="table_style_1 enrollment_data text-left" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong style="text-threegn:left;display:block;padding: 10px;background: #42495b;color: #fff;">Unique Student Identifier</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">I already have a USI (copy number below) </strong> <?php echo $form4[0]['usi_number'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Please supply two forms of identification from the list below </strong> <?php echo $form4[0]['usi_identification'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Nominate your preferred method of contact by the USI Office - for notification of your USI Number & for access to your account: </strong> <?php echo $form4[0]['nominate_usi'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_3">
                            <div class="trainer_std_wrap">
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Identification</th>
                                                <th>Download</th>
                                                <!--<th>Date Submitted</th>-->
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td><?php echo $udata->display_name ?></td>
                                            <!--<td class="profile_user"><a href="#<?php echo $key ?>"  style="color: #5270FF"><?php echo $quiz['courseName']; ?></a></td>-->
                                            <td><?php echo $form4[0]['usi_identification'] ?></td>
                                            <td><a href="<?php echo $form4[0]['file1'] ?>" target="_blank" style="font-size:20px;" title="File 1"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                <a href="<?php echo $form4[0]['file2'] ?>" target="_blank" style="font-size:20px;" title="File 2"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                            <!--<td><?php echo $lastLogin ?></td>-->

                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <?php
                       
                        ?>   
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_4">
                        <?php
                        $quizz = get_user_meta($userID, "quizDataUser");
                        if (isset($quizz[0]) && count($quizz[0]) > 0) {
                            ?>
                            <div class="trainer_std_wrap">
                                <div class="table-responsive" id="quizStat">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Lesson Name</th>
                                                <th>Assessed</th>
                                                <th>Date Submitted</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($quizz[0] as $key => $quiz) {
                                            $today = strtotime(date("Y-m-d"));
                                            $lastLoginDisfference = $today - $quiz['submitted'];
                                            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                                            if ($lastLoginDays == 0) {
                                                $lastLogin = "Today";
                                            } else {
                                                $lastLogin = $lastLoginDays . " days ago";
                                            }
                                            ?>
                                            <tr>
                                                <!--<td class="profile_user"><a href="#<?php echo $key ?>"  style="color: #5270FF"><?php echo $udata->display_name ?></a></td>-->
                                                <td class="profile_user"><a href="javascript:void(0)" onclick="expd(<?php echo $key ?>)"  style="color: #5270FF"><?php echo $quiz['courseName']; ?></a></td>
                                                <td><?php echo $quiz['lessonName'] ?></td>
                                                <td><?php echo $quiz['approve'] == 1 ? "Competent" : "Not Yet Assessed" ?></td>
                                                <td><?php echo $lastLogin ?></td>
                                                <td><a href="javascript:void(0)" style="color: #5270FF" onclick="deleteQuiz(<?php echo $key ?>, <?php echo $userID ?>)">Delete</a>
            <!--                                                    <div class="spinner" id="<?php echo $key ?>">
                                                        <div class="bounce1"></div>
                                                        <div class="bounce2"></div>
                                                        <div class="bounce3"></div>
                                                    </div>-->
                                                </td>

                                            </tr>
                                            <tr class="user_full_data" id="<?php echo $key ?>">
                                                <td colspan="5">
                                                    <div class="assignment_sec">
                                                        <div class="assignment_top_bar">
                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    <div class="info">
                                                                        <p><?php echo $quiz['courseName'] ?></p>
                                                                        <p><?php echo $quiz['lessonName'] ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="donwload_wrap">
                                                                        <p><span>Download:</span> <a href="<?php echo home_url('/pdf/?info=pdf_') . $userID . "_" . $key ?>" target="_blank">PDF</a> | <a href="<?php echo home_url('/pdf/?info=csv_') . $userID . "_" . $key ?>" target="_blank">CSV</a></p>
                                                                        <p><?php echo $quiz['approve'] == 1 ? "Competent" : "Not Yet Assessed" ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="assignment_wrap">
                                                            <?php
                                                            $count = 0;
                                                            foreach ($quiz['question'] as $value) {
                                                                ?>
                                                                <div class="inner">
                                                                    <h3><?php echo $value ?></h3>
                                                                    <p><?php echo $quiz['ans'][$count] ?></p>
                                                                    <a href="javascript:void(0)" data-toggle="modal" onclick="getModal('correctFeedback',<?php echo $count ?>,<?php echo $userID ?>,<?php echo $key ?>)" class="btn_1">Correct</a> <a href="javascript:;" onclick="getModal('inCorrectFeedback',<?php echo $count ?>,<?php echo $userID ?>,<?php echo $key ?>)" class="btn_1" >Incorrect</a>
                                                                    <?php
                                                                    $class = "";
                                                                    if (isset($quiz['status'][$count]) && trim($quiz['status'][$count]) == "correct") {
                                                                        $class = "fa-check-circle";
                                                                    } else if (isset($quiz['status'][$count]) && trim($quiz['status'][$count]) == "inCorrect") {
                                                                        $class = "fa-window-close";
                                                                    }
                                                                    ?>
                                                                    <div class="check_uncheck"> <i id="corIn-<?php echo $count . "-" . $key ?>" class="fa  <?php echo $class ?>" aria-hidden="true"></i> </div>
                                                                    <div class="spinner" id="bb-<?php echo $key . "-" . $count ?>">
                                                                        <div class="bounce1"></div>
                                                                        <div class="bounce2"></div>
                                                                        <div class="bounce3"></div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $count++;
                                                            }
                                                            ?>
                                                            <!--                                                            <div class="inner">
                                                                                                                            <h3>Question 2. Explain the difference between open and closed questions?</h3>
                                                                                                                            <p>An open question is a question that requires a broad answer a closed question requires a one- two word answer. </p>
                                                                                                                            <a href="#modal_2" data-toggle="modal" class="btn_1">Correct</a> <a href="javascript:;" class="btn_1">Incorrect</a>
                                                                                                                            <div class="check_uncheck"> <i class="fa fa-check-circle" aria-hidden="true"></i> </div>
                                                                                                                        </div>-->
                                                            <div class="text-center inner"> <a href="javascript:void(0)" class="btn_1" onclick="sumbitEmail('resubmit', <?php echo $key ?>, <?php echo $userID ?>)">Request re-submission</a> <a href="javascript:void(0)" class="btn_1" onclick="sumbitEmail('submit', <?php echo $key ?>, <?php echo $userID ?>)">Submit Grading</a>    <div class="spinner" id="rr-<?php echo $key ?>">
                                                                    <div class="bounce1"></div>
                                                                    <div class="bounce2"></div>
                                                                    <div class="bounce3"></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </table>
                                </div>
                            </div>
                            <?php
                        } else {
                            echo 'No Pending Assignment';
                        }
                        ?>   
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Feedback</h4>
                    </div>
                    <div class="modal-body">
                        <!--<form>-->
                        <input type="hidden" name="type" id="type" value="">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="userID" id="userID" value="">
                        <input type="hidden" name="index" id="index" value="">
                        <textarea class="form-control" id="result"></textarea>
                        <a href="javascript:void(0)" class="btn_1" id="addFeedback" onclick="addFeedback()">Submit</a>
                        <div class="spinner pop">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    <!--<input type="submit" class="btn_1" value="Submit">-->
                        <!--</form>-->
                    </div>
                </div>
            </div>
        </div>
        <?php do_action('esmarts_elated_action_before_container_close'); ?>
    </div>
    <?php get_footer(); ?>
    <script>
        function sumbitEmail(type, id, userID) {
            jQuery('#rr-' + id).css({'display': 'inline-block'});
            var dataString = {action: 'sumbit_email', type: type, id: id, userID: userID};
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    jQuery('#rr-' + id).hide();
                    alert(response.msg);
                }
            });
        }
        function expd(obj) {
            var solution_tab = jQuery(this).attr("href");
            if (jQuery('#' + obj).is(":visible"))
            {
                jQuery('.user_full_data').hide();
                jQuery('.assignment_sec').hide();
            } else
            {
                jQuery('.user_full_data').hide();
                jQuery('.assignment_sec').hide();
                jQuery('#' + obj).show();
                setTimeout(function () {
                    jQuery('#' + obj).find('.assignment_sec').slideDown(1500);
                }, 80);

            }
            return false;
        }
        jQuery('.profile_user').on('click', 'a', function () {

        });
        function addFeedback() {
            var type = jQuery('#type').val();
            var id = jQuery('#id').val();
            var userID = jQuery('#userID').val();
            var index = jQuery('#index').val();
            var result = jQuery('#result').val();
            jQuery('.spinner.pop').css({'display': 'inline-block'});
            var dataString = {action: 'add_feedback', type: type, id: id, userID: userID, index: index, result: result};
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    jQuery('.spinner.pop').hide();
                    if (type == "correctFeedback")
                    {
                        jQuery("#corIn-" + id + "-" + index).removeClass('fa-window-close')
                        jQuery("#corIn-" + id + "-" + index).addClass('fa-check-circle')
                    } else {
                        jQuery("#corIn-" + id + "-" + index).addClass('fa-window-close')
                        jQuery("#corIn-" + id + "-" + index).removeClass('fa-check-circle')
                    }
                    jQuery('#close').click();
                }
            });

        }
        function getModal(type, id, userID, index) {
            jQuery('#type').val(type);
            jQuery('#id').val(id);
            jQuery('#userID').val(userID);
            jQuery('#index').val(index);

            jQuery('#bb-' + index + '-' + id).css({'display': 'inline-block'});
            var dataString = {action: 'get_feedback', type: type, id: id, userID: userID, index: index};
            jQuery.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    jQuery('#bb-' + index + '-' + id).hide();
                    jQuery('#result').val(response.result);
                    jQuery('#feedback').modal('show');
                }
            });

        }
        function deleteQuiz(id, userID) {
            if (confirm("Are you sure?"))
            {
                var dataString = {action: 'delete_quiz', id: id, userID: userID};
                jQuery.ajax({
                    url: "/wp-admin/admin-ajax.php",
                    type: 'POST',
                    data: dataString,
                    dataType: 'json',
                    success: function (response) {
                        jQuery('#' + id).hide();
                        alert("Record Deleted")
                        jQuery('#quizStat').html(response.result);
                    }
                });
            }


        }
    </script>
<?php }
?>
