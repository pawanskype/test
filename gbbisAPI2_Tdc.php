<?php

ini_set('max_execution_time', '0'); // for infinite time of execution
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'phpsqlsearch_dbinfo.php';
include 'Functions.php';
require 'vendor/autoload.php';
$object = new Functions();
date_default_timezone_set('America/Chicago');
$current_time = date('Y-m-d H:i:s');
$status_query = "Insert into json_api2_tdc_status (start_time,status) VALUES ('$current_time',0)";
$status_query_result = mysqli_query($conn, $status_query);

if ($status_query_result) {
    $last_insert_id = mysqli_insert_id($conn);
}
$check_previous_status = 'Select status from json_api_tdc_status order by id desc limit 1';
$result = mysqli_query($conn, $check_previous_status);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//Set CST time
date_default_timezone_set('America/Chicago');
$current_time = date('Y-m-d H:i:s');
if ($row['status'] == 0) {
    $object->send_failure_api_msgUsingMail();
    exit();
}

$query = 'select * from jsondataAPI_tdc';
$data = mysqli_query($conn, $query);
$count_of_records = mysqli_num_rows($data);
$flag = false;
$location_id = '';
$location_name = '';
$parent_license = '';

if ($count_of_records > 0) {
    $sqlTruncate = 'TRUNCATE TABLE r1_failure_tdc';
    mysqli_query($conn, $sqlTruncate);
    $sqlTruncate1 = 'TRUNCATE TABLE r1_bridge_tdc';
    mysqli_query($conn, $sqlTruncate1);
    $one = [];
    $two = [];
    //loop through
    $i = 1;
    $brand_name = 'Driveway Company';
    $brand_num = 3;
    while ($Results = mysqli_fetch_assoc($data)) {
        //if($Results->Status=="Owned" || $Results->Status=="Donut"){ //Process only Donut and Owned status TerritoryName
        $flag = true;
        if ($Results['Brand'] == 'Driveway Company' || $Results['Brand'] == 'The Driveway Company') {
            $buss_id = 52;  // for tdc business id is 52
            $brand = isset($Results['Brand']) ? $Results['Brand'] : 'n/a';
            if (($Results['ParentLicenseNumber']) || ($Results['DonuntParentLicense'])) {
                if (($Results['ParentLicenseNumber'])) {
                    $pid = $Results['ParentLicenseNumber'];
                } elseif (($Results['DonuntParentLicense'])) {
                    $pid = $Results['DonuntParentLicense'];
                }
                $sqlparent = "SELECT location_id,location_name,parent_license FROM r1_parent_info_lookUp WHERE brand=$brand_num AND parent_license='".$pid."'"; //Get parent data using parent license.
                $sql_run_query = mysqli_query($conn, $sqlparent);
                if ($sql_run_query) {
                    $status_data = mysqli_fetch_assoc($sql_run_query);
                    if (!empty($status_data)) {
                        $location_id = isset($status_data['location_id']) ? $status_data['location_id'] : 0;
                        $location_name = isset($status_data['location_name']) ? $status_data['location_name'] : 'n/a';
                        $parent_license = isset($status_data['parent_license']) ? $status_data['parent_license'] : 0;
                        if (!in_array($Results['ZipCode'], ['0', null])) {
                            $Country = explode(',', $Results['County']);
                            if (!empty($Country)) {
                                $exploadCounty = isset($Country[1]) ? $Country[1] : '';
                            } else {
                                $exploadCounty = '';
                            }

                            $licensenumber = isset($Results['LicenseNumber']) ? $Results['LicenseNumber'] : 0;
                            $zipcode = isset($Results['ZipCode']) ? $Results['ZipCode'] : 0;
                            $zipcodename = isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : 'n/a';

                            $status = isset($Results['Status']) ? $Results['Status'] : 0;

                            $child_location_name = 'Driveway Company SERVING '.trim($exploadCounty, ' ').' '.trim($exploadCounty, ' ');
                            mysqli_query($conn, "INSERT into r1_bridge_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,created_at) VALUES ($buss_id,".$location_id.",'".$brand."','".$licensenumber."','".$parent_license."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$current_time."')");
                        } else {
                            $Remark = 'Warning : No Zipcodes found';
                            $child_location_name = '';
                            $licensenumber = isset($Results['LicenseNumber']) ? $Results['LicenseNumber'] : 0;
                            $status = isset($Results['Status']) ? $Results['Status'] : 0;
                            $location_name = isset($location_name) ? $location_name : '';
                            $parent_license = isset($parent_license) ? $parent_license : '';

                            mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$parent_license."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");
                        }
                    } else {
                        //exception for parent;
                        $sqlparentlookup = "SELECT Parent_Licence,Child_License FROM r1_parent_license_lookUp WHERE brand=$brand_num AND Child_License='".$pid."'"; //Get parent data using parent license.
                        $sql_run_query_lookup = mysqli_query($conn, $sqlparentlookup);
                        if ($sql_run_query_lookup) {
                            $status_data_lookup = mysqli_fetch_assoc($sql_run_query_lookup);
                            if (!empty($status_data_lookup)) {
                                $pid1 = isset($status_data_lookup['Parent_Licence']) ? $status_data_lookup['Parent_Licence'] : '0';
                                $pidnew = isset($status_data_lookup['Child_License']) ? $status_data_lookup['Child_License'] : '0';
                                $sqlparent = "SELECT location_id,location_name,parent_license FROM r1_parent_info_lookUp WHERE brand=$brand_num AND parent_license='".$pid1."'"; //Get parent data using parent license again.
                                $sql_run_query = mysqli_query($conn, $sqlparent);
                                if ($sql_run_query) {
                                    $status_datanew = mysqli_fetch_assoc($sql_run_query);
                                    if (!empty($status_datanew)) {
                                        $location_id_new = isset($status_datanew['location_id']) ? $status_datanew['location_id'] : '0';
                                        $location_name = isset($status_datanew['location_name']) ? $status_datanew['location_name'] : '0';
                                        $parent_license = isset($status_datanew['parent_license']) ? $status_datanew['parent_license'] : '0';

                                        $Country = explode(',', $Results['County']);

                                        if (!empty($Country)) {
                                            $exploadCounty = isset($Country[1]) ? $Country[1] : '';
                                        } else {
                                            $exploadCounty = '';
                                        }

                                        $child_location_name = isset($child_location_name) ? $child_location_name : '0';
                                        $zipcode = isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';
                                        $Status = isset($Results['Status']) ? $Results['Status'] : '0';
                                        $ZipCodeName = isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '0';
                                        if (!in_array($Results['ZipCode'], ['0', null])) {
                                            mysqli_query($conn, "INSERT into r1_bridge_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,created_at) VALUES ($buss_id,".$location_id_new.",'".$brand."','".$pidnew."','".$pid1."','".$location_name."','".$child_location_name."','".$zipcode."','".$ZipCodeName."','".$exploadCounty."','".$Status."','".$current_time."')");
                                        } else {
                                            $Remark = 'Warning : No Zipcodes found';
                                            $child_location_name = '';

                                            $licensenumber = isset($Results['LicenseNumber']) ? $Results['LicenseNumber'] : 0;
                                            $status = isset($Results['Status']) ? $Results['Status'] : 0;
                                            $location_name = isset($location_name) ? $location_name : '';
                                            $parent_license = isset($parent_license) ? $parent_license : '';

                                            mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$parent_license."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");
                                            array_push($two, $i);
                                        }
                                    } else {
                                        //exception for parent;
                                        $Remark = $pid1.' TDC Parent license is not found in r1_parent_info_lookUp table';
                                        $location_name = '';
                                        $plicense = '';

                                        $licensenumber = isset($Results['LicenseNumber']) ? $Results['LicenseNumber'] : 0;
                                        $pid1 = isset($pid1) ? $pid1 : '0';
                                        $status = isset($Results['Status']) ? $Results['Status'] : 0;
                                        $location_name = isset($location_name) ? $location_name : '';
                                        $parent_license = isset($parent_license) ? $parent_license : '';
                                        $zipcode = isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';

                                        if (!in_array($zipcode, ['0', null])) {
                                            $zipcodename = isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '';

                                            $Country = explode(',', $Results['County']);
                                            if (!empty($Country)) {
                                                $exploadCounty = isset($Country[1]) ? $Country[1] : '';
                                            } else {
                                                $exploadCounty = '';
                                            }

                                            $child_location_name = 'Driveway Company SERVING '.trim($zipcodename, ' ').' '.trim($exploadCounty, ' ');

                                            mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$pid1."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$Remark."','api','".$current_time."')");
                                            array_push($two, $i);
                                        } else {
                                            $Remark = 'Driveway Company zipcode not found';
                                            $child_location_name = '';

                                            mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$pid1."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");
                                            array_push($two, $i);
                                        }
                                    }
                                }
                            } else {
                                $Remark = $pid.' Driveway Company Parent license is not found in r1_parent_license_lookUp table';
                                $location_name = '';
                                $plicense = '';
                                $licensenumber = isset($Results['LicenseNumber']) ? $Results['LicenseNumber'] : 0;
                                $pid = isset($pid) ? $pid : '0';
                                $status = isset($Results['Status']) ? $Results['Status'] : 0;
                                $location_name = isset($location_name) ? $location_name : '';
                                $zipcode = isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';
                                $zipcodename = isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '';

                                if (!in_array($zipcode, ['0', null])) {
                                    $Country = explode(',', $Results['County']);
                                    if (!empty($Country)) {
                                        $exploadCounty = isset($Country[1]) ? $Country[1] : '';
                                    } else {
                                        $exploadCounty = '';
                                    }

                                    $child_location_name = 'Driveway Company SERVING '.trim($zipcodename, ' ').' '.trim($exploadCounty, ' ');

                                    mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$pid."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$Remark."','api','".$current_time."')");
                                    array_push($two, $i);
                                } else {
                                    $Remark = 'Driveway Company zipcode not found';
                                    $child_location_name = '';

                                    mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$pid."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");
                                    array_push($two, $i);
                                }
                            }
                        }
                    }
                }
            } else {
                $Remark = 'Driveway Company Parent License Missing';
                $location_name = '';
                $plicense = '';

                $licensenumber = isset($Results['LicenseNumber']) ? $Results['LicenseNumber'] : 0;
                $pid = isset($pid) ? $pid : '0';
                $status = isset($Results['Status']) ? $Results['Status'] : 0;
                $location_name = isset($location_name) ? $location_name : '';
                $zipcode = isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';
                $zipcodename = isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '';

                if (!in_array($zipcode, ['0', null])) {
                    $Country = explode(',', $Results['County']);
                    if (!empty($Country)) {
                        $exploadCounty = isset($Country[1]) ? $Country[1] : '';
                    } else {
                        $exploadCounty = '';
                    }

                    $child_location_name = 'Driveway Company SERVING '.trim($zipcodename, ' ').' '.trim($exploadCounty, ' ');
                    mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$plicense."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$Remark."','api','".$current_time."')");

                    array_push($two, $i);
                } else {
                    $Remark = 'Driveway Company zipcode not found and parent license missing';
                    $child_location_name = '';
                    mysqli_query($conn, "INSERT into r1_failure_tdc(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES ($buss_id,0,'".$brand."','".$licensenumber."','".$plicense."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");

                    array_push($two, $i);
                }
            }
        }

        ++$i;
    }
} else {
    $message = 'Software Mapping Data is empty';
    mysqli_query($conn, "INSERT into r1_logs_tdc(message,created_at) VALUES ('".mysqli_real_escape_string($conn, $message)."','".$current_time."')");
}

