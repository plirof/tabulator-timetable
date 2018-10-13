<?php
//print_r($_POST)    ;

$posted_data=false; //if true we will fill all cells with ready data

$teacherlist_text= "Α1-ΔΑΣΚΑΛΟΣ,24\nΑ2-ΔΑΣΚΑΛΟΣ,20\nΒ1-ΔΑΣΚΑΛΟΣ,20\nΒ2-ΔΑΣΚΑΛΟΣ,20\nΓ1-ΔΑΣΚΑΛΟΣ,20\nΓ2-ΔΑΣΚΑΛΟΣ,20\nΔ1-ΔΑΣΚΑΛΟΣ,20\nΔ2-ΔΑΣΚΑΛΟΣ,20\nΕ1-ΔΑΣΚΑΛΟΣ,20\nΕ2-ΔΑΣΚΑΛΟΣ,20\nΣΤ1-ΔΑΣΚΑΛΟΣ,20\nΣΤ2-ΔΑΣΚΑΛΟΣ,20\nΠΛΗΡ,11,cyan\nΓΥΜΝ1,11,yellow\nΑΓΓΛ,11,green\nΓΕΡΜ,4,grey\nΓΑΛ,4,purple\n";
$tmimatalist_text="Α1,Α2,Β1,Β2,Γ1,Γ2,Δ1,Δ2,Ε1,Ε2,ΣΤ1,ΣΤ2";

include "include_posted_variables.php";

/*  
if(@($_POST['timetable_teacher'] )) {
    $teacherlist_text=$_POST['timetable_teacher'];
    $posted_data=true;
}

if(@($_POST['timetable_tmimata'] )) {
    $tmimatalist_text=$_POST['timetable_tmimata'];
    $posted_data=true;
}

$program_data="";  //not impemented yet
if(@($_POST['timetable_program'] )) {
    $program_data=$_POST['timetable_program'];
    $posted_data=true;
}
*/    
$tmimata_array = explode(',',$tmimatalist_text);



?>
<html>
<head>
<script type="text/javascript" src="js/jquery1.12.4.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
<script src="js/jquery.ui.touch-punch.min.js"></script>
<!--<script type="text/javascript" src="http://oss.sheetjs.com/js-xlsx/xlsx.full.min.js"></script> -->
<script type="text/javascript" src="js/js-xlsx/xlsx.full.min.js"></script>
<link href="css/tabulator353/tabulator.min.css" rel="stylesheet">
<!--<link href="css/tabulator.min.css" rel="stylesheet"> -->
<script type="text/javascript" src="js/tabulator353/tabulator.min.js"></script>
<!--<script type="text/javascript" src="js/tabulator.min.js"></script>-->

        
<!--<script src="js/selectize-standalone/selectize.min.js"></script> -->


</head>
<body>
<form method="post" >    
<table><tr><td>
    ΕΚΠΑΙΔΕΥΤΙΚΟΙ (Ένας σε κάθε σειρά):<BR> <textarea id="teacherslist" name='timetable_teacher' cols=50 rows=10 ><?php echo $teacherlist_text; ?></textarea>
    </td><td>
    TMHMATA (χωρισμένα με κόμμα):<BR><textarea id="tmimatalist" name='timetable_tmimata' cols=50 rows=10 ><?php echo $tmimatalist_text; ?></textarea>
    </td></tr>
</table>

<input type=submit value="ΚΑΤΑΧΩΡΗΣΗ ΤΜΗΜΑΤΑ & ΕΚΠΑΙΔΕΥΤΙΚΩΝ"> 
</form>

<button id="download-json">download-json</button>
<button id="download-xlsx">download-xlsx</button>
<button id="import_json">import_json</button>
<button id="auto_assign_first_teachers">auto_assign_main_teachers</button>
<button id="btn-save-all-data">EXPORT ALL data</button>
<button id="count-teacher-hours">count-teacher-hours</button>
<button id="test-button">TEsT stuff button</button>
<div id="example-table"></div>
<script>
var posted_data=false;
<?php     if( $posted_data==true) echo "posted_data=true;"; ?>

