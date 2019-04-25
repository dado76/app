<?Php
$dir='.'; // directory name
$ar=scandir($dir);


// Looping through the list of selected files ///
while (list ($key,$val) = @each ()) {
    $path=$dir	."/".$val;
    if(unlink($path)) echo "Deleted file ";
    echo "$val,";
}
echo "<hr>";

/// displaying the file names with checkbox and form ////
echo "<form method=post name='f1' action=''>";
while (list ($key, $val) = each ($ar)) {
    if(strlen($val)>3){
        echo "<input type=checkbox name=box[] value='$val'>$val<br>";
    }
}
echo "<input type=submit value='Delete'></form>";
?>
