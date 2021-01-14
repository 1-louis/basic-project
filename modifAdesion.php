<?php
include 'functions.php';
//$pdo = pdo_connect_mysql();
//$msg = '';

// 1- recuperation du l'id
 $id=$_GET["id"];
 //echo $id;
 // 2- selection l'enregistrement
   //print_r($user_selected);
   // 3- L'affichage sur lapage

  // var_dump($user_selected['id']);

    function adhesionUser($id) {
        $con = pdo_connect_mysql();
        $requete = "SELECT * from adhesion where id = '$id' ";
        $stmt = $con->query($requete);
        $row = $stmt->fetchAll();
        if (!empty($row)) {
            return $row[0];
        }
        
    }

    $user_selected = adhesionUser($id);


//echo $user_selected['id'];


?>

<?=template_header('Read')?>
<div class="content read">
<h2>Modification de l'utilisateur #<?=$user_selected['id']?></h2>
<?php
if($user_selected['nom'] == null){
    header("location: createAdhesion.php");  

    echo'pas de id donne moi une id';
}
?>
    <form action="validAdhesion.php?id=<?=$user_selected['id']?>" method="post">
        
        <input type="hidden" name="id" placeholder="" value="<?=$user_selected['id']?>" id="id">
        <br>
        <label for="nom">Nom</label>
        <input type="text" name="nom" placeholder="" value="<?=$user_selected['nom']?>" id="nom">
        <br>
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" placeholder="" value="<?=$user_selected['prenom']?>" id="prenom">
        <br>
        <label for="text">text</label>
       <input type="text" name="text" placeholder="" value="<?=$user_selected['text']?>" id="age">
       <br>
        <label for="titre">titre</label>
         <input type="text" name="titre" placeholder="" value="<?=$user_selected['titre']?>" id="adr">
    <br>
   
        <input type="submit" value="Modifier">

    </form>
    <br>

    <button type="submit" id='sup'> <a href="#" onclick="popbox()"  >supression </a></button>
    <!-- "<a href="suprimeAdhesion.php?id=<=//$user_selected['id']?>" onclick="popbox()"  >supression 2 </a>"; -->

</div>
<?=template_footer()?>
<script>

function myOpen() {
  let myWindow =   window.open("./suprimeAdhesion.php?id=<?=$user_selected['id']?>", "MsgWindow", "width=800,height=500");
//myWindow.document.write("<a href='createAdhesion.php'>VOTRE VALEUR A BEIN ETE SUPPRIMER</a>");
}
function popbox() {
var txt;
if (confirm("êtes-vous sûr de vouloir vous  ces valeurs !")) {
  txt =  myOpen();
  var text ="<a style='color:red;' href='./createAdhesion.php' >   Retour </a> ";

} else {
  text = " <a href='./createAdhesion.php' > Retour</a>";

}
document.getElementById("sup").innerHTML = text;


}
</script>