//$("#example-table").tabulator();
var arrayOfTeachers = $('#teacherslist').val().split('\n');
//var table = new Tabulator("#example-table", {});

//Note Formatter is only visual , MUTATOR is stored
var colorFormatter = function(cell, formatterParams){
    var value = cell.getValue();
    if(value  == "-"){
       cell.getElement().css("background-color","lightgrey");
       return value;
    }else{
        return value;
    }
};

var countTeachersHours_json = function(){

    //table.setData($('textarea#programdata').val()); //tabulator v4
    var mytabledata_json =$("#example-table").tabulator("getData"); //tabulator v3
    var json=mytabledata_json;
    var obj = {};

	//FIXED counter for up to 16 tmimata
	for (var i = 0, j = json.length; i < j; i++) {
	  if (obj[json[i].tmimacode0]) {obj[json[i].tmimacode0]++;}else {obj[json[i].tmimacode0] = 1;}

	  if (obj[json[i].tmimacode1]) {obj[json[i].tmimacode1]++;}else {obj[json[i].tmimacode1] = 1;}
	  if (obj[json[i].tmimacode2]) {obj[json[i].tmimacode2]++;}else {obj[json[i].tmimacode2] = 1;}
	  if (obj[json[i].tmimacode3]) {obj[json[i].tmimacode3]++;}else {obj[json[i].tmimacode3] = 1;}
	  if (obj[json[i].tmimacode4]) {obj[json[i].tmimacode4]++;}else {obj[json[i].tmimacode4] = 1;}
	  if (obj[json[i].tmimacode5]) {obj[json[i].tmimacode5]++;}else {obj[json[i].tmimacode5] = 1;}
	  if (obj[json[i].tmimacode6]) {obj[json[i].tmimacode6]++;}else {obj[json[i].tmimacode6] = 1;}
	  if (obj[json[i].tmimacode7]) {obj[json[i].tmimacode7]++;}else {obj[json[i].tmimacode7] = 1;}
	  if (obj[json[i].tmimacode8]) {obj[json[i].tmimacode8]++;}else {obj[json[i].tmimacode8] = 1;}
	  if (obj[json[i].tmimacode9]) {obj[json[i].tmimacode9]++;}else {obj[json[i].tmimacode9] = 1;}

	  if (obj[json[i].tmimacode10]) {obj[json[i].tmimacode10]++;}else {obj[json[i].tmimacode10] = 1;}
	  if (obj[json[i].tmimacode11]) {obj[json[i].tmimacode11]++;}else {obj[json[i].tmimacode11] = 1;}
	  if (obj[json[i].tmimacode12]) {obj[json[i].tmimacode12]++;}else {obj[json[i].tmimacode12] = 1;}
	  if (obj[json[i].tmimacode13]) {obj[json[i].tmimacode13]++;}else {obj[json[i].tmimacode13] = 1;}
	  if (obj[json[i].tmimacode14]) {obj[json[i].tmimacode13]++;}else {obj[json[i].tmimacode14] = 1;}
	  if (obj[json[i].tmimacode15]) {obj[json[i].tmimacode13]++;}else {obj[json[i].tmimacode15] = 1;}	  	  	  
	}

	console.log(obj);
    //console.log(Object.values(obj));
    //console.log(Object.keys(obj));

	return obj;
};

