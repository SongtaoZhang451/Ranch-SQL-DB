<?php include 'header.php'; ?>
<h2>Ranch Management – Tables</h2>
<ul>
<?php
$tables = ['Employee','Pasture','Equipment','Cattle',
           'HealthRecord','Transaction',
           'Treats','Manages','Financial'];
foreach ($tables as $t)
    echo "<li><a href='view.php?table=$t'>$t</a></li>";
?>
</ul>
<?php include 'footer.php'; ?>
