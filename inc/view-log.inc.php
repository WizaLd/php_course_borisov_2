<?
if(is_file(PATH_LOG)) {

    $file = file(PATH_LOG);
    echo "<ol>";

    foreach($file as $line) {

        list($dt, $page, $ref) = explode("|", $line);
        echo "<li>"."$dt - $page -> $ref"."</li>"."\n";
    }
    echo "</ol>";
}