function auto_assined_teacher_table(){
    var counter_row_whole_table=1;
    var counter_tmima_col=0;
    //$array_of_teachers_php=explode(PHP_EOL, $teacherlist_text);

    //var get_teachers_textarea = $('#teacherslist').val();
    var arrayOfTeachers = $('#teacherslist').val().split('\n');
    //var get_tmimata_textarea = $('#tmimatalist').val();
    var tmimata_array = $('#tmimatalist').val().split(',');
    var tmimata_arrayLength = tmimata_array.length;
    //console.log("tmimata length="+tmimata_arrayLength)
    // day 1
    var days_array=["ΔΕΥΤΕΡΑ","ΤΡΙΤΗ","ΤΕΤΑΡΤΗ","ΠΕΜΠΤΗ","ΠΑΡΑΣΚΕΥΗ"];
    var timetable_json="[";
    var timetable_row="";

    for( var i=1;i<=5;i++) { //Loop through 5 days of week
        /*
        echo '{id:'.$counter_row_whole_table.',time:"'.$this_day.'"},'; 
        $counter_row_whole_table++;
        */
        //put teachers to first 4 hours
        for(var daily_hour_counter=1;daily_hour_counter<5;daily_hour_counter++){
            timetable_row= '{"id":'+counter_row_whole_table+',"day":"'+days_array[i-1]+'","time":"'+daily_hour_counter+'",';    
            counter_tmima_col=0;
            //foreach(tmimata_array as $tmima) {
            for( var j=0;j<tmimata_arrayLength;j++) {	
                timetable_row+= '"tmimacode'+counter_tmima_col+'":"'+arrayOfTeachers[counter_tmima_col]+'"';
                if(j<(tmimata_arrayLength-1))timetable_row+=',';
                counter_tmima_col++;
            }
           
            counter_row_whole_table++;
            timetable_row+='}';
            if(!(daily_hour_counter==4 && i==5))timetable_row+=',';
            timetable_json+=timetable_row;
        } //end of for($daily_hour_counter=1
         //timetable_row+=',';
         counter_row_whole_table+=6;
    }
    timetable_json+=']';
    //console.log(timetable_json)	;
    return timetable_json;
}

var cellEditSelectTeacherFunction=function(cell){

    //create a options list of all names currently in the table
    var arrayOfTeachers = $('#teacherslist').val().split('\n');

    var arrayOfTeachers2 = {};

    arrayOfTeachers.forEach(function(row){
        var data = row;
        //alert(data);
        arrayOfTeachers2[data] = data;
    });
    return arrayOfTeachers2;
    

    //var rows = $("example-table").tabulator("getRows");
    /*
    var options = {};
    options["ΠΛΗΡ"]="ΠΛΗΡΟΦΟΡΙΚΗ";
    options["Α"]="Α";
    options["Β1"]="Β1";
    options["Γ1"]="Γ1";
    options["Δ1"]="Δ1";
    options["ΜΟΥΣ"]="ΜΟΥΣΙΚΗ";
    return options;
    */
}; // end of var cellEditSelectTeacherFunction

/* alert ("<?php echo $program_data;?>"); */
var tableData = 
	
    <?php

    if($posted_data) {
    	echo $program_data;
    }else
    {
    echo"[";
    $counter_row_whole_table=1;
    // day 1
    $days_array=["ΔΕΥΤΕΡΑ","ΤΡΙΤΗ","ΤΕΤΑΡΤΗ","ΠΕΜΠΤΗ","ΠΑΡΑΣΚΕΥΗ"];
    foreach($days_array as $this_day) {
        /*
        echo '{id:'.$counter_row_whole_table.',time:"'.$this_day.'"},'; 
        $counter_row_whole_table++;
        */
        for($daily_hour_counter=1;$daily_hour_counter<11;$daily_hour_counter++){
            $timetable_row= '{id:'.$counter_row_whole_table.',day:"'.$this_day.'",time:"'.$daily_hour_counter.'",';    
            $counter_tmima_col=0;
            foreach($tmimata_array as $tmima) {
                $timetable_row.= 'tmimacode'.$counter_tmima_col.':"-",';
                $counter_tmima_col++;
            }
           
            $counter_row_whole_table++;
            $timetable_row.='},';
            echo $timetable_row;
        } //end of for($daily_hour_counter=1
    }
    echo"]";
	}
    ?>




