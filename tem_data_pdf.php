<?php

/* Template Name:PDF */
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$userData = explode("_", $_REQUEST['info']);
 require_once('TCPDF-master/tcpdf.php');

// create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('keyinstitute');
//    $pdf->SetTitle('Quiz Stats');
//    $pdf->SetSubject('TCPDF Tutorial');
//    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
//    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);
// set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------
// set font
    $pdf->SetFont('dejavusans', '', 10);

// add a page
    $pdf->AddPage();
if (isset($userData[0]) && trim($userData[0]) == "pdf") {


// create some HTML content

    $quizz = get_user_meta($userData[1], "quizDataUser");
//    require('html_table_pdf.php');


    if (isset($quizz[0]) && count($quizz[0]) > 0) {
        $html = '
            <style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
}
</style>
            <p align="center">Quiz Statistics</p>';
        $html .= '<table border="1" width="100%" height="50%" cellpadding="10">
                                            <tr>
                                                <td>Question</td>
                                                <td>Answer</td>
                                            </tr>';
        foreach ($quizz[0] as $key => $quiz) {
            $count = 0;
            foreach ($quiz['question'] as $qu) {

                $html .= '<tr>
                                                    <td>' . $qu . '</td>
                                                    <td>' . $quiz['ans'][$count] . '</td>
                                                </tr>';
                $count++;
            }
        }
        $html .= '</table>';
    }



// output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

