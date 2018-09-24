
/*
// Set the Drupal site path.
jDrupal.config('sitePath', 'http://localhost/drupal8test');

// Connect to Drupal and say hello to the current user.
jDrupal.connect().then(function() {
  var user = jDrupal.currentUser();
  var msg = user.isAuthenticated() ?
  'Hello user : ' + user.getAccountName() : 'Hello World - No User is connected';
  document.getElementById('msg').innerHTML = msg;
});

*/

jQuery(document).ready(function($) {

var tableEmptyData = [
    {uuid:1, lastName:"ΠΑΡΑΚΑΛΩ ΕΠΙΛΕΞΤΕ ΕΠΙΘΕΤΟ"},
    
]
var dateFormatHuman = "yy-mm-dd";
var startDate=  new Date().toJSON().slice(0,10).replace(/-/g,'/');
var endDate=    new Date().toJSON().slice(0,10).replace(/-/g,'/');

//#############datepicker range
  $( function() {
    var dateFormat = dateFormatHuman,
      datepicker_from = $( "#date_from" )
        .datepicker({
          defaultDate: "+1w",
          dateFormat: dateFormatHuman,
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          datepicker_to.datepicker( "option", "minDate", getDate( this ) );
          //startDate = $(function() { return new Date(getDate(this)).getTime();});
          startDate=$('#date_from').datepicker( "option", "dateFormat", '@' ).val()/1000; // */1000 convert to php
          console.log("datepicker_from change DATE " + startDate +"  date_format @  "+ startDate);
        }),
      datepicker_to = $( "#date_to" ).datepicker({
        defaultDate: "+1w",
        dateFormat: dateFormatHuman,   
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        datepicker_from.datepicker( "option", "maxDate", getDate( this ) );
        endDate=$('#date_to').datepicker( "option", "dateFormat", '@' ).val()/1000; // */1000 convert to php       
        console.log("datepicker_to. change  DATE " + endDate +"  date_format @  "+ endDate);
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
        //$( "#date_from" ).parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
//#############datepicker range END

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

//#############selectize building ID start
$('#selectize_building').selectize({
    valueField: 'BuildingID',
    labelField: 'BuildingID',
    searchField: 'BuildingID',
    //create: false,
    maxItems: 1 ,    
    render: {
        option: function(item, escape) {
            return '<div>' +
                '<span class="title">' +
                    '<span class="BuildingID"> Κωδ. κτιρίου παραρτήματος ' + escape(item.BuildingID) + ' </span>' +
                    '<span class="certCode"> Κωδ. αδείας φροντιστηρίου ' + escape(item.certCode) + ' </span>' +
                     '<span class="DieythinsiID">ΔΔΕ : ' + escape(item.DieythinsiID) + '</span>' +
                '</span>' +
            '</div>';
        }
    }, // End of BuildingID render: {



    onChange: function(value) {
                    console.log("selectize BuildingID onChange ok"+value);
                    if(value.length<1 ) {
                        console.log("selectize BuildingID onChange ok - EMPTY Clearing afm=" +value);
                        $("#example-table").tabulator("setData",tableEmptyData);
                        //$("#example-table").tabulator("clearFilter");
                    }
                    else {
                        //startDateHuman=$('#date_from').datepicker(datepicker( "option", "dateFormat", "@" )).val() ;// $( "#date_from" ).datepicker.parseDate( dateFormatHuman, this.value );
                        console.log("selectize onChange ok - sending BuildingID=" +value + "   , startDate="+startDate );
                        //$("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours",{ teacher_afm:value },"GET"); //ORIG ok working
                        //$("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours",[ {teacher_afm:value}, {search_end_date: endDate}, {search_begin_date: startDate} ],"GET");  //PROBLEM expecting array got Object
  						$("#example-table").tabulator("setData","http://localhost/drupal8test/view/local/didaskalia-workhours",{search_enddate:endDate,search_begindate:startDate, parartima_id:value},"GET"); //ΝΟΤΕ do NOT put underscores: eg start_date                       
                        
                        console.log("tabulator_get_filters:"+$("#example-table").tabulator("getFilters"));
                        //$("#example-table").tabulator("clearFilter");
                        //$("#example-table").tabulator("addFilter", "afm", "=", value);
                    }
    },


    load: function(query, callback) {
        if (!query.length) return callback();

        $.ajax({
            url: 'http://localhost/drupal8test/view/local/parartima-list',// + encodeURIComponent(query),
            type: 'GET',
            dataType: 'json',
            data: {
                BuildingID: query,
            },         
            error: function() {
                console.log("selectize BuildingID error ok");
                callback();
            },
            success: function(res) {
                console.log("selectize BuildingID success ok" + query);
                //callback(res.repositories.slice(0, 10));
                //console.log("res"+JSON.stringify(res));
                //$("#example-table").tabulator("addFilter", "afm", "=", res.afm);
                callback(res);
            },
        });
    }
});  // END of $('#selectize').selectize(

//#############selectize BuildingID END



  // Code that uses jQuery's $ can follow here.
  $("#example-table").tabulator({
  	//ajaxURL:"http://localhost/drupal8test/view/local/didaskalia-workhours", //ajax URL  OK works
    //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
    ajaxConfig:"GET", //ajax HTTP request type
    //ajax DOCS http://tabulator.info/docs/3.3#set-data
    ajaxFiltering:true, //send filter data to the server instead of processing locally  **sends a POST object	
    //ajaxSorting:true, //send sort data to the server instead of processing locally
    height:"811px",
    layout:"fitColumns",
    //pagination:"local",
    //paginationSize:5,
    //movableColumns:true,    
    columns:[
        //{title:"Name", field:"name"},
        {title:"Κώδ. φροντ.", field:"parartima_id", headerFilter:true ,groupBy:"parartima_id"},
        {title:"ΑΦΜ<BR>εκπαιδευτικού", field:"afm", headerFilter:true},
        {title:"Επώνυμο<BR>εκπ/κού", field:"lastName", headerFilter:true},        
        {title:"Όνομα<BR>εκπ/κού", field:"firstName"},                
        {title:"Ειδικότητα<BR>εκπ/κού", field:"speciality_id", headerFilter:true},        
        {title:"Ώρες διδασκαλίας<BR>συνολικού κύκλου μαθήματος<BR> εκπ/κού", field:"rrule_this_didaskalia_workhours", topCalc:"sum"},
        {title:"Ώρες ατομικής <BR>διδ/λίας <BR>μαθ/τος <BR>εκπ/κού", field:"didaHours" },
        {title:"Eπαναλήψεις<BR>διδ/λίας <BR>μαθ/τος <BR>εκπ/κού", field:"rrule_this_event_instances"},
        {title:"Εναρξη<BR>dtstart", field:"dtstart"},
        {title:"Λήξη<BR>until", field:"until"},

    ],
}); // END of $("#example-table").tabulator({

//trigger download of data.csv file
$("#download-csv").click(function(){
    $("#example-table").tabulator("download", "csv", "data.csv");
});

//trigger download of data.json file
$("#download-json").click(function(){
    $("#example-table").tabulator("download", "json", "data.json");
});

//trigger download of data.xlsx file
$("#download-xlsx").click(function(){
    $("#example-table").tabulator("download", "xlsx", "data.xlsx");
});

//trigger refresh-data
$("#refresh-data").click(function(){
    $("#example-table").tabulator("setData");
});


//$("#example-table").tabulator("download", "csv", "data.csv"); //download table data as a CSV formatted file with a file name of data.csv  <-- this will directly download EMPTY http://tabulator.info/docs/3.3#download
//trigger download of data.csv file

//$("#example-table").tabulator("addFilter", "didaHours", ">", 1);

/*
//Custom filter example
function customFilter(data){
    return data.car && data.rating < 3;
}

//Trigger setFilter function with correct parameters
function updateFilter(){

    var filter = $("#filter-field").val() == "function" ? customFilter : $("#filter-field").val();

    if($("#filter-field").val() == "function" ){
        $("#filter-type").prop("disabled", true);
        $("#filter-value").prop("disabled", true);
    }else{
        $("#filter-type").prop("disabled", false);
        $("#filter-value").prop("disabled", false);
    }

    $("#example-table").tabulator("setFilter", filter, $("#filter-type").val(), $("#filter-value").val());
}

//Update filters on value change
$("#filter-field, #filter-type").change(updateFilter);
$("#filter-value").keyup(updateFilter);

//Clear filters on "Clear Filters" button click
$("#filter-clear").click(function(){
    $("#filter-field").val("");
    $("#filter-type").val("=");
    $("#filter-value").val("");

    $("#example-table").tabulator("clearFilter");
});

*/



}); // END of jQuery(document).ready(function($) {


/*
//OK this works : 
jQuery(document).ready(function($) {
  // Code that uses jQuery's $ can follow here.
  $("#example-table").tabulator({
    ajaxURL:"http://localhost/drupal8test/view/local/didaskalia-workhours", //ajax URL
    //ajaxParams:{key1:"value1", key2:"value2"}, //ajax parameters
    ajaxConfig:"GET", //ajax HTTP request type    
    height:"311px",
    columns:[
        //{title:"Name", field:"name"},
        {title:"Κώδ. φροντ.", field:"parartima_id", headerFilter:true},
        {title:"ΑΦΜ<BR>εκπαιδευτικού", field:"afm", headerFilter:true},
        {title:"Επώνυμο<BR>εκπ/κού", field:"lastName", headerFilter:true},        
        {title:"Όνομα<BR>εκπ/κού", field:"firstName"},                
        {title:"Ειδικότητα<BR>εκπ/κού", field:"speciality_id", headerFilter:true},        
        {title:"Ώρες διδασκαλίας<BR>συνολικού κύκλου μαθήματος<BR> εκπ/κού", field:"rrule_this_didaskalia_workhours", topCalc:"sum"},
        {title:"Ώρες ατομικής <BR>διδ/λίας <BR>μαθ/τος <BR>εκπ/κού", field:"didaHours"},
        {title:"Eπαναλήψεις<BR>διδ/λίας <BR>μαθ/τος <BR>εκπ/κού", field:"rrule_this_event_instances"},
        {title:"Εναρξη<BR>dtstart", field:"dtstart"},
        {title:"Λήξη<BR>until", field:"until"},

    ],
}); // END of $("#example-table").tabulator({
}); // END of jQuery(document).ready(function($) {
*/
