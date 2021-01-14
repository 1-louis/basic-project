<?php
include_once 'functions.php';
// recuperation des paramètres ^

try {
	$id=$_POST["id"];

	$name= $_POST["nom"];
	$pname=$_POST["prenom"];
	$text= $_POST['text'];
	$titre= $_POST['titre'];
	$db = pdo_connect_mysql();
	$requete = "UPDATE `adhesion` SET `prenom` = '$pname', `text` = '$text', `titre` = '$titre', `nom` = '$name' WHERE `adhesion`.`id` = $id;  ";
	$stmt = $db->query($requete);
	//$statement = $connect->prepare($requete);  
	//$statement->execute( [ $id ]);
}
catch(PDOException $e) {
	echo $sql . "<br>" . $e->getMessage();
}
// var_dump($id);

// echo" $name. <br/>";

// echo "$pname .<br/>";


// echo "$text .<br/>";

// echo "$titre .<br/>";

?>

<?=template_header('Valid Add User')?>

<?php if($id == null):?>
	<h3 style='color:red;'> valeur non trouver </h3> 

<?php else:?>
<h3 style='color:green;'> Modification reussie </h3> 

<?php endif ?>

<div class="content update">
<button type="submit">
<a href="./createAdhesion.php">Retour</a>
</button>
    
</div>

<?=template_footer()?>