// Print some HTML Cells
// ---------------------------------------------------------
//Close and output PDF document
    $pdf->Output('Quiz Statistics.pdf', 'I');
} else if (isset($userData[0]) && trim($userData[0]) == "csv") {
    $userData = explode("_", $_REQUEST['info']);
    $quizz = get_user_meta($userData[1], "quizDataUser");
    $temp = array();
    $countOuter = 0;
    foreach ($quizz[0] as $key => $value) {

        $temp[$countOuter][0] = "Question";
        $temp[$countOuter][1] = "Answer";

        $countOuter++;
        $countInner = 0;
        foreach ($value['question'] as $val) {
            $temp[$countOuter][0] = $val;
            $temp[$countOuter][1] = $value['ans'][$countInner];
            $countInner++;
            $countOuter++;
        }
    }
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=file.csv");

    function outputCSV($data) {
        $output = fopen("php://output", "w");
        foreach ($data as $row)
            fputcsv($output, $row); // here you can change delimiter/enclosure
        fclose($output);
    }

    outputCSV($temp);
} else if (isset($userData[0]) && trim($userData[0]) == "enr") {
    $udata = get_userdata($userData[1]);
    $form1 = get_user_meta($userData[1], 'form1');
    $form2 = get_user_meta($userData[1], 'form2');
    $form3 = get_user_meta($userData[1], 'form3');
    $form4 = get_user_meta($userData[1], 'form4');
    $html = '<p align="center">Download enrollment</p>';
    $html .= '<table border="1" width="100%" height="50%" cellpadding="10" >
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px; background: #fff;"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody border="1" width="100%" height="50%" cellpadding="10">
                                                <tr border="1">
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong>What is the address of your usual residence?</strong></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Building/Property name </th>
                                                    <td threegn="left" >' . $form2[0]['property_name'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Flat/Unit details </th>
                                                    <td threegn="left" >' . $form2[0]['unit_details'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street or lot number </th>
                                                    <td threegn="left" >' . $form2[0]['street_lot'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street name </th>
                                                    <td threegn="left" >' . $form2[0]['street_name'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Suburb, locthreety or town </th>
                                                    <td threegn="left" >' . $form2[0]['suburb_locthreety'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > State/territory </th>
                                                    <td threegn="left" >' . $form2[0]['state_territory'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Postcode </th>
                                                    <td threegn="left" >' . $form2[0]['postcode'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong>What is your postal address (if different from above)?</strong></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Building/Property name </th>
                                                    <td threegn="left" >' . $form2[0]['property_name1'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Flat/Unit details </th>
                                                    <td threegn="left" >' . $form2[0]['unit_details1'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street or lot number </th>
                                                    <td threegn="left" >' . $form2[0]['street_lot1'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Street name </th>
                                                    <td threegn="left" >' . $form2[0]['street_name1'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Postal delivery information </th>
                                                    <td threegn="left" >' . $form2[0]['po_box'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Suburb, locthreety or town </th>
                                                    <td threegn="left" >' . $form2[0]['suburb_locthreety1'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > State/territory </th>
                                                    <td threegn="left" >' . $form2[0]['state_territory1'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" > Postcode </th>
                                                    <td threegn="left" >' . $form2[0]['postcode1'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong >Language and Cultural Diversity</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">In which country were you born?</strong></td><td>'.$form2[0]['count_born'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Do you speak a language other than English at home?</strong></td><td>'.$form2[0]['more_english'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Are you of Aboriginal or Torres Strait Islander origin?</strong></td><td>'.$form2[0]['torres_island'].'</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong >Disability</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Do you consider yourself to have a disability, impairment or long-term condition?</strong></td><td>'.$form2[0]['diability'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;"> If you indicated the presence of a disability, impairment or long-term condition, please select the area(s) in the following list: </strong></td><td>'.$form2[0]['disability_list'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">If you answered YES to the above question do you require any assistance to participate in this course?</strong></td><td>'.$form2[0]['participate'].'</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong >Schooling</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">What is your highest COMPLETED school level?</strong></td><td>'.$form3[0]['school_level'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Are you still enrolled in secondary or senior secondary education?</strong></td><td>'.$form3[0]['secondary_level'].'</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong >Previous Quthreefications Achieved</strong></td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Have you SUCCESSFULLY completed any of the following quthreefications listed below?</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['quthreefication'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Bachelor Degree or Higher Degree</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['higher_degree'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Advanced Diploma or Associate Degree</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['advanced_degree'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Diploma (or Associate Diploma)</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['diploma'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate IV (or Advanced Certificate/Technician)</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['certificate_iv'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate III (or Trade Certificate)</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['certificate_iii'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate II</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['certificate_ii'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificate I</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['certificate_i'] . '</td>
                                                </tr>
                                                <tr>
                                                    <th threegn="left" >Certificates other than the above</th>
                                                    <td vthreegn="top" threegn="left" >' . $form3[0]['certificate_above'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td threegn="left" colspan="2" style="padding:0px;"><strong >Employer Details</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Enter your current employment information (where applicable)</strong></td><td>'.$form3[0]['organization_name'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Your position</strong></td><td>'.$form3[0]['your_position'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Supervisor name</strong></td><td>'.$form3[0]['supervisor_name'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Employers street address</strong></td><td>'.$form3[0]['street_address'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Suburb, locthreety or town</strong></td><td>'.$form3[0]['suburb_locthreety'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">State/territorys</strong></td><td>'.$form3[0]['state_territory'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Postcode</strong></td><td>'.$form3[0]['postcode'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Telephone</strong></td><td>'.$form3[0]['telephone'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Fax</strong> </td><td>'.$form3[0]['fax'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Email</strong></td><td>'.$form3[0]['Email'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Website</strong> </td><td>'.$form3[0]['website'].'</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                      <!--                                    <td threegn="left" vthreegn="top"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                                                  <tbody>
                                                                      <tr>
                                                                          <td vthreegn="top" threegn="left" colspan="2">Employment</strong></td>
                                                                      </tr>
                                                                      <tr>
                                                                          <td vthreegn="top" threegn="left" > xxxx </td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table></td>--> 
                                </tr>
                                <tr>
                                    <td threegn="left" vthreegn="top" width="50%" style="padding-right: 10px;"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong >Study Reason</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Study Reason - Of the following categories, which BEST describes your main reason for undertaking this course / traineeship /apprenticeship? </strong></td><td>'.$form2[0]['study_reason'].'</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                    <td threegn="left" vthreegn="top"><table border="1" width="100%" height="50%" cellpadding="10" cellspacing="10">
                                            <tbody>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" colspan="2" style="padding:0px;"><strong >Unique Student Identifier</strong></td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">I already have a USI (copy number below) </strong></td><td>'.$form4[0]['usi_number'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Please supply two forms of identification from the list below </strong></td><td>'.$form4[0]['usi_identification'].'</td>
                                                </tr>
                                                <tr>
                                                    <td vthreegn="top" threegn="left" ><strong style="display:block;">Nominate your preferred method of contact by the USI Office - for notification of your USI Number & for access to your account: </strong></td><td>'.$form4[0]['nominate_usi'].'</td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                            </table>';
    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

// Print some HTML Cells
// ---------------------------------------------------------
//Close and output PDF document
    $pdf->Output('Download enrollment.pdf', 'I');
}
?>