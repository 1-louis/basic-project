<?php
include 'functions.php';
// recuperation des paramètres 
$id=$_POST["id"];
$name=$_POST["nom"];
//echo $name;
$pname=$_POST["prenom"];

$age=$_POST["age"];
$adr=$_POST["adresse"];
//echo $pname;

// function updateAdr($id, $nom, $prenom, $text, $titre) {
// 	try {
// 		$db = pdo_connect_mysql();
// 		$requete = "UPDATE adhesion set 
// 					nom = '$nom',
// 					prenom = '$prenom',
// 					`age` = '$text',
// 					adresse = '$titre' 
// 					where id = '$id' ";
// 		$stmt = $db->query($requete);
// 	}
// 	catch(PDOException $e) {
// 		echo $sql . "<br>" . $e->getMessage();
// 	}
// }


updateUser($id,$name,$pname,$age,$adr);


//echo $age;

//echo $adr;

?>

<?=template_header('Valid Add User')?>

<div class="content update">
    Modification reussie
<a href="./createAdhesion.php">retour</a>


    
</div>

<?=template_footer()?>
