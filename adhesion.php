<?php
include './functions.php';
//$db = Database::connect();
// Connect to MySQL database
$db = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page

$records_per_page = 5;
if (isset($_GET['search'])) {
	// Custom search, if the user entered text in the search box and pressed enter...
	// The below query will search in every column until it's fount a match, feel free to remove a field if you don't want to search it.
	$stmt = $db->prepare('SELECT * FROM adhesion 
						   WHERE id LIKE :search_query
							  OR `nom` LIKE :search_query
							  OR `text` LIKE :search_query
							  OR titre LIKE :search_query
							  OR created LIKE :search_query
							ORDER BY id
							LIMIT :current_page, :record_per_page');
	// The percentages are added each side of the search query so we can find a match in the column value.
	$stmt->bindValue(':search_query', '%' . $_GET['search'] . '%');
	Database::disconnect();

} else {
    $db = pdo_connect_mysql();
	// Prepare the SQL statement and get records from our adhesion table, LIMIT will determine the page
	$stmt = $db->prepare('SELECT * FROM adhesion ORDER BY id LIMIT :current_page, :record_per_page');
}
// The above queries are ordered by id, you can change this if you want to order by another column, such as "name"
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$adhran = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of adhesion, this is so we can determine whether there should be a next and previous button
if (isset($_GET['search'])) {
	$stmt = $db->prepare('SELECT COUNT(*) FROM adhesion AND categories

						   WHERE id LIKE :search_query
							  OR nom LIKE :search_query
							  OR `text` LIKE :search_query
							  OR created LIKE :search_query
							 OR titre LIKE :search_query');
	
	$stmt->bindValue(':search_query', '%' . $_GET['search'] . '%');
	$stmt->execute();
	$num_contacts = $stmt->fetchColumn();
	Database::disconnect();

} else {
	$num_contacts = $db->query('SELECT COUNT(*) FROM adhesion')->fetchColumn();
}
?>

<?=template_header('Read')?>
<?php
if(isset($_SESSION["username"]) == null){
    echo'il faut vous connectez';
}else{ 
     echo '<h3> Welcome - '.$_SESSION["username"].'</h3>';  
     echo '<br /><br /><a href="logout.php">Logout</a>';  
}
?>
<div class="read">
	<div class="top-read container">
	<h2>Read adhesion</h2>
		<a href="./createAdhesion.php " class='col-md-3'>Create adhesion</a>
		<form action="read.php" method="get" class="seach col-md-9">
			<input type="text" name="search" placeholder="Search..." value="<?=isset($_GET['search']) ? htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
		</form>
	</div>
	<table class='container'>
        <thead class='thead-read'> 
            <tr>
                <td>#</td>
                <td>Name</td>
				<td>text</td>

                <td>Titre</td>
                <td>date</td>
                <td>Created</td>
            </tr>
        </thead>
        <tbody>
		
		<?php foreach ($adhran as $adhesion): ?>
				
            <tr>
                <td><?=$adhesion['id']?></td>
                <td><?=$adhesion['nom']?></td>
                <td><?=$adhesion['text']?></td>
				<?php
					if( $adhesion['titre'] ){ 
						$num= (int) $adhesion['titre'];
						$statement = $db->query('SELECT * FROM `adhesion` WHERE adhesion.id  ');
						$categories = $statement->fetchAll();
						foreach ($categories as $category) {
							if($category['id'] == $num ):?>
							 <td><?=$category['name'];?></td>
							 
						<?php endif?>
				<?php
						}
					}
				
				?>
				<td><?=$adhesion['created']?></td>

                <td class="actions">	
                    	<a href="./update.php?id=<?=$adhesion['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    	<a href="./delete.php?id=<?=$adhesion['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
			</tr>
	
			<?php endforeach; ?>
			
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
			<i class="fas fa-angle-double-left fa-sm"></i>
		</a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
			<i class="fas fa-angle-double-right fa-sm"></i>
		</a>
		<?php endif; ?>
	</div>

</div>

<?=template_footer()?>
