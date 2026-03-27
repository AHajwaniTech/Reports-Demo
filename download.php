<?php

echo "<h2>Output</h2>";

if(!empty($_POST['firm_code'])) {

    $firms = explode(",", $_POST['firm_code']);

    echo "<b>Selected Firms:</b><br>";

    foreach($firms as $f) {
        echo $f . "<br>";
    }

    echo "<br>";
    echo "<b>Start Date:</b> " . $_POST['start_date'] . "<br>";
    echo "<b>End Date:</b> " . $_POST['end_date'];

} else {
    echo "<b style='color:red;'>Please select at least one firm!</b>";
}
?>