<?php  
include_once 'functions.php';
 session_start();  
 $host = "localhost";  
 $username = "root";  
 $password = "";  
 $database = "phpcrud";  
 $message = "";  
 try  
 {  
      $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $msg = '<label>All fields are required</label>';  
           }  
           else  
           {  
                $query = "SELECT * FROM utilisateurs WHERE username = :username AND password = :password";  
                $statement = $connect->prepare($query);  
                $statement->execute(  
                     array(  
                          'username'     =>     $_POST["username"],  
                          'password'     =>     $_POST["password"]  
                     )  
                );  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
                     $_SESSION["username"] = $_POST["username"];  
                     header("location:adduser.php");  
                }  
                else  
                {  
                     $msg = '<label>Wrong Data</label>';  
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $msg = $error->getMessage();  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
 <?=template_header('Create')?>
 
           <div class="container" style="width:500px;">  
                <?php  
                if(isset($msg))  
                {  
                     echo '<label class="text-danger">'.$msg.'</label>';  
                }  
                ?>  
                <h3 align="">AUTHENTIFICATION</h3><br />  
                <form method="post">  
                     <label>Mail </label>  
                     <input type="text" name="username" placeholder="votre Mail" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="password" class="form-control" />  
                     <br />  
                     <input type="submit" name="login" class="btn btn-info" value="Login" />  
                </form>  
                <br>
               
                <a href="http://localhost/session-authentification/sinscrire.php">Inscrivez vous</a>
           </div>
         
         