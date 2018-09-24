<html>
<head>
<script type="text/javascript" src="js/jquery1.12.4.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
<!-- <link href="css/tabulator3.3.2.min.css" rel="stylesheet"> -->
<link href="css/tabulator.min.css" rel="stylesheet">
<!-- <script type="text/javascript" src="js/tabulator3.3.2.min.js"></script> --> 
<script type="text/javascript" src="js/tabulator4.min.js"></script>

</head>
<body>
ΚΑΘΗΓΗΤΕΣ: <textarea id="teacherslist" cols=50 rows=10 ></textarea>
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
};


var tableData = [
    {id:1, name:"Billy Bob", age:"12", gender:"male", height:1, col:"red", dob:"", cheese:1},
    {id:2, name:"Mary May", age:"1", gender:"female", height:2, col:"blue", dob:"14/05/1982", cheese:true},
]

var table = new Tabulator("#example-table", {
	data:tableData, //set initial table data
    height:"311px",
    //layout:"fitColumns",
    movableRows:true,
        columns:[
        {title:"Name", field:"name", editor:true},
        {title:"Age", field:"age", editor:true},
        {title:"Gender", field:"gender", editor:true, validator:["required", "in:male|female"]},
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
        alert("Row " + row.getIndex() + " Clicked!!!!")
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
</body>