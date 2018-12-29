<?php
include "top.php";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
print"<p>We DO NOT provide online market for a better experience on using our product. You can leave a message here and our staff will contact you in 24 hours. </p>";

$debug = false;

// This if statement allows us in the classroom to see what our variables are
// This is NEVER done on a live site 
if (isset($_GET["debug"])){
    $debug = true;
}

if ($debug) {
    print "<p>DEBUG MODE IS ON</p>";
} 		

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.

$thisURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form

$firstName = "";
$email = "";
$address = "";
$type = "Home Premium";  
$comments="";
$gender="Female";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.

$firstNameERROR = false;
$emailERROR = false;
$addressERROR = false;
$typeERROR = false;
$genderERROR = false;
$commentERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.

$errorMsg = array(); 

// array used to hold form values that will be written to a CSV file
$dataRecord = array();

// have we mailed the information to the user?
$mailed=false;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securityCheck($thisURL)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.
    
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
   
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL); 
    $dataRecord[] = $email;
    
    $address = htmlentities($_POST["txtAddress"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $address;  
    
    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender; 
    
    $type = htmlentities($_POST["lsttypes"],ENT_QUOTES,"UTF-8");
    $dataRecord[] = $type; 
    
    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;      

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the 	101
    // order that the elements appear on your form so that the error messages 	102
    // will be in the order they appear. errorMsg will be displayed on the form 	103
    // see section 3b. The error flag ($emailERROR) will be used in section 3c. 	104
    
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $firstNameERROR = true;
    }
    
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }
    
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";   
                  
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.
        $fileExt = ".csv";
        $myFileName = "data/registration"; // NOTE YOU MUST MAKE THE FOLDER !!!

        $filename = $myFileName . $fileExt;

        if ($debug){
            print "\n\n<p>filename is " . $filename;
        }

        // now we just open the file for append
        $file = fopen($filename, 'a');
    
        // write the forms informations
        fputcsv($file, $dataRecord);
    
        // close the file
        fclose($file);    
        
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).
        
        $message = '<h2>Thank you for choosing us. Our employee will contact you as soon as possible.</h2>';
    
        foreach ($_POST as $key => $value) {
            $message .= "<p>";
            
            // breaks up the form names into words. for example
            // txtFirstName becomes First Name
            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
    
            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }

            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
            
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        
        $from = "MORE <noreply@more.com>";

        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");   
        $subject = "Your request has been submitted: " . $todaysDate;

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
     }// end form is valid
    
}   // ends if form was submitted.

        
//#############################################################################
//
// SECTION 3 Display Form
//
 ?>

<article id="main">
    <h2>Sign up today to get your ideas set up!</h2>
    
    <?php
    //####################################
    //
    // SECTION 3a. 
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit 
        print "<h1>Your Request has ";
    
        if (!$mailed) {
            print "not ";
        }
    
        print "been processed</h1>";

        print "<p>A copy of this message has ";
    
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
    
        print "<p>Mail Message:</p>";
    
        print $message;
    } else {
    
   
        //####################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
        
    if ($errorMsg) {
        print '<div id="errors">' . "\n";
        print "<h2>Your form has the following mistakes that need to be fixed: </h2>\n";
        print "<ol>\n";
        
        foreach ($errorMsg as $err) {
            print "<li>" . $err . "</li>\n";
        }
        
        print "</ol>\n";
        print "</div>\n";
    }
    
        //####################################
        //
        // SECTION 3c html Form
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line ??)
          or the value they typed in (line ??)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
    ?>

    <form action="<?php print $phpSelf; ?>"
          method="post"
          id="frmRegister">

        <fieldset class="wrapper">
            <legend>Please fill out the form!</legend>

            <fieldset class="wrapperTwo">
                <legend>Please make sure your information is correct. Do not forget to check your information!</legend>

                <fieldset class="contact">
                    <legend>Contact Information</legend>
                        
                    <label for="txtFirstName" class="required">First Name
                        <input type="text" 
                               id="txtFirstName" 
                               name="txtFirstName"
                               value="<?php print $firstName; ?>"
                               tabindex="100" 
                               maxlength="45" 
                               placeholder="Enter your first name"
                               <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               autofocus
                               >
                                   
                    </label>                                 
                    <label for="txtEmail" class="required">Email
                        <input type="text" 
                               id="txtEmail" 
                               name="txtEmail"
                               value="<?php print $email; ?>"
                               tabindex="120" 
                               maxlength="45" 
                               placeholder="Enter a valid email address"
                               <?php if ($emailERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    
                    </label>
                    <label for="txtAddress" class="required">Address
                        <input type="text" 
                               id="txtAddress" 
                               name="txtAddress"
                               value="<?php print $address; ?>"
                               tabindex="100" 
                               maxlength="45" 
                               placeholder="Enter your address"
                               <?php if ($addressERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"

                               >
                                   
                    </label>        
                </fieldset> <!-- ends contact -->
                <fieldset class="radio">
                   <legend>What is your gender?</legend>
                    <label><input type="radio" 
                                  id="radGenderMale" 
                                  name="radGender" 
                                  value="Male"
                                  <?php if($gender=="Male") print 'checked'?>
                                 tabindex="330">Male</label>
                    <label><input type="radio" 
                                  id="radGenderFemale" 
                                  name="radGender" 
                                  value="Female"
                                  <?php if($gender=="Female") print 'checked'?>
                                  tabindex="340">Female</label>
                </fieldset>
                <fieldset class="checkbox">
                    <legend>Which type of robot would you like to choose?</legend>
                    <select id="lsttypes" 
                            name="lsttypes" 
                            tabindex="520" >
                    <option <?php if($type=="Home Basic") print " selected "; ?>
                         value="Home Basic">Home Basic</option>
        
                    <option <?php if($type=="Home Premium") print " selected "; ?>
                         value="Home Premium" >Home Premium</option>
        
                    <option <?php if($type=="Home Ultimate") print " selected "; ?>
                         value="Home Ultimate" >Home Ultimate</option>
                    </select>
                </fieldset>
                <fieldset  class="textarea">
                    <legend>What extra function do you want?</legend>
                            <label for="txtComments" class="required"></label>
                                     <textarea id="txtComments" 
                                       name="txtComments" 
                                       tabindex="200"
                                       <?php if($commentsERROR) print 'class="mistake"'; ?>
                                       onfocus="this.select()" 
                                       style="width: 25em; height: 4em;" ><?php print $comments; ?></textarea>
                </fieldset>
                    
            </fieldset> <!-- ends wrapper Two -->
                
            <fieldset class="buttons">
                
                <legend>Please notice that once you submit your information will be recorded in our data list.</legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
            </fieldset> <!-- ends buttons -->
                
        </fieldset> <!-- Ends Wrapper -->
    </form>

    <?php
    }// end body submit
    ?>
    
</article>
 
 <?php include "footer.php"; ?>
 
</body>
</html>
