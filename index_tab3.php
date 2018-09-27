<?php
//print_r($_POST)    ;

$posted_data=false; //if true we will fill all cells with ready data

$teacherlist_text= "Α1-ΔΑΣΚΑΛΟΣ,24\nΑ2-ΔΑΣΚΑΛΟΣ,20\nΒ1-ΔΑΣΚΑΛΟΣ,20\nΒ2-ΔΑΣΚΑΛΟΣ,20\nΓ1-ΔΑΣΚΑΛΟΣ,20\nΓ2-ΔΑΣΚΑΛΟΣ,20\nΔ1-ΔΑΣΚΑΛΟΣ,20\nΔ2-ΔΑΣΚΑΛΟΣ,20\nΕ1-ΔΑΣΚΑΛΟΣ,20\nΕ2-ΔΑΣΚΑΛΟΣ,20\nΣΤ1-ΔΑΣΚΑΛΟΣ,20\nΣΤ2-ΔΑΣΚΑΛΟΣ,20\nΠΛΗΡ,11,cyan\nΓΥΜΝ1,11,yellow\nΑΓΓΛ,11,green\nΓΕΡΜ,4,grey\nΓΑΛ,4,purple\n";
$tmimatalist_text="Α1,Α2,Β1,Β2,Γ1,Γ2,Δ1,Δ2,Ε1,Ε2,ΣΤ1,ΣΤ2";
  
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
<button id="test-button">TEsT stuff button</button>
<div id="example-table"></div>
<script>
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
    //console.log(mytabledata);
    var json=mytabledata_json;
    var obj = {};

	for (var i = 0, j = json.length; i < j; i++) {
	  if (obj[json[i].tmimacode0]) {
	    obj[json[i].tmimacode0]++;
	  }
	  else {
	    obj[json[i].tmimacode0] = 1;
	  } 
	}

	console.log(obj);
	return obj;
};

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

var tableData = [
    <?php
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

    ?>

]


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
        if(data.tmimacode0 == "-" || data.col == "ΠΛΗΡ,11" ){
           // alert(data.tmimacode0);
            row.getElement().css({"background-color":"cyan"});
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

    var auto_assined_teacher_table=
    [
    <?php
    // NOTE PHP will show STATIC results (if you change text area it won't be valid -SHOULD convert this to javascript)

    $counter_row_whole_table=1;
    $array_of_teachers_php=explode(PHP_EOL, $teacherlist_text);

    // day 1
    $days_array=["ΔΕΥΤΕΡΑ","ΤΡΙΤΗ","ΤΕΤΑΡΤΗ","ΠΕΜΠΤΗ","ΠΑΡΑΣΚΕΥΗ"];
    foreach($days_array as $this_day) {
        /*
        echo '{id:'.$counter_row_whole_table.',time:"'.$this_day.'"},'; 
        $counter_row_whole_table++;
        */
        for($daily_hour_counter=1;$daily_hour_counter<5;$daily_hour_counter++){
            $timetable_row= '{id:'.$counter_row_whole_table.',day:"'.$this_day.'",time:"'.$daily_hour_counter.'",';    
            $counter_tmima_col=0;
            foreach($tmimata_array as $tmima) {
                $timetable_row.= 'tmimacode'.$counter_tmima_col.':"'.$array_of_teachers_php[$counter_tmima_col].'",';
                $counter_tmima_col++;
            }
           
            $counter_row_whole_table++;
            $timetable_row.='},';
            echo $timetable_row;
        } //end of for($daily_hour_counter=1
         $counter_row_whole_table+=6;
    }

    ?>    ]    

    ;


    //console.log(auto_assined_teacher_table);
    //var jsontext = '{"firstname":"Jesper","surname":"Aaberg","phone":["555-0100","555-0120"]}';
    //var auto_assined_teacher_table = JSON.parse(jsontext);
    //$("#example-table").tabulator("updateOrAddData", [{id:1, name:"bob"}, {id:3, name:"steve"}]);
    $("#example-table").tabulator("updateOrAddData",auto_assined_teacher_table); //tabulator v3
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



//Add row on "Add Row" button click
$("#import_json").click(function(){
    //table.setData($('textarea#programdata').val()); //tabulator v4
    $("#example-table").tabulator("setData",$('textarea#programdata').val()); //tabulator v3
});


//Test button 
$("#test-button").click(function(){
    //table.setData($('textarea#programdata').val()); //tabulator v4
    var mytabledata_json =$("#example-table").tabulator("getData"); //tabulator v3
    //console.log(mytabledata);
    var json=mytabledata_json;
    var obj = {};

	for (var i = 0, j = json.length; i < j; i++) {
	  if (obj[json[i].tmimacode0]) {
	    obj[json[i].tmimacode0]++;
	  }
	  else {
	    obj[json[i].tmimacode0] = 1;
	  } 
	}

	//alert (JSON.parse(obj[0]))
	console.log(obj);

});
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
<?php
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Δ1"]="Δ1";
    print_r($options);
?>
</body>
