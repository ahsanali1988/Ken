<?php
/* * * Child Theme Function  ** */

function esmarts_elated_child_theme_enqueue_scripts() {



    $parent_style = 'esmarts_elated_default_style';



    wp_enqueue_style('esmarts_elated_child_style', get_stylesheet_directory_uri() . '/style.css', array($parent_style));
}

add_action('wp_enqueue_scripts', 'esmarts_elated_child_theme_enqueue_scripts');

function wpse_add_custom_meta_box_2() {
    add_meta_box(
            'expected_duration', // $id
            'Expected Duration', // $title
            'expected_duration', // $callback
            'sfwd-topic', // $page
            'normal', // $context
            'high'                     // $priority
    );
}

add_action('add_meta_boxes', 'wpse_add_custom_meta_box_2');

//showing custom form fields
function expected_duration() {
    global $post;

    $postMeta = get_post_meta($post->ID, 'expected-duration');
    ?>

    <!-- my custom value input -->
    <input type="text" name="duration" value="<?php echo isset($postMeta[0]) && trim($postMeta[0]) != "" ? $postMeta[0] : "" ?>">

    <?php
}

function wpse_save_meta_fields($post_id) {
    if (isset($_POST['duration']) && trim($_POST['duration']) != "") {
        update_post_meta($_POST['post_ID'], 'expected-duration', $_POST['duration']);
    }
}

add_action('save_post', 'wpse_save_meta_fields');
add_action('new_to_publish', 'wpse_save_meta_fields');

$result = add_role('trainer', __(
                'Trainer')
);
$result2 = add_role('mini_admin', __(
                'Mini Admin')
);

function loginHistory($user_login, $user) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $user_login_history = get_user_meta($user->ID, 'user_login_history');
    $count = 0;
    if (isset($user_login_history[0]) && count($user_login_history[0]) > 0) {
        $count = count($user_login_history[0]);
    }

    $temp = isset($user_login_history[0]) && count($user_login_history[0]) > 0 ? $user_login_history[0] : array();
    $currentDate = strtotime(date('Y-m-d'));
    if (!in_array($currentDate, $temp)) {
        $temp[$count] = $currentDate;
        update_user_meta($user->ID, 'user_login_history', $temp);
    }
}

add_action('wp_login', 'loginHistory', 1, 2);

