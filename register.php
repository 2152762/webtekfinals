<?php
session_start();
$_SESSION['messege'] = ''; 
   
$mysqli = new mysqli('localhost', 'root', 'accounts');
   
   if($_SERVER['REQUEST_METHOD']== 'POST'){
       
       if($_POST['password'] == $_POST['confirmpassword']){
           $username = $mysqli->real_escape_string($_POST['username']);
           $email = $mysqli ->real_escape_string($_Post['email']);
           $password = md5($_POST['password']);
           $profile_path = $mysqli->real_escape_string('image/'.$FILES['profile']['name']);
           
           //check if fie is img
           if(preg_match("!image!", $_FILES['profile']['type'])){
               
               //copy the image file
               if(copy($_FILES['profile']['tmp_name'], $profile_path)){
                   
                   $_SESSION['username'] = $username;
                   $_SESSION['profile'] = $profile;
                   
                   $sql = "INSERT INTO user (username, email, password, profile)"
                           . "VALUES ('$username', '$email', '$password', '$profile')";
                   
                   //after query success
                   if($mysqli->query($sql)== true){
                       $_SESSION['messege'] = "Registration Successful.";
                       header("location: welcome.php");
                   }
                   else{
                       $_SESSION['messege'] = "Registration Unsuccessful.";
                   }
               }
               else{
                   $_SESSION['messege'] = "Upload Failed";
               }
           }else{
               $_SESSION['messege'] = "Please select an image file.";
           }
       }else{
           $_SESSION['messege'] = "Mismatched passwored.";
       }
   }
?> 
<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="register.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>Create an account</h1>
    <form class="form" action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?=$_SESSION['messege'] ?></div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
      <div class="profile"><label>Select your profile: </label><input type="file" name="profile" accept="image/*" required /></div>
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>