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

<div id="example-table"></div>
<script>
//$("#example-table").tabulator();

//var table = new Tabulator("#example-table", {});

var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columns:[
        {title:"Name", field:"name", width:150, editor:"input", validator:"required"},
        {title:"Progress", field:"progress", sorter:"number", align:"left", editor:"input", editor:true,  validator:["min:0", "max:100", "numeric"]},
        {title:"Gender", field:"gender", editor:"input", validator:["required", "in:male|female"]},
        {title:"Rating", field:"rating",  editor:"input", align:"center", width:100, editor:"input", validator:["min:0", "max:5", "integer"]},
        {title:"Favourite Color", field:"col", editor:"input", validator:["minLength:3", "maxLength:10", "string"]},
    ],
    validationFailed:function(cell, value, validators){
        //cell - cell component for the edited cell
        //value - the value that failed validation
        //validatiors - an array of validator objects that failed

        //take action on validation fail
    },
});

</script>
</body>