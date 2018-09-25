# tabulator-timetable
tabulator-timetable




_________________

Hide Column In Download
If you dont want to show a particular column in the downloaded data you can set the download property in its column definition object to false:

$("#example-table").tabulator({
    columns:[
        {title:"Hidden Column", field:"secret", download:false} //hide data in download
    ]
});



