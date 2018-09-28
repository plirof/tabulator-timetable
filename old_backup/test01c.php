<?php
    $teacherlist_text= "Α1,24\nΑ2,11\nΠΛΗΡ,11\nΓΥΜΝ1,11\n";
    $options["ΠΛΗΡ"]="ΠΛΗΡ";
    $options["Α"]="Α";
    $options["Β1"]="Β1";
    $options["Γ1"]="Γ1";
    $options["Δ1"]="Δ1";

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
    {id:1, name:"Β1", age:"12", gender:"male", height:1, col:"red", dob:"", cheese:1},
    {id:2, name:"Α", age:"1", gender:"female", height:2, col:"blue", dob:"14/05/1982", cheese:true},
]

var table = new Tabulator("#example-table", {
	data:tableData, //set initial table data
    height:"311px",
    //layout:"fitColumns",
    //movableRows:true,
        columns:[
        {title:"Name", field:"name", editor:"select", editorParams:cellEditSelectTeacherFunction
        /*{"ΠΛΗΡ":"ΠΛΗΡ", "Α":"Α", "Β1":"Β1", "Γ1":"Γ1","Δ1":"Δ1",  }        */    
        },
        {title:"Age", field:"age", editor:true},
        {title:"Gender", field:"gender", editor:true /*, validator:["required", "in:male|female"]*/},
        {title:"Height", field:"height", editor:true},
        {title:"Favourite Color", field:"col", editor:"input"},
        {title:"Date Of Birth", field:"dob", editor:true},
        {title:"Cheese Preference", field:"cheese", editor:autocompEditor, validator:"required"},
    ],



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


//#############selectize start
$('#selectize').selectize({
    valueField: 'afm',
    labelField: 'lastName',
    searchField: 'lastName',
    //create: false,
    maxItems: 1 ,    
    render: {
        option: function(item, escape) {
            return '<div>' +
                '<span class="title">' +
                    '<span class="surname"> ' + escape(item.lastName) + ' </span>' +
                    '<span class="firstname">' + escape(item.firstName) + ' </span>' +
                     '<span class="afm">ΑΦΜ : ' + escape(item.afm) + '</span>' +
                '</span>' +
            '</div>';
        }
    }, // ενδ οφ render: {
    /*
    score: function(search) {   //used to sort
        var score = this.getScoreFunction(search);
        return function(item) {
            return score(item) * (1 + Math.min(item.watchers / 100, 1));
        };
    },
    */
// !!! BUG if I achange teacher it remains empty

    onChange: function(value) {
                    console.log("selectize onChange ok"+value);
                    if(value.length<1 ) {
                        console.log("selectize onChange ok - EMPTY Clearing afm=" +value);
                        $("#example-table").tabulator("setData",tableEmptyData);
                        //$("#example-table").tabulator("clearFilter");
                    }
                    else {
                        //startDateHuman=$('#date_from').datepicker(datepicker( "option", "dateFormat", "@" )).val() ;// $( "#date_from" ).datepicker.parseDate( dateFormatHuman, this.value );
                        console.log("selectize onChange ok - sending teacher_afm=" +value + "   , startDate="+startDate );
                        //$("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours",{ teacher_afm:value },"GET"); //ORIG ok working
                        //$("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours",[ {teacher_afm:value}, {search_end_date: endDate}, {search_begin_date: startDate} ],"GET");  //PROBLEM expecting array got Object
                        $("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours",{search_enddate:endDate,search_begindate:startDate, teacher_afm:value},"GET"); //ΝΟΤΕ do NOT put underscores: eg start_date                       
                        
                        console.log("tabulator_get_filters:"+$("#example-table").tabulator("getFilters"));
                        //$("#example-table").tabulator("clearFilter");
                        //$("#example-table").tabulator("addFilter", "afm", "=", value);
                    }
    },
/*
    onItemAdd: function(value, $item) {
                    $("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours");
                    console.log("selectize onItemAdd ok");
                    $("#example-table").tabulator("addFilter", "afm", "=", value);
    },
*/
/*
    onClear: function() {
                    console.log("selectize onClear ok");
                   // $("#example-table").tabulator("clearFilter");
    },
*/

    load: function(query, callback) {
        if (!query.length) return callback();

        $.ajax({
            url: 'http://localhost/drupal8test/view/local/teacher-list',// + encodeURIComponent(query),
            type: 'GET',
            dataType: 'json',
            data: {
                lastName: query,
            },         
            error: function() {
                console.log("selectize error ok");
                callback();
            },
            success: function(res) {
                console.log("selectize success ok" + query);
                //callback(res.repositories.slice(0, 10));
                //console.log("res"+JSON.stringify(res));
                //$("#example-table").tabulator("addFilter", "afm", "=", res.afm);
                callback(res);
            },
        });
    }
});  // END of $('#selectize').selectize(

//#############selectize END

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
