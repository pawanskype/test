<?php 


include '../phpsqlsearch_dbinfo.php';

if(!empty($_REQUEST['search']) ){	
    
$search_parameter=$_REQUEST['search'];
$domain = $_SERVER['HTTP_HOST'];

    $sr_url = "http://localhost/store-locator/api/fetch_sr_loc_api.php?search=$search_parameter";
    $tdc_url = "http://localhost/store-locator/api/new_fetch_tdc_loc.php?search=$search_parameter";


    // print_r($tdc_url);
    // die();
    // Function to make cURL request
    function makeRequest($url) {
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set cURL option to ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }

// Fetch data from the first URL
 $sr_data = makeRequest($sr_url);
 $sr_data_array = json_decode($sr_data, true);

// Fetch data from the second URL
  $tdc_data = makeRequest($tdc_url);
  
  $tdc_data_array = json_decode($tdc_data, true);

 
  $zipcode = [];
  foreach ($tdc_data_array['result'] as $key => $value) {
    if (empty($value['url']) && is_numeric($key)) {
        // If both conditions are met, extract the zip code
        $zipcodes[] = $key;
    }
  }

  foreach ($zipcodes as $zipcode) {

    $sqlsuit = "SELECT suite FROM markers WHERE zipcode = '".$zipcode."' AND adminid = 52";
    $result = $conn->query($sqlsuit);
  
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
  
          $suite = $row['suite'];
  
      }
    } 
    $sqlurl = "SELECT url FROM locationsurl WHERE parent_id = '".$suite."'";
    $resulturl = $conn->query($sqlurl);
    if ($resulturl->num_rows > 0) {
      // output data of each row
      while($rowurl = $resulturl->fetch_assoc()) { 
  
          $suiteurl = $rowurl['url'];
     
      }
    } 
    $tdc_data_array['result'][$zipcode]['url'] = $suiteurl;
//     echo"<pre>";
//   print_r($tdc_data_array['result'][$zipcode]['url']);
//   echo "</pre>";
  //die();
}

 





   if(!empty($sr_data_array) && !empty($tdc_data_array))
   {
    // Merge the arrays
    $mergedData = array_merge_recursive($tdc_data_array, $sr_data_array);


    // Ensure only single values for overallStatusCode and message
    $mergedData['overallStatusCode'] = $mergedData['overallStatusCode'][0];
    $mergedData['message'] = $mergedData['message'][0];
    $mergedData['result']['searchedterm'] = $mergedData['result']['searchedterm'][0];
    $mergedData['result']['type'] = $mergedData['result']['type'][0];

    echo $mergedJson = json_encode($mergedData, true);

   }elseif(empty($sr_data_array) && !empty($tdc_data_array)){

    echo $mergedJson = json_encode($tdc_data_array, true);
   }elseif(!empty($sr_data_array) && empty($tdc_data_array)){

    echo $sr_data_array = json_encode($tdc_data_array, true);
   }

   else{

    $message = 'Coming to Your State Soon';   
    $api->response($api->json([],$message,500,$status), 500);
   }
}


?>