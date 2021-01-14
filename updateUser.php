<?php
include 'functions.php';
//$pdo = pdo_connect_mysql();
//$msg = '';

// 1- recuperation du l'id
 $id=$_GET["id"];
 //echo $id;
 // 2- selection l'enregistrement
  $user_selected = readUser($id);
   //print_r($user_selected);
   // 3- L'affichage sur lapage

?>

<?=template_header('Read')?>
<div class="content read">
<h2>Modification de l'utilisateur #<?=$user_selected['id']?></h2>

    <form action="valid_updateUser.php?id=<?=$user_selected['id']?>" method="post">
        
        <input type="hidden" name="id" placeholder="" value="<?=$user_selected['id']?>" id="id">
        <br>
        <label for="nom">Nom</label>
        <input type="text" name="nom" placeholder="" value="<?=$user_selected['nom']?>" id="nom">
        <br>
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" placeholder="" value="<?=$user_selected['prenom']?>" id="prenom">
        <br>
        <label for="age">Age</label>
       <input type="text" name="age" placeholder="" value="<?=$user_selected['age']?>" id="age">
       <br>
        <label for="Adresse">Adresse</label>
         <input type="text" name="adresse" placeholder="" value="<?=$user_selected['adresse']?>" id="adr">
    <br>
        <input type="submit" value="Modifier">


    </form>
    <a href="valid_delete.php?id=<?=$user_selected['id']?>"  >supression </a>


</div>
<?=template_footer()?>