function redirectUser() {
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    if (is_user_logged_in() && $roles[0] != "administrator" && $roles[0] != "mini_admin") {
        $enrolmentAcceptance = get_user_meta($current_user->ID, 'enrolment-acceptance');
        if (isset($enrolmentAcceptance[0]) && count($enrolmentAcceptance[0]) > 0) {
            
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
    }
}

add_action('wp_ajax_nopriv_reportbyCourse', 'reportbyCourse');
add_action('wp_ajax_reportbyCourse', 'reportbyCourse');

function reportbyCourse() {
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    if ($roles[0] == "administrator" || $roles[0] == "mini_admin") {
        $userarr = get_users(
                array(
                    "role" => "subscriber",
                    'meta_query' => array(
                        array(
                            'key' => 'course_' . $_REQUEST["courseID"] . '_access_from',
                            'value' => '',
                            'compare' => '!='
                        ),
                    )
                )
        );

        $nRole = 'student1111';
    } else {
        $userarr = get_users(array(
            "role" => "subscriber",
            'meta_query' => array(
                array(
                    'key' => 'parentID',
                    'value' => $current_user->ID,
                ),
                array(
                    'key' => 'course_' . $_REQUEST["courseID"] . '_access_from',
                    'value' => '',
                    'compare' => '!='
                ),
        )));
        $nRole = $userarr[0]->roles[0];
    }
//    $countend = 0;
    $html = "";
    foreach ($userarr as $user) {
//        if ($countend > 0 && $nRole == 'student') {
//            break;
//        }
//        $countend++;

        $userID = $user->ID;


        $udata = get_userdata($userID);
        $form1 = get_user_meta($userID, 'form1');
        $form2 = get_user_meta($userID, 'form2');
        $form3 = get_user_meta($userID, 'form3');
        $form4 = get_user_meta($userID, 'form4');


        $user_course_access = get_user_meta($userID, 'course_' . $_REQUEST["courseID"] . '_access_from');
        $user_course_access[0] = date("Y-m-d", $user_course_access[0]);
        $user_course_access[0] = strtotime($user_course_access[0]);
        $user_login_history = get_user_meta($userID, 'user_login_history');

        $enrolled = date('Y-m-d', $user_course_access[0]);
        $addMonth = strtotime($enrolled);
        $target = date("Y-m-d", strtotime("+1 month", $addMonth));

// calculate user attendance till current date//
        $today = strtotime(date("Y-m-d"));
        $countDays = 0;
        $loginDate = 0;
        foreach ($user_login_history[0] as $key => $login) {
            if ($login >= $user_course_access[0]) {

                $loginDate = $key;
                $countDays++;
            }
        }
//        if($countDays == 0)
//        {
//         $loginDate = strtotime(date("Y-m-d"));   
//        }
        $datediff = $today - strtotime(date('Y-m-d', $user_course_access[0]));
        $totalDays = round($datediff / (60 * 60 * 24));
//        echo $totalDays."<br>";
//        echo strtotime(date('Y-m-d', $user_course_access[0]))."<br>";
//        echo $countDays;
//        exit;
        $totalDays++;
//        if ($user->ID == 44) {
//
//            echo $countDays . "<br>" . $totalDays . "<br>" . date("Y-m-d", $user_course_access[0]);
//        }
//                                                if ($totalDays == 0) {
//                                                    $totalDays = 1;
//                                                }

        if (isset($user_login_history[0]) && count($user_login_history[0]) > 0) {
            $attendance = intVal($countDays * 100 / $totalDays);
        } else {
            $attendance = 0;
        }
// end //
// calculate user last login hostory//
        $lastLogin = "Not logged in yet";
        if ($countDays > 0) {
            $user_login_history_count = count($user_login_history[0]);

            $lastLoginStr = $countDays == 0 ? $loginDate : $user_login_history[0][$loginDate];


            $lastLoginDisfference = $today - $lastLoginStr;
            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
            if ($lastLoginDays == 0) {
                $lastLogin = "Today";
            } else {
                $lastLogin = $lastLoginDays . " days ago";
            }
        }
// end //

        $courseID = trim($_REQUEST["courseID"]);
        $has_access = sfwd_lms_has_access($courseID, $userID);

// calculate course total time and user completed time//
        $lessons = learndash_get_lesson_list($courseID);
        $topicsIDs = array();
        $totalHours = 0;
        $course_progress = get_user_meta($userID, "_sfwd-course_progress");
        $courseHrs = 0;
        $compHrs = 0;
        foreach ($lessons as $lesson) {
            $topics = learndash_get_topic_list($lesson->ID);
            foreach ($topics as $topic) {
                $topicHrs = get_post_meta($topic->ID, 'expected-duration');
                $topicHrs[0];

                $hrs = explode(":", $topicHrs[0]);
                $topicHrs[0] = ($hrs[0] * 3600) + ($hrs[1] * 60);

                if (isset($course_progress[0][$courseID]['topics'][$lesson->ID][$topic->ID]) && $course_progress[0][$courseID]['topics'][$lesson->ID][$topic->ID] == 1) {
                    $compHrs = $compHrs + $topicHrs[0];
                }
                $courseHrs = $courseHrs + $topicHrs[0];
            }
        }
        $compHrshrs = floor($compHrs / 3600);
        $compHrsimints = floor(($compHrs / 60) % 60);
        $compHrs = $compHrshrs . ":" . $compHrsimints;

        $compHrshrs = floor($courseHrs / 3600);
        $compHrsimints = floor(($courseHrs / 60) % 60);
        $courseHrs = $compHrshrs . ":" . $compHrsimints;
// end //

        $progress = learndash_course_progress(array("user_id" => $userID, "course_id" => $courseID, "array" => true));

        $html .= "<tr>";
        $html .= "<td><a href='javascript:void(0)' onclick='submitForm($user->ID)' style='color: #5270FF'>" . (isset($form1[0]['firstName']) && trim($form1[0]['firstName']) != "" ? $form1[0]['firstName'] : "") . "</a></td>";
        $html .= "<td>" . (isset($form1[0]['email']) && trim($form1[0]['email']) != "" ? $form1[0]['email'] : "") . "</td>";
        $html .= "<td>" . (isset($courseID) && trim($courseID) != "" ? get_the_title($courseID) : "") . "</td>";
        $html .= "<td>" . $enrolled . "</td>";
        $html .= "<td>" . $target . "</td>";
        $html .= "<td>" . ($has_access && $has_access == 1 ? "Active" : "Inactive") . "</td>";
        $html .= "<td>" . $progress['percentage'] . "%</td>";
        $html .= "<td>" . $compHrs . " of " . $courseHrs . "</td>";
        $html .= "<td>" . $attendance . "%</td>";
        $html .= "<td>" . $lastLogin . "</td>";
        $html .= "</tr>";
    }
    echo json_encode(array('result' => $html));
    exit;
}

add_action('wp_ajax_nopriv_userData', 'userData');
add_action('wp_ajax_userData', 'userData');

function userData() {
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    $courseID = trim($_REQUEST['courseID']);
    $key = "course_" . $courseID . "_access_from";
    if ($roles[0] == "administrator" || $roles[0] == "mini_admin") {
        $userarr = get_users(
                array(
                    "role" => "subscriber",
                    'meta_query' => array(
                        array(
                            'key' => $key,
                            'value' => '',
                            'compare' => '!='
                        ),
                    )
                )
        );
    } else {
        $userarr = get_users(array(
            "role" => "subscriber",
            'meta_query' => array(
                array(
                    'key' => 'parentID',
                    'value' => $current_user->ID,
                ),
                array(
                    'key' => $key,
                    'value' => '',
                    'compare' => '!='
                ),
        )));
    }
    $totalStudents = count($userarr);
    $count = 0;
    $completedCourse = 0;
    $expire = 0;
    $pendingAssignments = 0;
    if (count($userarr) > 0) {
        $usersID = array();
        $countuser = 0;
        foreach ($userarr as $user) {
            $usersID[$countuser] = $user->ID;
            $countuser++;
            $user_course_access = get_user_meta($user->ID, 'course_' . $courseID . '_access_from');
            $user_course_access[0] = date("Y-m-d", $user_course_access[0]);
            $user_course_access[0] = strtotime($user_course_access[0]);
            $user_login_history = get_user_meta($user->ID, 'user_login_history');
            if (!isset($user_login_history[0]) && count($user_login_history[0]) == 0) {

                $lastLoginDisfference = strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', $user_course_access[0]));
                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                if ($lastLoginDays >= 14) {
                    $count++;
                }
            } else {
                $loginCount = count($user_login_history[0]);
                $lastlogin = $user_login_history[0][$loginCount - 1];
                $lastLoginDisfference = strtotime(date('Y-m-d')) - $lastlogin;
                $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
                if ($lastLoginDays >= 14) {
                    $count++;
                }
            }
            $completed = get_user_meta($user->ID, 'course_completed_' . $courseID);
            if (isset($completed[0]) && trim($completed[0]) != "") {
                $completedCourse++;
            }
            $lastLoginDisfference = strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', $user_course_access[0]));
            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
            if ($lastLoginDays >= 21) {
                $expire++;
            }
        }
        $update = get_option('attemptQuiz');
        $userEasay = explode(',', $update);
        $userPendId = "";
        foreach ($userEasay as $id) {
            if (in_array($id, $usersID)) {
                $userPendId = $userPendId != "" ? $userPendId . "-" . $id : $id;
                $quizData = get_user_meta($id, "quizDataUser");
                foreach ($quizData[0] as $quiz) {
                    if ($quiz['courseID'] == $courseID) {
                        $pendingAssignments++;
                    }
                }
            }
        }
        $html = '<li> <a class="inner" href="javascript:;" onclick="submitForm(' . "'" . "total" . "'" . ')"> <span class="txt">Students <br>
                                        Enrolled</span> <strong class="counter" id="total">' . $totalStudents . '</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;" onclick="submitForm(' . "'" . "inactive" . "'" . ')"> <span class="txt">Students Inactive over two-weeks</span> <strong class="counter" id="inactive">' . $count . '</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;" onclick="submitForm(' . "'" . "completed" . "'" . ')"> <span class="txt">Students Completed</span> <strong class="counter" id="completed">' . $completedCourse . '</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;" onclick="pending()"> <span class="txt">Assignments Pending</span> <strong class="counter" id="pending">' . $pendingAssignments . '</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;" onclick="submitForm(' . "'" . "expire" . "'" . ')"> <span class="txt">Students near expiry</span> <strong class="counter" id="expire">' . $expire . '</strong> </a> </li>';
        if ($roles[0] == "mini_admin") {
            $html .= ' <li> <a class="inner link_new" href="#"><div class="inner_type"><span>+ New Course </span></div></a> </li>
                       <li> <a class="inner link_new" href="/member-registration-form/"><div class="inner_type"><span>+ New Enrolment</span></div> </a> </li>';
        }
        echo json_encode(array('result' => $html, 'userPendId' => $userPendId));
//        echo json_encode(array('total' => $totalStudents, 'inactive' => $count, 'completed' => $completedCourse, 'expire' => $expire));
        exit;
    } else {
        $html = '<li> <a class="inner" href="javascript:;"> <span class="txt">Students <br>
                                        Enrolled</span> <strong class="counter" id="total">0</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;"> <span class="txt">Students Inactive over two-weeks</span> <strong class="counter" id="inactive">0</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;"> <span class="txt">Students Completed</span> <strong class="counter" id="completed">0</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;"> <span class="txt">Assignments Pending</span> <strong class="counter" id="pending">0</strong> </a> </li>
                            <li> <a class="inner" href="javascript:;"> <span class="txt">Students near expiry</span> <strong class="counter" id="expire">0</strong> </a> </li>';
        if ($roles[0] == "mini_admin") {
            $html .= ' <li> <a class="inner link_new" href="#"><div class="inner_type"><span>+ New Course </span></div></a> </li>
                       <li> <a class="inner link_new" href="/member-registration-form/"><div class="inner_type"><span>+ New Enrolment</span></div> </a> </li>';
        }
        echo json_encode(array('result' => $html));
        exit;
    }
}

// saving user quiz data here//
add_action("learndash_quiz_completed", function($data) {
    $current_user = wp_get_current_user();
    $topic = learndash_get_topic_list($data['lesson']->ID);
    $topicCount = count($topic);
    $quizData = array();
    if ($data['topic']->ID == $topic[$topicCount - 1]->ID) {
        $quizData = get_user_meta($current_user->ID, "quizDataUser");
        $quizData[0][$data['quiz']->ID]['userID'] = $current_user->ID;
        $quizData[0][$data['quiz']->ID]['courseID'] = $data['course']->ID;
        $quizData[0][$data['quiz']->ID]['courseName'] = get_the_title($data['course']->ID);
        $quizData[0][$data['quiz']->ID]['lessonID'] = $data['lesson']->ID;
        $quizData[0][$data['quiz']->ID]['lessonName'] = get_the_title($data['lesson']->ID);
        $quizData[0][$data['quiz']->ID]['topicID'] = $data['topic']->ID;
        $quizData[0][$data['quiz']->ID]['topicName'] = get_the_title($data['topic']->ID);
        $quizData[0][$data['quiz']->ID]['quizID'] = $data['quiz']->ID;
        $quizData[0][$data['quiz']->ID]['approve'] = 0;
        $quizData[0][$data['quiz']->ID]['submitted'] = strtotime(date('Y-m-d'));
        $count = 0;
        foreach ($data['questions'] as $ques) {
            if ($ques->getAnswerType() == "essay") {
                $quizData[0][$data['quiz']->ID]['question'][$count] = $ques->getQuestion();
                $quizData[0][$data['quiz']->ID]['ansPostID'][$count] = $data['graded'][$ques->getId()]['post_id'];
                $content_post = get_post($data['graded'][$ques->getId()]['post_id']);
                $quizData[0][$data['quiz']->ID]['ans'][$count] = $content_post->post_content;
                $quizData[0][$data['quiz']->ID]['status'][$count] = "";
                $quizData[0][$data['quiz']->ID]['correctFeedback'][$count] = "";
                $quizData[0][$data['quiz']->ID]['inCorrectFeedback'][$count] = "";
                $count++;
            }
        }
        update_user_meta($current_user->ID, "quizDataUser", $quizData[0]);
        $update = get_option('attemptQuiz');
        if (isset($update) && trim($update) != "") {
            $userArr = explode(',', $update);
            if (!in_array($current_user->ID, $userArr)) {
                $update = $update . "," . $current_user->ID;
            }
            update_option('attemptQuiz', $update);
        } else {
            update_option('attemptQuiz', $current_user->ID);
        }
    }
}, 5, 1);
add_action('wp_ajax_nopriv_get_feedback', 'get_feedback');
add_action('wp_ajax_get_feedback', 'get_feedback');

function get_feedback() {
    $quizz = get_user_meta($_REQUEST['userID'], "quizDataUser");

    $feedback = $quizz[0][$_REQUEST['index']][$_REQUEST['type']][$_REQUEST['id']];
    echo json_encode(array('result' => $feedback));
    exit;
}

add_action('wp_ajax_nopriv_add_feedback', 'add_feedback');
add_action('wp_ajax_add_feedback', 'add_feedback');

function add_feedback() {
    $quizz = get_user_meta($_REQUEST['userID'], "quizDataUser");
    $quizz[0][$_REQUEST['index']][$_REQUEST['type']][$_REQUEST['id']] = $_REQUEST['result'];
    if ($_REQUEST['type'] == "correctFeedback") {
        $quizz[0][$_REQUEST['index']]['status'][$_REQUEST['id']] = "correct";
    } else {
        $quizz[0][$_REQUEST['index']]['status'][$_REQUEST['id']] = "inCorrect";
    }
    update_user_meta($_REQUEST['userID'], "quizDataUser", $quizz[0]);
    echo json_encode(array('result' => "pass"));
    exit;
}

add_action('wp_ajax_nopriv_delete_quiz', 'delete_quiz');
add_action('wp_ajax_delete_quiz', 'delete_quiz');

function delete_quiz() {
    $userID = $_REQUEST['userID'];
    $udata = get_userdata($userID);
    $quizz = get_user_meta($userID, "quizDataUser");
    unset($quizz[0][$_REQUEST['id']]);
    update_user_meta($userID, "quizDataUser", $quizz[0]);
    $quizz = get_user_meta($userID, "quizDataUser");
    $html = "";
    if (isset($quizz[0]) && count($quizz[0]) > 0) {
        $html .= ' <table><thead>
                        <tr>
                           <th>Course</th>
                            <th>Lesson Name</th>
                            <th>Assessed</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                           </thead>';
        foreach ($quizz[0] as $key => $quiz) {
            $today = strtotime(date("Y-m-d"));
            $lastLoginDisfference = $today - $quiz['submitted'];
            $lastLoginDays = round($lastLoginDisfference / (60 * 60 * 24));
            if ($lastLoginDays == 0) {
                $lastLogin = "Today";
            } else {
                $lastLogin = $lastLoginDays . " days ago";
            }
            $html .='<tr><td class="profile_user"><a href="javascript:void(0)" onclick="expd(' . $key . ')"  style="color: #5270FF">' . $quiz['courseName'] . '</a></td>';
            $html .='<td>' . $quiz['lessonName'] . '</a></td>';
            $html .='<td>' . ($quiz['approve'] == 1 ? "Competent" : "Not Yet Assessed") . '</a></td>';
            $html .='<td>' . $lastLogin . '</a></td>';
            $html .='<td><a href="javascript:void(0)" style="color: #5270FF" onclick="deleteQuiz(' . $key . ',' . $userID . ')">delete</a></td></tr>';
            $html .='<tr class="user_full_data" id="' . $key . '">
                                                <td colspan="5">
                                                    <div class="assignment_sec">
                                                        <div class="assignment_top_bar">
                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    <div class="info">';
            $html .= '<p>' . $quiz['courseName'] . '</p>';
            $html .= '<p>' . $quiz['lessonName'] . '</p>';
            $html .= '</div></div>';
            $html .= '<div class="col-sm-5"><div class="donwload_wrap">';
            $html .= '<p><span>Download:</span> <a href="' . home_url('/pdf/?info=pdf_') . $userID . "_" . $key . '" target="_blank">PDF</a> | <a href="' . home_url('/pdf/?info=csv_') . $userID . "_" . $key . '" target="_blank" >CSV</a></p>';
            $html .= '<p>' . ($quiz['approve'] == 1 ? "Competent" : "Not Yet Assessed") . '</p>';
            $html .= '</div></div></div></div>';
            $html .= ' <div class="assignment_wrap">';
            $count = 0;
            foreach ($quiz['question'] as $value) {
                $html .= '<div class="inner">';
                $html .= ' <h3>' . $value . '</h3>';
                $html .= ' <p>' . $quiz['ans'][$count] . '</p>';
                $html .= '  <a href="javascript:void(0)" data-toggle="modal" onclick="getModal(' . "'" . "correctFeedback" . "'" . ', ' . $count . ', ' . $userID . ',' . $key . ')" class="btn_1">Correct</a> <a href="javascript:void(0)" data-toggle="modal" onclick="getModal(' . "'" . "inCorrectFeedback" . "'" . ', ' . $count . ', ' . $userID . ',' . $key . ')" class="btn_1">Incorrect</a>';
                $class = "";
                if (isset($quiz['status'][$count]) && trim($quiz['status'][$count]) == "correct") {
                    $class = "fa-check-circle";
                } else if (isset($quiz['status'][$count]) && trim($quiz['status'][$count]) == "inCorrect") {
                    $class = "fa-window-close";
                }
                $html .= '<div class="check_uncheck"> <i id="corIn-' . $count . '-' . $key . '" class="fa ' . $class . '" aria-hidden="true"></i> </div> ';
                $html .= ' <div class="spinner" id="bb-' . $key . '-' . $count . '">
                                                                        <div class="bounce1"></div>
                                                                        <div class="bounce2"></div>
                                                                        <div class="bounce3"></div>
                                                                    </div>
                                                                </div>';
                $count++;
            }
            $html .=' <div class="text-center"> <a href="javascript:;" class="btn_1">Request re-submission</a> <a href="javascript:;" class="btn_1">Submit Grading</a> </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>';
        }
        $html .= '</table>';
    } else {
        $html .= 'No Pending Assignment';
    }

    echo json_encode(array('result' => $html));
    exit;
}

add_action('wp_ajax_nopriv_sumbit_email', 'sumbit_email');
add_action('wp_ajax_sumbit_email', 'sumbit_email');

function sumbit_email() {
    $quizz = get_user_meta($_REQUEST['userID'], "quizDataUser");
    $bool = true;
    $correct = true;
    foreach ($quizz[0][$_REQUEST['id']] as $quiz) {
        foreach ($quiz['status'] as $value) {
            if (trim($value) == "") {
                $bool = false;
            }
            if (trim($value) == "inCorrect") {
                $correct = false;
            }
        }
    }
    if ($correct) {
        $quizz[0][$_REQUEST['id']]['approve'] = 1;
        update_user_meta($_REQUEST['userID'], "quizDataUser", $quizz[0]);
    }
    if ($bool) {
        $userData = get_user_by('id', $_REQUEST['userID']);
        $subject = "Assessments";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Key Institute <info@keyinstitute.com>' . " \r\n";
//        $headers .= "Bcc: admin@keyinsitute.com.au\r\n";
        $body = '<body style="margin:0; padding:0; background:#fff;" link="#ffffff">
        <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
            <tr>
                <td>
                    <table width="600" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td valign="top" style="border: 2px solid #eee;padding: 44px 10px;">
                                <table width="800" cellspacing="0" cellpadding="0">

                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" align="center" style="border-bottom: 1px solid #ccc;padding-bottom: 25px;" >
                                                        <a href="' . home_url() . '"><img src="http://members.keyinstitute.com.au/wp-content/uploads/2018/06/logo.png" width="139" height="72" border="0" title="logo" alt="Image" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:30px;">Assignment Result</strong>
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        Your trainer has reviewed your recently submitted assessments. Please see details below:
                                                    </td>`
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="left" valign="top" width="50%" style="padding-right: 10px;">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody>';
  

            $body .= '<tr>
                                                                    <td align="left" colspan="2">
                                                                        <strong style="text-align:left;display:block;padding: 10px;margin: 20px 0;background: #5270ff;color: #fff;">'.$quizz[0][$_REQUEST['id']]['lessonName'].'</strong>
                                                                    </td>
                                                                </tr>';
            $inCount = 0;
            foreach ($quizz[0][$_REQUEST['id']]['question'] as $qs) {


                $body .= '<tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Question
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $quizz[0][$_REQUEST['id']]['question'][$inCount] . '
                                                                    </td> </tr>
                                                                    <tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Answer
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . $quizz[0][$_REQUEST['id']]['ans'][$inCount] . '
                                                                    </td></tr><tr>
                                                                    <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Status
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . ($quizz[0][$_REQUEST['id']]['status'][$inCount] == "correct" ? "Correct" : "Incorrect") . '
                                                                    </td></tr><tr>
                                                                     <th align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        Feedback
                                                                    </th>
                                                                    <td align="left" style="padding:10px;border-bottom:1px solid #ccc;">
                                                                        ' . ($quizz[0][$_REQUEST['id']]['status'][$inCount] == "correct" ? $quizz[0][$_REQUEST['id']]['correctFeedback'][$inCount] : $quizz[0][$_REQUEST['id']]['inCorrectFeedback'][$inCount]) . '
                                                                    </td>
                                                                </tr>';
                $inCount++;
            }
            
        $body .= '</tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                  <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        <strong style="display:block;font-size:30px;">Key Institute Support Team</strong>
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        If you require assistance please feel free to contact our team on 1300 471 660, Monday to Friday from 9am - 5pm (AEST). You can also email us at <a href="support@keyinstitute.com.au">support@keyinstitute.com.au
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 25px;" >
                                                        Best regards,
                                                    </td>`
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding-bottom: 25px;padding-top: 75px;" >
                                                        Please note this is an automated email, please do not reply
                                                    </td>`
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
                </td>
            </tr>
        </table>
    </body>';
        $message = $body;
        mail($userData->user_email, $subject, $message, $headers);
        echo json_encode(array('result' => "pass", 'msg' => "Email sent to user"));
        exit;
    } else {
        echo json_encode(array('result' => "fail", 'msg' => "Please give feedback for all questions"));
        exit;
    }
}
