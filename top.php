<!DOCTYPE html>
<html lang="en">
    <head>
        <title>More</title>
        <meta charset="utf-8">
        <meta name="author" content="Zixiao Shan">
        <meta name="description" content="a website that sell things">
        <link rel="shortcut icon" href="1.ico" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="style.css" type="text/css" media="screen">

        <?php
        $debug = false;

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//

        $domain = "//";

        $sever = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
        
        $domain .= $sever;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain: " . $domain;
            print "<p>php Self: " . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre></p>";
        }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries. 
// 
// 
// 
//
        print "<!-- include libraries -->";
        
        require_once('lib/security.php');
        
        // notice this if statemtent only includes the functions if it is 
        // form page. A common mistake is to make a form and call the page
        // join.php which means you need to change it below (or delete the if)
        if ($path_parts['filename'] == "form") {
            print "<!-- include form libraries -->";
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
      
        print "<!-- finished including libraries -->";
        
        
        
        if ($path_parts['filename'] == "questionaire") {
            print "<!-- include form libraries -->";
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
      
        print "<!-- finished including libraries -->";
        ?>
        
        
        
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        

        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="js/jquery.flexslider.js"></script>

        <script type="text/javascript">
            var flexsliderStylesLocation = "css/flexslider.css";
            $('<link rel="stylesheet" type="text/css" href="'+flexsliderStylesLocation+'" >').appendTo("head");
            $(window).load(function() {

                $('.flexslider').flexslider({
                    animation: "fade",
                    slideshowSpeed: 3000,
                    animationSpeed: 1000
                });

            });
        </script>

    </head>
    <!-- ################ body section ######################### -->

    <?php
    print '<body id="' . $path_parts['filename'] . '">';
    include "nav.php";
    include "header.php";
    ?>