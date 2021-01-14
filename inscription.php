<?php  
 session_start();  
include_once 'functions.php';
 $host = "localhost";  
 $username = "root";  
 $password = "";  
 $database = "phpcrud";  
 $message = "";  
// if ( $_SESSION['name'] == )
 try  
 {  

      $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) && empty($_POST["password"]))  
           {  
                $message = '<label>All fields are required</label>';        
          }
          if( $_POST["password"] !== $_POST["confpassword"] ){
               $message = '<label>Wrong Data is not same</label>'; 
               
          }
          elseif( $_SESSION["username"] === $_POST["username"] ||  $_POST["password"]==  $_SESSION["password"])  
               { 
                    $query = "SELECT * FROM utilisateurs WHERE username = :username AND password = :password";  
                    
                    $statement = $connect->prepare($query);   
                    $count = $statement->rowCount(); 
                    $count < 0 ;
                    $message = '<label>Wrong Data existe</label>'; 
               } 
           else  
           {  
               $name  = $_POST['name'];
               $nameus  = $_POST['username']; $pass = $_POST['password'];
               $query = "INSERT INTO `utilisateurs` ( `nom`,`username`, `password`) VALUES ('$name','$nameus', '$pass');";  
                $statement = $connect->prepare($query);  
                $statement->execute(  
                     [   
                          'nom'          =>     $_POST["name"],  
                          'username'     =>     $_POST["username"],  
                          'password'     =>     $_POST["password"]  
                     ]
                );  
                $count = $statement->rowCount();  
                
                if($count > 0)  
                {  
                     $_SESSION["username"] = $_POST["username"];  
                     header("location:adduser.php");  
                }  

                     //header("location:adduser.php");  
                
                else  
                {  
                     $message = '<label>Wrong Data</label>';  
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 ?>  
 <?=template_header('Home')?>

           <div class="container" style="width:500px;">  
                <?php  
                if(isset($message))  
                {  
                     echo '<label class="text-danger">'.$message.'</label>';  
                }  
                ?>  
                <h3 align="">INSCRIVEZ-VOUS</h3><br />  
                <form method="post">  
                    <label>Nom</label>  
                     <input type="text" name="name" placeholder="John Doe" class="form-control" required/>  
                     <br /> 
                     <label>Mail</label>  
                     <input type="text" name="username" placeholder="John-Doe@mail.com" class="form-control" required/>  
                      <b >
                     <label>Mot de passe</label>  
                     <input type="password" name="password" class="form-control" required />  
                     <br />  
                     <!-- <input type="submit" name="login" class="btn btn-info" value="Login"  />   -->
                     <label>Confirm mot de passe</label>  
                     <input type="password" name="confpassword" class="form-control" />  
                     <br />  
                     <input type="submit" name="login" class="btn btn-info" value="Login" /> 
                </form>  
                <br>
                <a href="inscription.php">Inscrivez vous</a>
                
           </div>
 <?=template_footer()?>
