<!DOCTYPE html>
<html>
<head>
    <title>Traffic Information</title>
    <style>
        table {
            width: 35%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-weight:bold;
        }
        th {
            background-color: #f2f2f2;
        }
        .highlight {
            border: 2px solid red;
        }
    </style>
</head>
<body>

<h2>Traffic Information</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "Swathi@123";
$database = "20331A0572";
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
/*$up="SELECT * from upside";
$down="SELECT * from downside";
if($up>$down){
  echo"Upside of the road is with heavy traffic\n";
}
else{
  echo"Downside of the road is with heavy traffic";
}*/
//echo"on"." ".date("d-m-y")." ".date("h:i");
$sql = "SELECT distinct(object_id),(speed) FROM detected_objects where speed<150";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table id='trafficTable'>";
    echo "<tr><th>ID</th><th>Speed(km/hr)</th></tr>";

    foreach ($result as $info) {
        $speed = $info['speed'];
        $highlight_class = ($speed > 80) ? 'highlight' : '';
        echo "<tr class='$highlight_class'>";
        echo "<td>" . $info['object_id'] . "</td>";
        echo "<td>" . $info['speed'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

$s="drop view upside";
$s1="drop view downside";
?>

<script>
    var rows = document.querySelectorAll("#trafficTable tr");

    rows.forEach(function(row) {
        var speedCell = row.querySelector("td.speed");
        if (speedCell !== null) {
            var speed = parseInt(speedCell.textContent);
            if (!isNaN(speed) && speed > 100) {
                row.classList.add("highlight");
            }
        }
    });
</script>

</body>
</html>
