<?php
include_once 'functions.php';
//$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    ///$id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $login = $_POST['login'];
	echo $login;
	$pass = $_POST['mdp'];
	echo $pass;
	authentification($login,$pass);
    
    // Output message
    //$msg = 'Created Successfully!';
}

?>

<?=template_header('Create')?>


<div class="content update">


   
</div>

<?=template_footer()?>