//save stats, save csv backup and send mail

if ($flag == true) {
    $data = '';
    $sqldump = 'SELECT * FROM zipcodesnew_tdc';
    $result = mysqli_query($conn, $sqldump);
    $zipcodesnewprocess = false;
    $r1_messages = [];
    $bf_messages = [];
    if (!empty($result) && mysqli_num_rows($result) > 0) {
        try {
            $updtsql = 'update zipcodesnew_tdc set flagtodelete=1';
            mysqli_query($conn, $updtsql);
            $sql = "INSERT INTO zipcodesnew_tdc(buss_id,loc_id,r1_number_parent,r1_number,parent_loc_name,zip_name,zipcode,city,state)SELECT buss_id,loc_id,parent_license,child_license,parent_location_name,child_location_name,zipcode,city,state from r1_bridge_tdc where brand like '%".$brand_name."%'";

            $sendR1_failuremail = false;
            if (mysqli_query($conn, $sql)) {
                $sqlTruncate = 'delete from zipcodesnew_tdc where flagtodelete=1';
                mysqli_query($conn, $sqlTruncate);

                $sendR1_failuremail = true;
                $zipcodesnewprocess = true;
            } else {
                $r1_messages[] = 'New data could not be inserted into zipcodesnew_tdc table and so new sitemap was not uploaded.';

                mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('R1 sitemap could not be created as zipcodesnew
table not updated','".$current_time."')");
            }
        } catch (Exception $e) {
            //Insert data in log table and check exception
            mysqli_query($conn, "INSERT into r1_logs_tdc(message,created_at) VALUES ('".mysqli_real_escape_string(
                $conn,
                $e->getMessage()
            )."','".$current_time."')");
        }
    } else {
        $r1_messages[] = 'zipcodesnew_tdc table is empty';
        mysqli_query($conn, "INSERT into r1_logs_tdc(message,created_at) VALUES ('Zipcodesnew is empty','".$current_time."')");
    }

    if ($zipcodesnewprocess == true) {
        // making stats
        $json_r1_owned = mysqli_num_rows(mysqli_query($conn, 'select * from jsondataAPI_tdc where Brand = "'.$brand_name.'" and Status
= "Owned"'));

        $json_r1_donut = mysqli_num_rows(mysqli_query($conn, 'select * from jsondataAPI_tdc where Brand ="'.$brand_name.'"  and Status
= "Donut"'));

        if ($zipcodesnewprocess == true) {
            $db_r1_owned = mysqli_num_rows(mysqli_query($conn, 'select * from r1_bridge_tdc where brand ="'.$brand_name.'"  and status =
"Owned"'));

            $db_r1_donut = mysqli_num_rows(mysqli_query($conn, 'select * from r1_bridge_tdc where brand ="'.$brand_name.'"  and status =
"Donut"'));

            $db_r1_owned_failures = mysqli_num_rows(mysqli_query($conn, 'select * from r1_failure_tdc where brand ="'.$brand_name.'"  and
status = "Owned"'));

            $db_r1_donut_failures = mysqli_num_rows(mysqli_query($conn, 'select * from r1_failure_tdc where brand ="'.$brand_name.'"  and
status = "Donut"'));
        } else {
            $db_r1_owned = 0;
            $db_r1_donut = 0;
            $db_r1_owned_failures = 0;
            $db_r1_donut_failures = 0;
        }
        $insertsql = "INSERT INTO
gbbis_stats_tdc(json_r1_owned,json_r1_donut,database_r1_owned,database_r1_donut,database_r1_owned_failures,database_r1_donut_failures,created)
VALUES
('".$json_r1_owned."','".$json_r1_donut."','".$db_r1_owned."','".$db_r1_donut."','".$db_r1_owned_failures."','".$db_r1_donut_failures."','".date('Y-m-d
H:i:s')."')";
        mysqli_query($conn, $insertsql);
    }

    // fauilure mail send
    $result_sql_restoration1 = mysqli_query($conn, "SELECT ANY_VALUE(parent_license) as parentlicense ,ANY_VALUE(remark) as
remarking ,GROUP_CONCAT(zipcode) as zipcodes FROM r1_failure_tdc where buss_id = $buss_id GROUP BY remark");

    if (isset($result_sql_restoration1) && mysqli_num_rows($result_sql_restoration1) > 0) {
        $j = 1;
        $messageEmail = '';
        while ($rowFetch = mysqli_fetch_array($result_sql_restoration1)) {
            if (isset($sendR1_failuremail) and $sendR1_failuremail == true) {
                $messageEmail .= '
<p style="width: 68%; font-size:18px;">
    <span
        style=" color: rgb(43, 40, 40); font-size: 14px; font-weight: bold; margin-right:10px;">'.$j.'.</span>'.$rowFetch['remarking'].'
</p>
<p style="width: 68%; font-size:18px;">
    <span style=" color: rgb(43, 40, 40); font-size: 14px; font-weight: bold; margin-right:10px;">Zipcodes
        effected</span>'.$rowFetch['zipcodes'].'
</p>';
            }

            ++$j;
        }

        if (!empty($r1_messages)) {
            $messageEmail .= "<p style='color:red;font-size:20px;'>BlueFrog Additional Notes:</p>";

            foreach ($r1_messages as $k => $v) {
                $messageEmail .= "<p>****$v</p>";
            }
        }
        $object->sendFailureEmailRestoration1UsingMail($messageEmail);
    }

    $txt = 'TDC Code executed at time '.date('Y-m-d h:i');

    echo 'cron finished';
}
if (!empty($last_insert_id)) {
    $date = date('Y-m-d H:i:s');
    $status_query = "UPDATE json_api2_tdc_status SET end_time='$date',status = 1 WHERE id = $last_insert_id";
    $status_query_result = mysqli_query($conn, $status_query);
}
