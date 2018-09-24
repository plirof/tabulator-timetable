<?php

namespace Drupal\tabulator_workhours\Controller;

use Drupal\Core\Controller\ControllerBase;

class TabulatorWorkhoursController extends ControllerBase {

  public function get_workhours_list() {
    $element = array(

    '#type' => 'inline_template',
    '#template' => '
          <table border=2>
    <tr><td>
     <!--         filter-afm<input type="text" id="#filter-afm" ></td><td>-->

              <label for="from">From</label>
              <input type="text" id="date_from" name="date_from">
        </td><td>

              <label for="to">to</label>
              <input type="text" id="date_to" name="date_to">
        </td>
    </tr>
<tr><td colspan=1>
    
              <!--<div id="msg">Loading... getting jDrupal username</div> -->

    
    <label for="afm">Παρακαλώ επιλέξτε επίθετο εκπαιδευτικού: </label>
    <div id="selectize">Loading...selectize afm</div><br>
   </td><td>

       <label for="afm">Παρακαλώ επιλέξτε παραρτημα: </label>
    <div id="selectize_building">Loading...selectize parartima_id</div><br> 
    </td></tr>    
    <tr><td>
              <button type="button" ><div id="download-csv">Download CSV</div></button>
              <button type="button" ><div id="download-json">Download JSON</div></button>
              <button type="button" ><div id="download-xlsx">Download xlsx</div></button>
        </td>
    </tr>
    <tr><td>    
              <button type="button" ><div id="refresh-data">Refresh data</div></button>
    </td></tr>

    
    </table>
                  <BR>
                  <div id="example-table">Loading... sample-tabulator table</div><br>
                  
              ',
      //'#allowed_tags' => ['html'],          
      '#attached' => array(
        'library' => array(
          'jdrupal/jdrupal',
          'tabulator_workhours/app'
        )
      )
    );
    return $element;
  }

}
?>