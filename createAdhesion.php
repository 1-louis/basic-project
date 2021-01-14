<?php
session_start();  

include 'functions.php';
$msg = '';


if(isset($_SESSION["username"] ))  
{

//recupere un user
if(isset($_POST['ajouter'])){
if(!empty($_POST['name']) AND !empty($_POST['prenom']) AND !empty($_POST['age']) AND !empty($_POST['adr'])) {
    $db = pdo_connect_mysql();
    $nom =         htmlspecialchars ($_POST['name']);
    $prenom =      htmlspecialchars ( $_POST['prenom']);
    $text =        htmlspecialchars ( $_POST['text']);
    $age =         htmlspecialchars ($_POST['age']);
    $adr =         htmlspecialchars ($_POST['adr']);
    $db = pdo_connect_mysql();

    $req = $db->prepare("SELECT * FROM adhesion WHERE numero = ?");
    $req->execute(array($adr));
    $exist = $req->rowCount();
	if($exist == 0) {
        $db = pdo_connect_mysql();

        $requete = "INSERT INTO adhesion (`nom`,`prenom`,`text`,`titre`,`numero`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($requete);
        $stmt->execute(array($nom, $prenom, $text, $age, $adr));
        //var_dump($stmt);
        //exit();

    }else{
        $msg= '<h1>votre numero existe déjà </h1>';
    }
    //id 	nom 	prenom 	text 	titre 	numero 	created 	

    }
} 
} 
else  
{  
 // header("location:logout.php");  

}
?>
<?=template_header('Create')?>

<?php
if(isset($_SESSION["username"]) == null){
    echo"<p style=' padding:0 5px;   background-color: red;  color:#fff;  text-align: center;'>S'il vous plait connetez-vous !<P>";
}else{ 
     echo "<h3 style=' padding:0 5px;  margin:0 auto;  background-color: green;  color:#fff;  text-align: center;'> Bienvenu - ".$_SESSION["username"]."</h3>";  
     echo "<br /><a style=' padding:10px 15px;   background-color: blue;  color:#000;  text-align: center;' href='logout.php'>Déconnexion</a>";  
}
?>

<div class="content update">
	<h2>Ajout adhesion</h2>
    <form action="" method="post">
        <label for="name">Nom</label>
        <input type="text" name="name" placeholder="" id="name" required>
        
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" placeholder="" id="pname" required>
        
        <label for="prenom">text</label>
        <textarea type="text" name="text" placeholder="" id="text"  style =' height: 50%; padding:10px;  width: 40%; ' required></textarea>
       
        <label for="age">Age</label>
        <input type="text" name="age" placeholder="" id="age" required>
        <label for="adherant">Numéro adhérent</label>
        <input type="number" name="adr" placeholder="" id="adr" required>
       <?php if(isset($_SESSION["username"]) == null):?>
   
        <input type="submit" onclick="ajout()" id='Connect'  value="Ajouter ">
        <?php else: ?> 
        <input type="submit" id='Connect' name="ajouter" value="Ajouter">

    <?php endif ?> 


    <?= $msg?>

    </form>

    <?php
          //1- recup data depuis adduser.php

         
    
        //2- connexion et insertion 
         // echo "Ajout reussi";
          // 3- Recup tous les  
          function adhesion() {
            $db = pdo_connect_mysql();
            $requete = 'SELECT * from adhesion';
            $rows = $db->query($requete);
            return $rows;
        }
        $users = adhesion()
        
              //print_r($users);
        

     ?>
         
         <div class="content read">
	<table>
        <thead>
            <tr>
                <td>Nom</td>
                <td>Prenom</td>
                <td>Text</td>
                <td>Age</td>
                <td>Numéro adhérent</td>
                <td>Options</td>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?=$user['nom']?></td>
                <td><?=$user['prenom']?></td>
                <td><?=$user['text']?></td>
                <td><?=$user['titre']?></td>
                <td><?=$user['numero']?></td> 
                <?php if(isset($_SESSION["username"]) == null):?>
                    <td class="actions">

                    <a href="" onclick="Connect()"id='Connect' class="black edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="" onclick="Connect()" id='Connect'  class="trash" ><i  class="fas fa-trash fa-xs"></i></a>
                    </td>

            <?php else: ?> 
                <td class="actions">

                    <a href="modifAdesion.php?id=<?=$user['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="modifAdesion.php?id=<?=$user['id']?>"   class="trash" ><i  class="fas fa-trash fa-xs"></i></a>
                    </td>

                <?php endif ?> 
              
            <?php endforeach; ?>
        </tbody>
            </form>

    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
