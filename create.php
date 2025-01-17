<?php
include_once 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nom = empty($_POST['nom']) ? $_POST['nom'] : '';
    $age = empty($_POST['age']) ? $_POST['age'] : '';
    $phone = empty($_POST['phone']) ? $_POST['phone'] : '';
    $title = empty($_POST['title']) ? $_POST['title'] : '';
    $created = empty($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare("INSERT INTO `utilisateurs` ( `id`, `nom`, `age`, `phone`, `title`, `created` ) VALUES (`null`, `$nom`, `$age`,`$phone`,`$title`, `$created`) ");
    $stmt->execute([$id, $nom, $age, $phone, $title, $created]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Nom</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="nom" placeholder="John Doe" id="name">
        <label for="age">Age</label>
        <label for="phone">Phone</label>
        <input type="number" name="age" placeholder="15" id="age">
        <input type="text" name="phone" placeholder="2025550143" id="phone">
        <label for="title">Title</label>
        <label for="created">Created</label>
        <input type="text" name="title" placeholder="Employee" id="title">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p class="text-success"><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