//var table = new Tabulator("#example-table", { // tabulator v4
$("#example-table").tabulator( {     //tabulator v3
	data:tableData, //set initial table data
    //eight:"311px",
    //layout:"fitDataFill",
    groupBy:"day",
    layout:"fitColumns",
    //movableRows:true,
        columns:[
        {title:"ΗΜΕΡΑ", field:"day",headerSort:false,visible:false ,hideInHtml:false, editor:false},
        {title:"ΩΡΑ", field:"time",headerSort:false, editor:false},
    <?php                
        $counter_tmima_col=0;
        foreach($tmimata_array as $tmima) {
            echo '{title:"'.$tmima.'", field:"tmimacode'.$counter_tmima_col.'",headerSort:false, editor:"select",formatter:colorFormatter, editorParams:cellEditSelectTeacherFunction
            },';
            $counter_tmima_col++;
        }
        
    ?> 
           
    ],

    rowFormatter:function(row){
        //row - row component
        var data = row.getData();
        //console.log(data.tmimacode0);
        if(data.col == "ΠΛΗΡ,11" ){
           // alert(data.tmimacode0);
            //row.getElement().css({"background-color":"cyan"});
        }
    },

    // INTERCEPT download maybe used to make a bigger JSON to contain more teachers& classes
    downloadReady:function(fileContents, blob){
        //fileContents - the unencoded contents of the file
        //blob - the blob object for the download
        //alert(blob);
        //custom action to send blob to server could be included here
        return blob; //must return a blob to proceed with the download, return false to abort download
    },

    validationFailed:function(cell, value, validators){
        //cell - cell component for the edited cell
        //value - the value that failed validation
        //validatiors - an array of validator objects that failed

        //take action on validation fail
    },
    rowMoved:function(row){
        alert("Row: " + row.getData().name + " has been moved");
    },
    rowClick:function(e, row){
       // alert("Row " + row.getIndex() + " Clicked!!!!")
    },
    rowContext:function(e, row){
        alert("Row " + row.getIndex() + " Context Clicked!!!!")
    },    
}); // END Of tabulator Init

/* if(posted_data && (typeof program_data !== 'undefined') ) $("#example-table").tabulator("setData","<?php print_r($program_data); echo $program_data; ?>"); //tabulator v3  */

//trigger download of data.json file
$("#download-json").click(function(){
    /*
    // +++++++++tab v4++++++++++++    
    table.showColumn("day"); //show the "name" column
    table.download("json", "data.json");
    table.hideColumn("day"); //show the "name" column
    */
    // +++++++++tab v3++++++++++++
    $("#example-table").tabulator("showColumn","day");
    $("#example-table").tabulator("download", "json", "backup_school_program.json");
    $("#example-table").tabulator("hideColumn","day");
});

//$("#example-table").tabulator("download", "xlsx", "data.xlsx", {sheetName:"MyData"}); //download a Xlsx file that has a sheet name of "MyData"


//trigger download of data.xlsx file
$("#download-xlsx").click(function(){
    /*
    // +++++++++tab v4++++++++++++
    table.showColumn("day"); //show the "name" column
    table.download("xlsx", "school_program.xlsx", {sheetName:"My Data"});
    table.hideColumn("day"); //show the "name" column
    */
    // +++++++++tab v3++++++++++++
    $("#example-table").tabulator("showColumn","day");
    $("#example-table").tabulator("download", "xlsx", "school_program.xlsx", {sheetName:"MyData"}); //download a Xlsx file that has a sheet name of "MyData"
    $("#example-table").tabulator("hideColumn","day");
});

//trigger download of data.xlsx file
$("#auto_assign_first_teachers").click(function(){

    //var arrayOfTeachers = $('#teacherslist').val().split('\n');


    //console.log(auto_assined_teacher_table());
    //var jsontext = '{"firstname":"Jesper","surname":"Aaberg","phone":["555-0100","555-0120"]}';
    //var auto_assined_teacher_table = JSON.parse(jsontext);
    //$("#example-table").tabulator("updateOrAddData", [{id:1, name:"bob"}, {id:3, name:"steve"}]);
    $("#example-table").tabulator("updateOrAddData",auto_assined_teacher_table()); //tabulator v3
});

