<?php
include 'functions.php';
// recuperation des paramètres 
$id=$_GET["id"];
//$user_selected['id'];
//echo $id;
//deleteUser($id);
try {
  
    $db = pdo_connect_mysql();
    $requete = "DELETE from adhesion where id = '$id' ";
    $stmt = $db->query($requete);


}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
function msgSuprimer(){ 
  echo <<<EXO

  <div class="content deleteUser">
  <h2 >supression de l'utilisateur !</h2>
  <form action="" method="post">

  <a href="" name='suppression'  >Suppression </a>
  </form>

  </div>
EXO;
  }

?>

<?=template_header('Valid Add User delete')?>


<a href="./createAdhesion.php">Retour</a>

    
<?php
if(isset($id) == false ) {
  var_dump(deleteUser($id));
  header("location: createAdhesion.php");  
  msgSuprimer();

}

?> 
<?=template_footer()?>