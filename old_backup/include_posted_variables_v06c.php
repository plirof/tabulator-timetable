<?php
//print_r($_POST);
if(@($_POST['timetable_restorebackup'] )) {
    //$timetable_restorebackup=$_POST['timetable_restorebackup'];
    $pieces = explode("|||||",$_POST['timetable_restorebackup']);
    //print_r($pieces);
    $teacherlist_text=$pieces[0];
    $tmimatalist_text=$pieces[1];
    $program_data=$pieces[2];
    //echo $program_data;
    $posted_data=true;
    //echo "posted_data=true";
}


if(@($_POST['timetable_teacher'] )) {
    $teacherlist_text=$_POST['timetable_teacher'];
    $posted_data=true;
}

if(@($_POST['timetable_tmimata'] )) {
    $tmimatalist_text=$_POST['timetable_tmimata'];
    $posted_data=true;
}

//$program_data="";  //not impemented yet
if(@($_POST['timetable_program'] )) {
    $program_data=$_POST['timetable_program'];
    $posted_data=true;
}

?>
