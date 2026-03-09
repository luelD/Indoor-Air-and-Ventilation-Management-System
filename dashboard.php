<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Indoor Air Dashboard</title>
<style>

/* RESET & BODY */
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

/* CONTAINER LAYOUT */
.container{
    display:flex;
    height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:200px;
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
    font-size:16px;
    cursor:pointer;
    text-align:left;
}

.sidebar button:hover{
    background:#34495e;
}

/* HEADER (Top Right) */
.header{
    position:fixed;
    top:0;
    left:200px; /* offset sa sidebar */
    right:0;
    height:60px;
    background:#ecf0f1;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    padding-right:20px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.logout-button{
    font-weight:bold;
    text-transform:uppercase;
    color:#fff;
    text-decoration:none;
    background:#3498db;
    padding:10px 15px;
    border-radius:5px;
}

.logout-button:hover{
    background:#2980b9;
}

/* CONTENT */
.content{
    margin-left:200px; /* offset sidebar */
    padding:80px 30px 30px 30px; /* leave space for header */
    flex:1;
}

/* Cards */
.card{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:8px;
    box-shadow:0 2px 5px rgba(0,0,0,0.2);
}

</style>

<script>
function showPage(page){
    document.getElementById("home").style.display="none";
    document.getElementById("sensor").style.display="none";
    document.getElementById("status").style.display="none";

    document.getElementById(page).style.display="block";
}
</script>

</head>
<body>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Dashboard</h2>

<button onclick="showPage('home')">HOME</button>
<button onclick="showPage('sensor')">SENSOR</button>
<button onclick="showPage('status')">STATUS</button>
</div>

<!-- HEADER with LOGOUT -->
<div class="header">
    <a href="logout.php" class="logout-button">LOGOUT</a>
</div>

<!-- CONTENT -->
<div class="content">

<h2>Welcome <?php echo $_SESSION['username']; ?></h2>

<!-- HOME -->
<div id="home" class="card">
<h3>HOME</h3>
<p>Welcome to Indoor Air Monitoring System</p>
</div>

<!-- SENSOR -->
<div id="sensor" class="card" style="display:none;">
<h3>Latest Sensor Data</h3>
<?php
$sql = "SELECT * FROM sensor_readings ORDER BY recorded_at DESC LIMIT 1";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo "CO2: " . $row['co2'] . "<br>";
    echo "PM2.5: " . $row['pm25'] . "<br>";
    echo "Temperature: " . $row['temperature'] . "<br>";
    echo "Humidity: " . $row['humidity'];
}else{
    echo "No sensor data available";
}
?>
</div>

<!-- STATUS -->
<div id="status" class="card" style="display:none;">
<h3>Fan Status</h3>
<?php
// get latest fan status
$sql = "SELECT * FROM fan_status ORDER BY changed_at DESC LIMIT 1";
$result = $conn->query($sql);
$currentStatus = "OFF";
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $currentStatus = $row['status'];
}
echo "<h2>Fan is: ".$currentStatus."</h2>";
?>
<br>
<form method="POST" action="fan_control.php">
<button type="submit" name="fan" value="ON"
style="padding:10px 20px;background:green;color:white;border:none;border-radius:5px;cursor:pointer;">
ON
</button>
<button type="submit" name="fan" value="OFF"
style="padding:10px 20px;background:red;color:white;border:none;border-radius:5px;cursor:pointer;">
OFF
</button>
</form>
</div>

</div> <!-- end content -->

</div> <!-- end container -->
</body>
</html>