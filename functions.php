<?php
// fonction de connexion 
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
	$DATABASE_NAME = 'phpcrud';
	
    try {
    	return $db = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

	} catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
		<script src="./script.js"></script>

	</head>
	<body>
    <nav class="navtop">
        <div class="container">
            <div class='row'>
                <div class="col-md-6">
                    <h1 >Website Title</h1>
                </div>
                <div class="center col-md-6">
                    <a href="index.php"><i class="fas fa-home"></i>Home</a>
                    <a href="inscription.php"><i class="fas fa-address-book"></i>Inscription</a>
					<a href="read.php"><i class="fas fa-address-book"></i>Contacts</a>
					<a href="createAdhesion.php"><i class="fas fa-home"></i>  Adherent</a>
					<a href="connexion.php"><i class="fas fa-home"></i> Connexion</a>

                </div>
            </div>
        </div>
    </nav>
EOT;
}

function header_add($title) {
	echo <<<EOT
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>$title</title>
			<link href="style.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
			<script src="script.js"></script>
	
		</head>
		<body>
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="index.php"><i class="fas fa-home"></i>Home</a>
		
				<a href="read.php"><i class="fas fa-address-book"></i>Contacts</a>
				<a href="createAdhesion.php"><i class="fas fa-home"></i>  Adherent</a>
				<a href="logout.php"><i class="fas fa-home"></i> Deconnexion</a>
				
			</div>
		</nav>
	EOT;
	}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}

// CRUD functions

// récupere tous les users
function getAllUsers() {
	$con = pdo_connect_mysql();
	$requete = 'SELECT * from utilisateurs';
	$rows = $con->query($requete);
	return $rows;
}

// creer un user
function createUser($nom, $pname , $age, $adresse) {
	try {
		$name=isset($_POST["name"]);
		$pname=isset($_POST["pname"]);	
		$age=isset($_POST["age"]);
		$adr=isset($_POST["adr"]);
		$con = pdo_connect_mysql();
		//echo $con;
		$sql = "INSERT INTO utilisateurs (nom, prenom, age, adresse) 
				VALUES ('$name', '$pname', '$age' ,'$adr')";
		$con->exec($sql);
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

//recupere un user
function readUser($id) {
	$con = pdo_connect_mysql();
	$requete = "SELECT * from utilisateurs where id = '$id' ";
	$stmt = $con->query($requete);
	$row = $stmt->fetchAll();
	if (!empty($row)) {
		return $row[0];
	}
}

//met à jour le user
function updateUser($id, $nom, $prenom, $age, $adresse) {
	try {
	
		$con = pdo_connect_mysql();
		$requete = "UPDATE utilisateurs set 
					nom = '$nom',
					prenom = '$prenom',
					age = '$age',
					adresse = '$adresse' 
					where id = '$id' ";
		$stmt = $con->query($requete);
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}

// suprime un user
function deleteUser($id) {
	try {
		$con = pdo_connect_mysql();
		$requete = "DELETE from utilisateurs where id = '$id' ";
		$stmt = $con->query($requete);
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}


// suprime un user
function authentification($login,$mdp) {
	try {
 
		session_start();  // démarrage d'une session

		// on vérifie que les données du formulaire sont présentes
		if (isset($_POST['login']) && isset($_POST['mdp'])) {
			
			$bdd = pdo_connect_mysql();
			// cette requête permet de récupérer l'utilisateur depuis la BD
			$requete = "SELECT * FROM compte WHERE login=? AND pass=?";

			//$requete = "SELECT * FROM utilis WHERE LoginUtil=? AND PassUtil=?";
			$resultat = $bdd->prepare($requete);
			//$login = $_POST['login'];
			//$mdp = $_POST['mdp'];
			$resultat->execute(array($login, $mdp));
		
			if ($resultat->rowCount() == 1) {
				// l'utilisateur existe dans la table
				// on ajoute ses infos en tant que variables de session
				$_SESSION['login'] = $login;
				$_SESSION['mdp'] = $mdp;
				// cette variable indique que l'authentification a réussi
				$authOK = true;
                $_SESSION['authOk'] = true;
				header('Location: read.php');
exit;

				
			}
		}
		
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
}



?>


