<?php

require("phpsqlsearch_dbinfo.php");
// Get parameters from URL
$t = "\t";
$n = "\n";
$adminid = $_GET['adminid'];
$connection=mysql_connect ($hostname, $username, $password);
$xml = '<?xml version="1.0" encoding="UTF-8"?>'."$n";
$xml.= '<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
if (!$connection) {
  die("Not connected : " . mysql_error());
}
// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
$query = mysql_query("SELECT slug FROM markers WHERE adminid='$adminid'");
$url="";
$server_url="";
if($adminid==1)
{
    $server_url="https://flapjack.lssdev.com/locations";
    
}else if($adminid==15)
{
    $server_url="https://greenvanlines.com/locations";
    
}else if($adminid==40)
{
    $server_url="https://longjohnsilvers.locationlocators.com";
    
}else if($adminid==41)
{
    $server_url="https://76stations.locationlocators.com";
    
}else if($adminid==43)
{
    $server_url="https://albertsons.locationlocators.com";
    
}else if($adminid==44)
{
    $server_url="https://michaels.locationlocators.com";
    
}else if($adminid==45)
{
    $server_url="https://osh.locationlocators.com";
    
}else if($adminid==46)
{
    $server_url="https://vons.locationlocators.com";
    
}else if($adminid==47)
{
    $server_url="https://nationwide.locationlocators.com";
    
}


while ($row = @mysql_fetch_object($query)){
       $url=$server_url."/?".$row->slug."?detail"." "; 
       $xml.= '<url>'."$n";
       $xml.= "$t".'<loc>'.$url.'</loc>'."$n";
       $xml.= '</url>'."$n";
    
}

$xml.= '</urlset>';
echo $xml;
