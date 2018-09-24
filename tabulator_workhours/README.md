# tabulator_workhours jdrupal-drupal-example
An example Drupal 8 module to use jDrupal.

#installation:
 - Enable REST user -cookie authentication type (for jdrupal to connect and display username)
 -
 -
 -

# REST exports :
 - view/local/didaskalia-workhours 
##REST Filtersexample:
 - localhost/drupal8test/didaskalia-rrule-workhours?search_begin_date=1409364970&search_end_date=1909364970&teacher_afm=1234456789&
 - localhost/drupal8test/didaskalia-rrule-workhours?search_end_date=10093649&search_begin_date=&cert_code_id=&parartima_id=&teacher_afm=&teacher_lastname=&speciality_id=
 
#jon To test tabulator:

 - https://jsfiddle.net/Zuur/be6mx0yp/10/

- https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js
- https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css
- https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js
- https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.2.1/css/tabulator.min.css
- https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.2.1/js/tabulator.min.js



## tabulator ajaxFiltering:true http://tabulator.info/docs/3.3#set-data
** will need a controller/hook to alter responce view according to POST data"
https://drupal.stackexchange.com/questions/180141/how-to-choose-between-all-the-views-hooks

`
Ajax Filtering Updated

If you would prefer to filter your data server side rather than in Tabulator, you can use the ajaxFiltering option to send the filter data to the server instead of processing it client side

$("#example-table").tabulator({
    ajaxFiltering:true, //send filter data to the server instead of processing locally
});
An array of filters objects will then be passed in the filters parameter of the request, the name of this parameter can be set in the in the paginationDataSent option, in the pagination extension.

The array of filter objects will take the same form as those returned from the getFilters function:

[
    {field:"age", type:">", value:52}, //filter by age greater than 52
    {field:"height", type:"<", value:142}, //and by height less than 142
]
If a custom filter function is being used then the type parameter will have a value of "function".

If the table is not currently filtered then the array will be empty.
`

https://github.com/olifolkerd/tabulator/issues/131


# selectize

https://github.com/selectize/selectize.js/blob/master/docs/usage.md


# datepicker

https://stackoverflow.com/questions/11610797/trigger-function-when-date-is-selected-with-jquery-ui-datepicker

https://jqueryui.com/datepicker/#date-range


##datepicker format date to integer
https://api.drupal.org/api/drupal/core!core.libraries.yml/8.4.x
Current version : datepicker:  1.12.1 (Stable, for jQuery1.7+) 
Drupal version : version": "1.11.4",

http://api.jqueryui.com/datepicker/#utility-formatDate

`
$(function() {
  $( "#datepicker" ).datepicker({
    //dateFormat: 'yy-dd-mm',
    dateFormat: '@',  //RETURNS unix/javascript date format (1000*php int date)
    onSelect: function() {
      var date =  $(this).datepicker('getDate');
      var day = date.getDate();
      var month = date.getMonth() + 1;
      var year =  date.getFullYear(); 
      alert(day + '-' + month  + '-' + year);
    }
  });
});
`

`
Here's a function that will give you the Unix timestamp you're looking for.

function getUnixTimeFromString(string) {

time = new Date(string);
unixTime = time.getTime()/1000; 
    return unixTime;

}
`

