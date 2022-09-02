<?php

return array(
/** set your paypal credential **/
'client_id' =>'AW2WesoQqt5H7I9GIzPJyOzhOEK8LgX0w_a4J31NKfL4wtmjnrsgfu0tqgmJxnLNsXIANJAPi_YJosUg',
'secret' => 'EEnq9NRiY97VMdweqCKBmdci1gS3ieAkyr8_HkPmXBBHHyLLFCUul2Dwo5VpFKYApsawmtb3bbmluQuM',
/**
* SDK configuration 
*/
'settings' => array(
    /**
    * Available option 'sandbox' or 'live'
    */
    'mode' => 'sandbox',
    /**
    * Specify the max request time in seconds
    */
    'http.ConnectionTimeOut' => 1000,
    /**
    * Whether want to log to a file
    */
    'log.LogEnabled' => true,
    /**
    * Specify the file that want to write on
    */
    'log.FileName' => storage_path() . '/logs/paypal.log',
    /**
    * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
    *
    * Logging is most verbose in the 'FINE' level and decreases as you
    * proceed towards ERROR
    */
    'log.LogLevel' => 'FINE'
    ),
);