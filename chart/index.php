<?php
    $xml_data = simplexml_load_file("../xml/data_203.xml");
    
    // $year_selection = "2016";

    //input data from webpage
    if($_POST["y2016"] == "true"){
        $year_selection = "2016";
    }else if($_POST["y2017"] == "true"){
        $year_selection = "2017";
    }else if($_POST["y2018"] == "true"){
        $year_selection = "2018";
    }else if($_POST["y2019"] == "true"){
        $year_selection = "2019";
    }

    function getYear($rec){
        return date("Y", intval($rec['ts']));
    }

    function getMonth($rec){
        return date("m", intval($rec['ts']));
    }

    function getHour($rec){
        return date("h", intval($rec['ts']));
    }

    function getNo($rec){
        return intval($rec['no']);
    }

    function MonthAvarage($no_data){
        $month_len = count($no_data);
        $total_no = 0; 
        foreach($no_data as $no_value){
            $total_no += $no_value;
        }

        return $total_no / $month_len;
    }

    function sortByDate(&$no_data, &$date_arr){
        for($x = 0; $x <= count($date_arr) - 1; $x++){
            for($j = 0; $j <= count($date_arr) - 1; $j++){
                if($x == 0 || $j == 0){
                    continue;
                }else{
                    if(intval($date_arr[$x]) <= intval($date_arr[$j])){
                        [$date_arr[$x], $date_arr[$j]] = [$date_arr[$j], $date_arr[$x]];
                        [$no_data[$x], $no_data[$j]] = [$no_data[$j], $no_data[$x]];
                    }
                }
            }
        }
    }

    // function mapData($data, $months_data){
    //     $mapped_data = array();
    //     for($no_data = 0; $no_data <= count($data); $no_data++){    
    //         for($month = 0; $month <= count($months_data); $month++){
    //             $entry = $data[$no_data][$month];
    //             array_push($mapped_data,  )
                
    //         }
    //     }
        
    // }

    //loop over each time stamp
    //check the year is between  2015 - 2019
        //set the current month e.g 01
        //check if the month has changed 
            //add all nox values to temp array to be avaraged
            //get length of array and avarage each value.
            //store month as key and avaraged data in associative array.

    // foreach($year_selection as $selected_year){
    $year_date = array();
    $year_no_data = array();
    array_push($year_date, "Month");
    array_push($year_no_data, strval($year_selection));

    foreach($xml_data->rec as $rec){
        $current_year = getYear($rec);
        $current_month = getMonth($rec);
        
        if(!in_array($current_month, $year_date)){
            if($current_year == $year_selection ){
                $temp_month_arr = [];

                foreach($xml_data->rec as $month_check){
                    $year = getYear($month_check);
                    $hour = getHour($month_check);
                    $month = getMonth($month_check);
                    if($year == $current_year){
                        if($current_month == $month){
                            if($hour == "08"){
                                $no = getNo($month_check);
                                array_push($temp_month_arr, $no );
                            }
                        }
                    }
                }

                $avarage = MonthAvarage($temp_month_arr);
                array_push($year_no_data, $avarage);
                array_push($year_date, intval($current_month));
                $temp_mnonth_arr = [];

            }
        }
    }
    
    sortByDate($year_no_data, $year_date);
    
    $data = array_map(null, $year_date, $year_no_data, );
    $data = json_encode($data);
    echo $data;
    

?>
