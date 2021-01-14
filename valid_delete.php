<?php
include 'functions.php';
// recuperation des paramètres 
$id=$_GET["id"];

//echo $adr;
deleteUser($id);

function msgSuprimer(){ 
  echo <<<EXO
  <div class="content deleteUser">
  <h2 >supression de l'utilisateur !</h2>
  <button >suppression reussie</button>
  </div>
EXO;
  }
?>

<?=template_header('Valid Add User delete')?>

    
<?php
if($id !== deleteUser($id)) {
    //var_dump(deleteUser($id));
    header("Location:adduser.php");
    exit();
  }
?> 
<?=template_footer()?>