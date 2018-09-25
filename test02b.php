<?php
    $teacherlist_text= "Α1,24\nΑ2,11\nΠΛΗΡ,11\nΓΥΜΝ1,11\n";
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Α"]="Α";
    $options["Β1"]="Β1";
    $options["Γ1"]="Γ1";
    $options["Δ1"]="Δ1";

    $tmimatalist_text="Α1,Α2,Β,Γ1,Γ2,Δ1,Δ2,Ε,ΣΤ1,ΣΤ2";
    $tmimata_array = explode(',',$tmimatalist_text);
?>
<html>
<head>
<script type="text/javascript" src="js/jquery1.12.4.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
<!-- <link href="css/tabulator3.3.2.min.css" rel="stylesheet"> -->
<link href="css/tabulator.min.css" rel="stylesheet">
<!-- <script type="text/javascript" src="js/tabulator3.3.2.min.js"></script> --> 
<script type="text/javascript" src="js/tabulator.min.js"></script>

        
<script src="js/selectize-standalone/selectize.min.js"></script>


</head>
<body>
ΚΑΘΗΓΗΤΕΣ: <textarea id="teacherslist" cols=50 rows=10 ><?php echo $teacherlist_text; ?></textarea>
<button id="add-row">add-row</button>
<button id="download-json">download-json</button>

<div id="example-table"></div>
<script>
//$("#example-table").tabulator();
var arrayOfTeachers = $('#teacherslist').val().split('\n');
//var table = new Tabulator("#example-table", {});

//create autocomplete editor (example of using jquery code to create an editor)
var autocompEditor = function(cell, onRendered, success, cancel){
    //create and style input
    var input = $("<input type='text'/>");

    //setup jquery autocomplete
    input.autocomplete({
        source: ["United Kingdom", "Germany", "France", "USA", "Canada", "Russia", "India", "China", "South Korea", "Japan"]
    });

    input.css({
        "padding":"4px",
        "width":"100%",
        "box-sizing":"border-box",
    })
    .val(cell.getValue());

    onRendered(function(){
        input.focus();
        input.css("height","100%");
    });

    //submit new value on blur
    input.on("change blur", function(e){
        if(input.val() != cell.getValue()){
            success(input.val());
        }else{
            cancel();
        }
    });

    //submit new value on enter
    input.on("keydown", function(e){
        if(e.keyCode == 13){
            success(input.val());
        }

        if(e.keyCode == 27){
            cancel();
        }
    });

    return input[0];
};  // end of editor


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
    
    $days_array=["ΔΕΥΤΕΡΑ","ΤΡΙΤΗ","ΤΕΤΑΡΤΗ","ΠΕΜΠΤΗ","ΠΑΡΑΣΚΕΥΗ","test"];
    foreach($days_array as $this_day) {
        echo '{id:'.$counter_row_whole_table.',time:"'.$this_day.'"},'; 
        $counter_row_whole_table++;
        for($daily_hour_counter=1;$daily_hour_counter<11;$daily_hour_counter++){
            $timetable_row= '{id:'.$counter_row_whole_table.',time:"'.$daily_hour_counter.'",';    
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
    layout:"fitColumns",
    //movableRows:true,
        columns:[
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
    table.download("json", "data.json");
});

//Add row on "Add Row" button click
$("#add-row").click(function(){
    table.addRow({});
});

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



</script>

<?php
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Α"]="Α";
    $options["Β1"]="Β1";
    $options["Γ1"]="Γ1";
    $options["Δ1"]="Δ1";
    print_r($options);
?>
</body>
