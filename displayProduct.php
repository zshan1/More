<?php
include ("top.php");

$personId = $_GET["pid"];
$debug = false;
if (isset($_GET["debug"])) {
    $debug = true;
}

$myFileName = "products";
$fileExt = ".csv";
$filename = $myFileName . $fileExt;

if ($debug)
    print "\n\n<p>filename is " . $filename;

$file = fopen($filename, "r");


if ($file) {
    if ($debug)
        print "<p>File Opened</p>\n";
}

if ($file) {
    if ($debug)
        print "<p>Begin reading data into an array.</p>\n";


    $headers = fgetcsv($file);

    if ($debug) {
        print "<p>Finished reading headers.</p>\n";
        print "<p>My header array<p><pre> ";
        print_r($headers);
        print "</pre></p>";
    }
$record = array();
    while (!feof($file)) {
        $records[] = fgetcsv($file);
        if ($records[count($records) - 1][0] == $personId) {
        $record = end($records);
    }
    }

    fclose($file);

    if ($debug) {
        print "<p>Finished reading data. File closed.</p >\n";
        print "<p>My data array<p><pre> ";
        print_r($records);
        print "</pre></p >";
    }
}

     print '<table>';
     print"<th>$headers[1]</th>";
     print"<th>$headers[5]</th>";
     print"<th>$headers[6]</th>";
     print"<th>$headers[8]</th>";
     print'<tr>';
     print "<td>$record[1]</td>";
     print "<td>$record[5]</td>"; 
     print "<td>$record[6]</td>";
     print "<td><figcaption> <a href= https://zshan.w3.uvm.edu/cs008/assignment5.0/form.php >". $record[8]." ". "</figcaption></td>";
     print'</tr>';     
     print '</table>';

?>

<?php include "footer.php"; ?>

</body>
</html>