<?php
session_start();
$q = intval($_GET['q']);

//******************************
try {
		$db = new SQLite3(getenv("ROOT") . "dev/maelalaconi/Assets/BD.sqlite", SQLITE3_OPEN_READWRITE);
		$sql = /** @lang SQLite */
"SELECT * FROM Utilisateur WHERE idUtilisateur = " . $q;

// Execution de la requête
$req = $db->querySingle($sql, true);
$text ="....".$req["nom"];

$db->close();
} catch (SQLiteException $e) {
    $text = "connected ?";
}
echo $text ;

//****************************
/*$con = mysqli_connect('localhost','peter','abc123','my_db');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM user WHERE id = '".$q."'";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Age'] . "</td>";
    echo "<td>" . $row['Hometown'] . "</td>";
    echo "<td>" . $row['Job'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);*/
?>