var json_imported_data = [ 
    {
        "id": "1",
        "day": "ΔΕΥΤΕΡΑ",
        "time": "1",
        "tmimacode0": "-",
        "tmimacode1": "-",
        "tmimacode2": "-",
        "tmimacode3": "-",
        "tmimacode4": "-",
        "tmimacode5": "-",
        "tmimacode6": "-",
        "tmimacode7": "-",
        "tmimacode8": "-",
        "tmimacode9": "-"
    },
    {
        "id": "2",
        "day": "ΔΕΥΤΕΡΑ",
        "time": "2",
        "tmimacode0": "-",
        "tmimacode1": "-",
        "tmimacode2": "-",
        "tmimacode3": "-",
        "tmimacode4": "-",
        "tmimacode5": "-",
        "tmimacode6": "-",
        "tmimacode7": "-",
        "tmimacode8": "-",
        "tmimacode9": "-"
    } ]        ;



//Add row on "import json" button click
$("#import_json").click(function(){
    //table.setData($('textarea#programdata').val()); //tabulator v4
    $("#example-table").tabulator("setData",$('textarea#programdata').val()); //tabulator v3
});

// ##################   download TOTAL backup file +++++++++++++++

var textFile = null,
  makeTextFile = function (text) {
    var data = new Blob([text], {type: 'text/plain'});

    // If we are replacing a previously generated file we need to
    // manually revoke the object URL to avoid memory leaks.
    if (textFile !== null) {
      window.URL.revokeObjectURL(textFile);
    }

    textFile = window.URL.createObjectURL(data);

    return textFile;
  };

$("#btn-save-all-data").click(function () {

    var get_mytabledata =$("#example-table").tabulator("getData"); //tabulator v3 -OBJECT must make it TEXT
	var myJSON_mytabledata = JSON.stringify(get_mytabledata);

    var get_teachers_textarea = $('#teacherslist').val();
    var get_tmimata_textarea = $('#tmimatalist').val();

  	//var create = document.getElementById('create'),
    //textbox = document.getElementById('textbox');

    var d = new Date();
    var link = document.createElement('a');
    link.setAttribute('download', 'school_full_backup'+d.getTime()+'.txt');
    //link.href = makeTextFile(textbox.value);
    link.href = makeTextFile(get_teachers_textarea+'|||||'+get_tmimata_textarea+'|||||'+myJSON_mytabledata);
    document.body.appendChild(link);

    // wait for the link to be added to the document
    window.requestAnimationFrame(function () {
      var event = new MouseEvent('click');
      link.dispatchEvent(event);
      document.body.removeChild(link);
		});
    
});



// ##################   download file -----------------


//
$("#count-teacher-hours").click(function(){


	return countTeacherHours();


});

//Test button 
$("#test-button").click(function(){
    var get_mytabledata =$("#example-table").tabulator("getData");
    console.log(get_mytabledata);
	//var mytabledata_json =$("#example-table").tabulator("getData"); //tabulator v3
	var result_obj=countTeacherHours();
	for (var key in result_obj) {
  		console.log("key " + key + " has value " + result_obj[key]);
	}

	console.log(result_obj);
    return result_obj;

});



