<!-- 

loop over each data file in the directory
    #output xml header
    split line 1
    header = array(split_array[0], split_array['location'], split_array['geocode])
    output header to file
    data = array()

-->

<?php
    //For handling large file
    date_default_timezone_set("GMT");
    ini_set('memory_limit', '20480M');
    ini_set('max_execution_time', 300);
    ini_set('auto_detect_line_ending', 1);

    function create_record($split_data){
        $record = "    <rec";

        for($i = 0; $i < sizeof($split_data); $i++){
            if($split_data[$i] == ''){
                continue;
            }else{
                switch($i){
                    case '1':
                        $record .= " ts='" . strtotime($split_data[$i]) . "'";
                        break;

                    case '2':
                        $record .= " nox='" . $split_data[$i] . "'";
                        break;

                    case '3':
                        $record .= " no2='" . $split_data[$i] . "'";
                        break;

                    case '4':
                        $record .= " no='" . $split_data[$i] . "'";
                        break;

                    case '5':
                        $record .= " pm10='" . $split_data[$i] . "'";
                        break;

                    case '6':
                        $record .= " nvpm10='" . $split_data[$i] . "'";
                        break;

                    case '7':
                        $record .= " vpm10='" . $split_data[$i] . "'";
                        break;
                        
                    case '8':
                        $record .= " nvpm2.5='" . $split_data[$i] . "'";
                        break;
                        
                    case '9':
                        $record .= " pm2.5='" . $split_data[$i] . "'";
                        break;
                        
                    case '10':
                        $record .= " vpm2.5='" . $split_data[$i] . "'";
                        break;
                        
                    case '11':
                        $record .= " co='" . $split_data[$i] . "'";
                        break;
                        
                    case '12':
                        $record .= " o3='" . $split_data[$i] . "'";
                        break;
                        
                    case '13':
                        $record .= " so2='" . $split_data[$i] . "'";
                        break;
                        
                    case '14':
                        $record .= " temp='" . $split_data[$i] . "'";
                        break;
                }
            }
        }
        $record .= "/>\n";
        return $record;
    }

    $start = microtime(true);

    $dir = scandir("C:\\xampp\\htdocs\\assignment\\data");

    foreach ($dir as $getfile) {

        if(strpos($getfile,"data_") !== False) {
            $filename = str_replace(".csv", ".xml", $getfile);
            $xml_file = fopen("xml/".$filename, "w");

            fwrite($xml_file, "<?xml version='1.0' encoding='UTF-8'?>\n");

            $index = 0;
            $data_file = fopen("data/" . $getfile,'r');
            
            while($data = fgets($data_file)){   
                $record = "";     
                $split_data = explode(";", $data);  


                if($index == 0){
                    $index++;
                    $data = fgets($data_file);
                    if($data == false){
                        $root_element = "<station id='' name='' geocode=''/>\n";
                        fwrite($xml_file, $root_element);
                    }else{
                        $data = trim($data);
                        $split_data_root = explode(";", $data);  
                        $root_element = "<station id='" . $split_data_root[0] . "' name='" . $split_data_root[15] . "' geocode='" . $split_data_root[16] . "'>\n";
                        fwrite($xml_file, $root_element);
                    }
                }
                else{
                    $record = create_record($split_data);
                }
                fwrite($xml_file, $record);

                $index++;
            }
            
            fwrite($xml_file, "</station>");
            fclose($xml_file);
            fclose($data_file);
        }

    }
    //Timer
    echo "Time: ". (microtime(true) - $start);

?>