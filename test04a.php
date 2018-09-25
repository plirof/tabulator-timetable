<?php
    $teacherlist_text= "Α1-ΔΑΣΚΑΛΟΣ,24\nΑ2-ΔΑΣΚΑΛΟΣ,11\nΠΛΗΡ,11\nΓΥΜΝ1,11\n";
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Α"]="Α";
    $options["Β1"]="Β1";
    $options["Γ1"]="Γ1";
    $options["Δ1"]="Δ1";

    $tmimatalist_text="Α1,Α2,Β1,Β2,Γ1,Γ2,Δ1,Δ2,Ε1,Ε2,ΣΤ1,ΣΤ2";
    $tmimata_array = explode(',',$tmimatalist_text);

$posted_data=false; //if true we will fill all cells with ready data

?>
<html>
<head>
<script type="text/javascript" src="js/jquery1.12.4.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
<!--<script type="text/javascript" src="http://oss.sheetjs.com/js-xlsx/xlsx.full.min.js"></script> -->
<script type="text/javascript" src="js/js-xlsx/xlsx.full.min.js"></script>
<!-- <link href="css/tabulator3.3.2.min.css" rel="stylesheet"> -->
<link href="css/tabulator.min.css" rel="stylesheet">
<!-- <script type="text/javascript" src="js/tabulator3.3.2.min.js"></script> --> 
<script type="text/javascript" src="js/tabulator.min.js"></script>

        
<script src="js/selectize-standalone/selectize.min.js"></script>


</head>
<body>
<table>
<tr><td>
ΚΑΘΗΓΗΤΕΣ (Ένας σε κάθε σειρά):<BR> <textarea id="teacherslist" cols=50 rows=10 ><?php echo $teacherlist_text; ?></textarea>
</td><td>
TMHMATA (χωρισμένα με κόμμα):<BR><textarea id="tmimatalist" cols=50 rows=10 ><?php echo $tmimatalist_text; ?></textarea>
</td></tr>
</table>


<button id="download-json">download-json</button>
<button id="download-xlsx">download-xlsx</button>
<div id="example-table"></div>
<script>
//$("#example-table").tabulator();
var arrayOfTeachers = $('#teacherslist').val().split('\n');
//var table = new Tabulator("#example-table", {});



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
    //{id:1, name:"Β1", age:"12", gender:"male", height:1, col:"red", dob:"", cheese:1},
    //{id:2, name:"Α", age:"1", gender:"female", height:2, col:"blue", dob:"14/05/1982", cheese:true},
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

var table = new Tabulator("#example-table", {
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
            echo '{title:"'.$tmima.'", field:"tmimacode'.$counter_tmima_col.'",headerSort:false, editor:"select", editorParams:cellEditSelectTeacherFunction
            },';
            $counter_tmima_col++;
        }
        
?> 
           
    ],

    rowFormatter:function(row){
        //row - row component
        var data = row.getData();

        if(data.col == "ΔΕΥΤΕΡΑ" || data.col == "ΩΡΑ" ){
            row.getElement().css({"background-color":"blue"});
        }
    },

    // INTERCEPT download
    downloadReady:function(fileContents, blob){
        //fileContents - the unencoded contents of the file
        //blob - the blob object for the download
        alert(blob);
        //custom action to send blob to server could be included here
        blob=blob;
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

});

//trigger download of data.json file
$("#download-json").click(function(){
    table.showColumn("day"); //show the "name" column
    table.download("json", "data.json");
    table.hideColumn("day"); //show the "name" column
});

//$("#example-table").tabulator("download", "xlsx", "data.xlsx", {sheetName:"MyData"}); //download a Xlsx file that has a sheet name of "MyData"


//trigger download of data.xlsx file
$("#download-xlsx").click(function(){
    table.showColumn("day"); //show the "name" column
    table.download("xlsx", "school_program.xlsx", {sheetName:"My Data"});
    table.hideColumn("day"); //show the "name" column
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
    table.setData($('textarea#programdata').val());
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
ΕΙΣΑΓΩΓΗ ΔΕΔΟΜΕΝΩΝ ΠΡΟΓΡΑΜΜΑΤΟΣ που έχουν γίνει με το κουμπι εξαγωγή σε JSON (αντιγραψτε τα εδώ):<BR> <textarea id="programdata" cols=50 rows=10 ></textarea>
<button id="import_json">import_json</button>
<?php
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Α"]="Α";
    $options["Β1"]="Β1";
    $options["Γ1"]="Γ1";
    $options["Δ1"]="Δ1";
    print_r($options);
?>
</body>
