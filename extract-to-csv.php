<!-- 

todo 
output to 18 files (1 for each monitoring station)
each file should be named data_nameOfStation
    E.G   
        data_188
        data_203

each file holds 16 columns
    first 14 columns (pollution data)
    column 18 location
    column 19 geo-location

    show a record does not have NOx (col 2) or CO (col12)
    if neither are there then discard the record 
    
    each file should have all correct headers
        siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long
-->

<?php
    //For handling large file
    date_default_timezone_set("GMT");
    ini_set('memory_limit', '20480M');
    ini_set('max_execution_time', 300);
    ini_set('auto_detect_line_ending', TRUE);

    $file_location = "air-quality-data-2004-2019.csv";
    $updated_records = array();

    //create and open all data files
    $data_188 = fopen('data/data_188.csv','w');
    $data_203 = fopen('data/data_203.csv','w');
    $data_206 = fopen('data/data_206.csv','w');
    $data_209 = fopen('data/data_209.csv','w');
    $data_213 = fopen('data/data_213.csv','w');
    $data_215 = fopen('data/data_215.csv','w');
    $data_228 = fopen('data/data_228.csv','w');
    $data_270 = fopen('data/data_270.csv','w');
    $data_271 = fopen('data/data_271.csv','w');
    $data_375 = fopen('data/data_375.csv','w');
    $data_395 = fopen('data/data_395.csv','w');
    $data_452 = fopen('data/data_452.csv','w');
    $data_447 = fopen('data/data_447.csv','w');
    $data_459 = fopen('data/data_459.csv','w');
    $data_463 = fopen('data/data_463.csv','w');    
    $data_481 = fopen('data/data_481.csv','w');
    $data_500 = fopen('data/data_500.csv','w');
    $data_501 = fopen('data/data_501.csv','w');

    $csv_file = fopen($file_location, "r");
    //Header to be written to each file
    $header = "siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long";

    $start = microtime(true);

    //Loop over csv data file
    while($data = fgets($csv_file)){
        $split_data = explode(";", $data);
        //Check if NOx and CO is empty
        //If true, ignore record
        if($split_data[1] == '' && $split_data[11] == '' ) {
            continue;
        }else{
            $id = $split_data[4];
            //Build record using indexing
            $record = array($split_data[4], $split_data[0], $split_data[1], $split_data[2] , $split_data[3] , $split_data[5] ,$split_data[6] , $split_data[7] , $split_data[8] , $split_data[9] ,
            $split_data[10] , $split_data[11], $split_data[12] , $split_data[13] ,$split_data[14] , $split_data[17] , $split_data[18]);
            //Convert array to string
            $record = implode(";", $record);
            //Add new line at end of record
            $record = $record.PHP_EOL;

            //Switch in id to write data to correct file
            switch($id){
                case '188':
                    fwrite($data_188, $record);
                    break;
                case '203':
                    fwrite($data_203, $record);
                    break;
                case '206':
                    fwrite($data_206, $record);
                    break;
                case '209':
                    fwrite($data_209, $record);
                    break;
                case '213':
                    fwrite($data_213, $record);
                    break;
                case '215':
                    fwrite($data_215, $record);
                    break;
                case '228':
                    fwrite($data_228, $record);
                    break;
                case '270':
                    fwrite($data_270, $record);
                    break;
                case '271':
                    fwrite($data_271, $record);
                    break;
                case '375':
                    fwrite($data_375, $record);
                    break;
                case '395':
                    fwrite($data_395, $record);
                    break;
                case '447':
                    fwrite($data_447, $record);
                    break;
                case '452':
                    fwrite($data_452, $record);
                    break;
                case '459':
                    fwrite($data_459, $record);
                    break;
                case '463':
                    fwrite($data_463, $record);
                    break;
                case '481':
                    fwrite($data_481, $record);
                    break;
                case '500':
                    fwrite($data_500, $record);
                    break;
                case '501':
                    fwrite($data_501, $record);
                    break;
                //Write header to file if non of the above cases are met
                default:
                    fwrite($data_188, $record);
                    fwrite($data_203, $record);
                    fwrite($data_206, $record);
                    fwrite($data_209, $record);
                    fwrite($data_213, $record);
                    fwrite($data_215, $record);
                    fwrite($data_228, $record);
                    fwrite($data_270, $record);
                    fwrite($data_271, $record);
                    fwrite($data_375, $record);
                    fwrite($data_395, $record);
                    fwrite($data_447, $record);
                    fwrite($data_452, $record);
                    fwrite($data_459, $record);
                    fwrite($data_463, $record);
                    fwrite($data_481, $record);
                    fwrite($data_500, $record);
                    fwrite($data_501, $record);
                    break;
            };
        }
    }

    fclose($csv_file);
    fclose($data_188);
    fclose($data_203);
    fclose($data_206);
    fclose($data_209);
    fclose($data_213);
    fclose($data_215);
    fclose($data_228);
    fclose($data_270);
    fclose($data_271);
    fclose($data_375);
    fclose($data_395);
    fclose($data_447);
    fclose($data_452);
    fclose($data_459);
    fclose($data_463);
    fclose($data_500);
    fclose($data_501);
    //Timer
    echo "Time: ". (microtime(true) - $start);

?>