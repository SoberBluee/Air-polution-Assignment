<?php

    $selected_day = "2";
    $selected_year = "2016";
    $selected_month = "01";

    $selected_file = "data_203.xml";

    $xml_data = simplexml_load_file("../xml/data_203.xml");

    function getYear($rec){
        return date("Y", intval($rec['ts']));
    }

    function getMonth($rec){
        return date("m", intval($rec['ts']));
    }

    function getDay($rec){
        return date("d", intval($rec['ts']));
    }

    function getHour($rec){
        return date("h", intval($rec['ts']));
    }

    function getNo($rec){
        return intval($rec['no']);
    }

    foreach($xml_data->rec as $rec){
        $current_year = getYear($rec);
        $current_month = getMonth($rec);
        $current_day = getDay($rec);

        if($current_year == $selected_year && $current_month == $selected_month && $current_day == $selected_day ){
            foreach($xml_data->rec as $hour_check){
                $current_hour = getHour($rec);

            }
        }
    }


?>