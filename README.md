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



_______

Intercept & Manipulate Download Blob New
The downloadReady callback allows you to intercept the download file data before the users is prompted to save the file.

In order for the download to proceed the downloadReady callback is expected to return a blob of file to be downloaded.

If you would prefer to abort the download you can return false from this callback. This could be useful for example if you want to send the created file to a server via ajax ranther than allowing the user to download the file.

$("#example-table").tabulator({
    downloadReady:function(fileContents, blob){
        //fileContents - the unencoded contents of the file
        //blob - the blob object for the download

        //custom action to send blob to server could be included here

        return blob; //must return a blob to proceed with the download, return false to abort download
    }
});


____________
https://stackoverflow.com/questions/51220838/supplying-csv-file-input-to-ajax-url-to-display-on-html-table#

__________________