var countTeacherHours = function(){
    //table.setData($('textarea#programdata').val()); //tabulator v4
    var mytabledata_json =$("#example-table").tabulator("getData"); //tabulator v3
    //console.log(mytabledata);
    var json=mytabledata_json;
    var obj = {};
    //var tmimata_array = $('#tmimatalist').val().split(',')
    //var counter_tmima_col=0;
    //var arrayLength = tmimata_array.length;
	//console.log(tmimata_array);
	//FIXED counter for up to 16 tmimata
	for (var i = 0, j = json.length; i < j; i++) {
	  if (obj[json[i].tmimacode0]) {obj[json[i].tmimacode0]++;}else {obj[json[i].tmimacode0] = 1;}

	  if (obj[json[i].tmimacode1]) {obj[json[i].tmimacode1]++;}else {obj[json[i].tmimacode1] = 1;}
	  if (obj[json[i].tmimacode2]) {obj[json[i].tmimacode2]++;}else {obj[json[i].tmimacode2] = 1;}
	  if (obj[json[i].tmimacode3]) {obj[json[i].tmimacode3]++;}else {obj[json[i].tmimacode3] = 1;}
	  if (obj[json[i].tmimacode4]) {obj[json[i].tmimacode4]++;}else {obj[json[i].tmimacode4] = 1;}
	  if (obj[json[i].tmimacode5]) {obj[json[i].tmimacode5]++;}else {obj[json[i].tmimacode5] = 1;}
	  if (obj[json[i].tmimacode6]) {obj[json[i].tmimacode6]++;}else {obj[json[i].tmimacode6] = 1;}
	  if (obj[json[i].tmimacode7]) {obj[json[i].tmimacode7]++;}else {obj[json[i].tmimacode7] = 1;}
	  if (obj[json[i].tmimacode8]) {obj[json[i].tmimacode8]++;}else {obj[json[i].tmimacode8] = 1;}
	  if (obj[json[i].tmimacode9]) {obj[json[i].tmimacode9]++;}else {obj[json[i].tmimacode9] = 1;}

	  if (obj[json[i].tmimacode10]) {obj[json[i].tmimacode10]++;}else {obj[json[i].tmimacode10] = 1;}
	  if (obj[json[i].tmimacode11]) {obj[json[i].tmimacode11]++;}else {obj[json[i].tmimacode11] = 1;}
	  if (obj[json[i].tmimacode12]) {obj[json[i].tmimacode12]++;}else {obj[json[i].tmimacode12] = 1;}
	  if (obj[json[i].tmimacode13]) {obj[json[i].tmimacode13]++;}else {obj[json[i].tmimacode13] = 1;}
	  if (obj[json[i].tmimacode14]) {obj[json[i].tmimacode14]++;}else {obj[json[i].tmimacode14] = 1;}
	  if (obj[json[i].tmimacode15]) {obj[json[i].tmimacode15]++;}else {obj[json[i].tmimacode15] = 1;}
	  if (obj[json[i].tmimacode16]) {obj[json[i].tmimacode16]++;}else {obj[json[i].tmimacode16] = 1;}
	  if (obj[json[i].tmimacode17]) {obj[json[i].tmimacode17]++;}else {obj[json[i].tmimacode17] = 1;}	  	  	  

         /* // this eval() crashes PC ...
			arrayLength=1;
			var i=2;
            //for(var i=0;i<arrayLength;i++) {
              if (eval(`obj[json[i].tmimacode${i}]`)) {
                (eval(`obj[json[i].tmimacode${i}]`))++;
              }
              else {
                (eval(`obj[json[i].tmimacode${i}] `))= 1;
              }     
              //counter_tmima_col++
            //}
		*/

	}

	console.log(obj);
    //console.log(Object.values(obj));
    //console.log(Object.keys(obj));	
	return (obj);
};


/*


//Delete row on "Delete Row" button click
$("#del-row").click(function(){
    table.deleteRow(1);
});

//Clear table on "Empty the table" button click
$("#clear").click(function(){
    table.clearData()
});

//Reset table contents on "Reset the table" button click
$("#reset").click(function(){
    table.setData(tabledata);
});
*/


</script>
ΕΙΣΑΓΩΓΗ ΔΕΔΟΜΕΝΩΝ ΠΡΟΓΡΑΜΜΑΤΟΣ που έχουν γίνει με το κουμπι εξαγωγή σε JSON (αντιγραψτε τα εδώ):<BR> <textarea id="programdata" name='timetable_program' cols=50 rows=10 ></textarea>
<!-- <button id="import_json">import_json</button> BUTTON DOES NOT WORK HERE-->

<BR>
<h2>ΕΠΑΝΑΦΟΡΑ ΑΝΤΙΓΡΑΦΟΥ ΑΣΦΑΛΕΊΑΣ(κάντεεπικόλληση του πλήρους περιεχομένου του αρχείου backup παρακάτω και πατείστε "ΕΠΑΝΑΦΟΡΑ")</h2>

<form method="post" > 
<textarea id="restorebackup" name='timetable_restorebackup' cols=50 rows=10 ></textarea>
<input type=submit value="ΕΠΑΝΑΦΟΡΑ αντίγραφου ασφαλείας"> 
</form>

<?php
	//my tests
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Δ1"]="Δ1";
    //print_r($options);
?>
</body>
