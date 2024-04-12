<?php

require("phpsqlsearch_dbinfo.php");
// Get parameters from URL
$t = "\t";
$n = "\n";
$adminid = $_GET['adminid'];
$connection=mysql_connect ($hostname, $username, $password);

if (!$connection) {
  die("Not connected : " . mysql_error());
}
// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
$query = mysql_query("SELECT slug FROM markers WHERE adminid='$adminid'");
$url="";
$data="<div id='store-locator_locations'><table>";

while ($row = @mysql_fetch_object($query)){
       $url="https://longjohnsilvers.locationlocators.com/?".$row->slug."?detail"; 
       
   $data.="<tr><td>"
           . ucfirst($row->slug)
           . "</td>"
           . "<td>"
           . "<a href='$url'>$url</a>"
           . "</td>"
           . "<tr>";
    
}

$data.='</table></div>';

echo $data; 

?>
<style>
    /* locations page css */
    
  #store-locator_locations table {
    border: 1px solid #eee;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}
#store-locator_locations table tr {
    line-height: 38px;
    text-align:center;
}


/*  end */
</style>