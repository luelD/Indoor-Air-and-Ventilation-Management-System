<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    echo "Access Denied";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>

/* BODY */
body{
margin:0;
font-family:Arial;
background:#f4f6f9;
}

/* LAYOUT */
.container{
display:flex;
height:100vh;
}

/* SIDEBAR */
.sidebar{
width:220px;
background:#2c3e50;
color:white;
padding-top:20px;
display:flex;
flex-direction:column;
}

.sidebar h2{
text-align:center;
margin-bottom:20px;
}

.sidebar button{
width:100%;
padding:15px;
border:none;
background:none;
color:white;
font-size:15px;
cursor:pointer;
text-align:left;
}

.sidebar button:hover{
background:#34495e;
}

/* HEADER */
.header{
position:fixed;
top:0;
left:220px;
right:0;
height:60px;
background:#ecf0f1;
display:flex;
justify-content:space-between;
align-items:center;
padding:0 20px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.logout{
background:#3498db;
color:white;
padding:8px 15px;
border-radius:5px;
text-decoration:none;
font-weight:bold;
}

.logout:hover{
background:#2980b9;
}

/* CONTENT */
.content{
margin-left:220px;
padding:80px 30px;
flex:1;
}

/* CARD */
.card{
background:white;
padding:20px;
margin-bottom:20px;
border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.2);
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
}

table, th, td{
border:1px solid #ddd;
}

th, td{
padding:10px;
text-align:center;
}

th{
background:#2c3e50;
color:white;
}

/* BUTTONS */

.btn{
padding:6px 12px;
border:none;
border-radius:4px;
cursor:pointer;
}

.edit{
background:#27ae60;
color:white;
}

.delete{
background:#e74c3c;
color:white;
}

</style>

<script>

function showPage(page){

document.getElementById("dashboard").style.display="none";
document.getElementById("users").style.display="none";
document.getElementById("sensor").style.display="none";
document.getElementById("fan").style.display="none";
document.getElementById("reports").style.display="none";
document.getElementById("logs").style.display="none";

document.getElementById(page).style.display="block";

}

</script>

</head>

<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">

<h2>Admin Panel</h2>

<button onclick="showPage('dashboard')">Dashboard</button>
<button onclick="showPage('users')">Users</button>
<button onclick="showPage('sensor')">Sensor Data</button>
<button onclick="showPage('fan')">Fan Control</button>
<button onclick="showPage('reports')">Reports</button>
<button onclick="showPage('logs')">System Logs</button>

</div>


<!-- HEADER -->
<div class="header">

<h3>Welcome Admin: <?php echo $_SESSION['username']; ?></h3>

<a href="../logout.php" class="logout">Logout</a>

</div>


<!-- CONTENT -->
<div class="content">


<!-- DASHBOARD -->
<div id="dashboard" class="card">

<h3>System Overview</h3>

<?php

$userCount = $conn->query("SELECT * FROM users")->num_rows;
$sensorCount = $conn->query("SELECT * FROM sensor_readings")->num_rows;

?>

<p><b>Total Users:</b> <?php echo $userCount; ?></p>
<p><b>Total Sensor Records:</b> <?php echo $sensorCount; ?></p>

</div>



<!-- USERS -->
<div id="users" class="card" style="display:none;">

<h3>User Management</h3>

<table>

<tr>
<th>ID</th>
<th>Username</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php

$result = $conn->query("SELECT * FROM users");

while($row = $result->fetch_assoc()){

echo "<tr>";

echo "<td>".$row['id']."</td>";
echo "<td>".$row['username']."</td>";
echo "<td>".$row['role']."</td>";

echo "<td>
<button class='btn edit'>Edit</button>
<button class='btn delete'>Delete</button>
</td>";

echo "</tr>";

}

?>

</table>

</div>



<!-- SENSOR DATA -->
<div id="sensor" class="card" style="display:none;">

<h3>Sensor Monitoring</h3>

<table>

<tr>
<th>CO2</th>
<th>PM2.5</th>
<th>Temperature</th>
<th>Humidity</th>
<th>Time</th>
</tr>

<?php

$sql = "SELECT * FROM sensor_readings ORDER BY recorded_at DESC LIMIT 20";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

echo "<tr>";

echo "<td>".$row['co2']."</td>";
echo "<td>".$row['pm25']."</td>";
echo "<td>".$row['temperature']."</td>";
echo "<td>".$row['humidity']."</td>";
echo "<td>".$row['recorded_at']."</td>";

echo "</tr>";

}

?>

</table>

</div>



<!-- FAN CONTROL -->
<div id="fan" class="card" style="display:none;">

<h3>Fan Control</h3>

<?php

$sql = "SELECT * FROM fan_status ORDER BY changed_at DESC LIMIT 1";
$result = $conn->query($sql);

$status = "OFF";

if($result->num_rows > 0){
$row = $result->fetch_assoc();
$status = $row['status'];
}

echo "<h2>Fan Status: ".$status."</h2>";

?>

<form method="POST" action="../fan_control.php">

<button name="fan" value="ON"
style="padding:10px 20px;background:green;color:white;border:none;border-radius:5px;">
ON
</button>

<button name="fan" value="OFF"
style="padding:10px 20px;background:red;color:white;border:none;border-radius:5px;">
OFF
</button>

</form>

</div>



<!-- REPORTS -->
<div id="reports" class="card" style="display:none;">

<h3>Reports</h3>

<p>Download system reports:</p>

<ul>

<li>Daily Air Quality Report</li>
<li>Weekly Sensor Report</li>
<li>Fan Usage Report</li>

</ul>

</div>



<!-- SYSTEM LOGS -->
<div id="logs" class="card" style="display:none;">

<h3>System Logs</h3>

<table>

<tr>
<th>User</th>
<th>Action</th>
<th>Date</th>
</tr>

<?php

$result = $conn->query("SELECT * FROM system_logs ORDER BY date DESC LIMIT 20");

while($row = $result->fetch_assoc()){

echo "<tr>";

echo "<td>".$row['user']."</td>";
echo "<td>".$row['action']."</td>";
echo "<td>".$row['date']."</td>";

echo "</tr>";

}

?>

</table>

</div>


</div>

</div>

</body>
</html>