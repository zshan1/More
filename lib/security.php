<?php
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// performs a simple security check
function securityCheck($formURL = "") {
    $debugThis = false;
    
    $status = true; // start off thinking everything is good until a test fails
    
    // when it is a form page check to make sure it submitted to itself
    if ($formURL != "") {
        $fromPage = htmlentities($_SERVER['HTTP_REFERER'], ENT_QUOTES, "UTF-8");
        
        //remove http or https
        $fromPage = preg_replace('#^https?:#', '', $fromPage);
        
        if ($debugThis)
            print "<p>From: " . $fromPage . " should match your Url: " . $formURL;
        
        if ($fromPage != $formURL) {
            $status = false;
        }
    }
    
    return $status;
}
?>
