<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<title>Indoor Air Login</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f0f4f8;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* Login Box */

.login-box{
    background:white;
    padding:40px;
    width:320px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* Title */

.login-box h2{
    text-align:center;
    margin-bottom:25px;
}

/* Inputs */

.login-box input{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

/* Button */

.login-box button{
    width:100%;
    padding:12px;
    background:#3498db;
    border:none;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}

.login-box button:hover{
    background:#2980b9;
}

</style>

</head>

<body>

<div class="login-box">

<h2>Indoor Air System</h2>

<form action="authenticate.php" method="POST">

<label>Username</label>
<input type="text" name="username" required>

<label>Password</label>
<input type="password" name="password" required>

<button type="submit">Login</button>

</form>

</div>

</body>
</html>