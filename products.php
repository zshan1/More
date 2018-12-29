<?php
include "top.php";

print"<p>Most commonly industrial robots are fixed robotic arms and manipulators used primarily for production and distribution of goods. The term 'service robot' is less well-defined. The International Federation of Robotics has proposed a tentative definition, 'A service robot is a robot which operates semi- or fully autonomously to perform services useful to the well-being of humans and equipment, excluding manufacturing operations.' Here are our latest verson of robots. We have 3 different types of robot that can meet the daily need in your life. We also provide accessories to help you build your own robot. Our goal is satisified every custumers and we want our robot fit your lifestyle, so we DO NOT provide online market, please contact our staff and find out what you really need first.</p>";
$debug = FALSE;

if(isset($_GET["debug"])){
    $debug = true;
}

$myFileName="products";

$fileExt=".csv";

$filename = $myFileName . $fileExt;

if ($debug) print "\n\n<p>filename is " . $filename;

$file=fopen($filename, "r");

// the variable $file will be empty or false if the file does not open
if($file){
    if($debug) print "<p>File Opened</p>\n";
}
if($file){
    
    if($debug) print "<p>Begin reading data into an array.</p>\n";

    // This reads the first row, which in our case is the column headers
    $headers[]=fgetcsv($file);
    
    if($debug) {
        print "<p>Finished reading headers.</p>\n";
        print "<p>My header array<p><pre> "; print_r($headers); print "</pre></p>";
    }
    // the while (similar to a for loop) loop keeps executing until we reach 
// the end of the file at which point it stops. the resulting variable 
// $records is an array with all our data.

    while(!feof($file)){
        $records[]=fgetcsv($file);
    }
    
    //closes the file
    fclose($file);
    
    if($debug) {
        print "<p>Finished reading data. File closed.</p>\n";
        print "<p>My data array<p><pre> "; print_r($records); print "</pre></p>";
    }
} // ends if file was opened

 foreach ( $records  as  $row) { 
     print '<table>';
     print '<tr>';
     print "<td>$row[1]</td>";
     print "<td><img src=". $row[3]." alt='picture that I find on the Internet'></td>"; 
     print "<td>$row[2]</td>";
     print "<td> <a href= 'displayProduct.php?pid=". $row[0] ."'>". $row[7]."</a></td>";
     print '</tr>';
     print '</table>';
 } 

 
 ?>

<?php include "footer.php"; ?>

</body>
</html>