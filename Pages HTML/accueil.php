<?php
	require_once '../vendor/autoload.php';
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Mixtory</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <!-- mobile specific info ... mobile specify windows size to 800/900 whereas device-width is less 
in general, resulting in small texte etc.- those meta correct this... -->
        <meta name="HandheldFriendly" content="true" />
        <meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" />
        <!-- end mobile specific info -->
        
        
    <link rel="stylesheet" type="text/css" href="./joli.css" />
	</head>
	<body>
		
		<div id="globale">	
			
			<header> <!-- balise html5 equivalant à <div id="header"> -->
				<button id="bouton">Horreur</button>			
				<button id="bouton1">Comédie</button>
				<button id="bouton2">Science-Fiction</button>
			</header>
			
			<?php 
					$textes = fopen('Textes.txt', 'a+');
					$monfichier = fopen('Donnees.txt', 'r+');
					$adresses = fopen('Adresses.txt', 'r+');
					$nbr_auteurs = fgets($monfichier);
			if(!isset($_POST['texte'])){ ?>
				<form method = "post" action = "accueil.php">
					<div id = "titre"><input type = "text" name = "titre" placeholder = "Votre titre"/></div>
					<div id = "texte"><textarea name = "texte" rows = "8" cols = "81" placeholder="Rentrez votre texte"></textarea></div>
					<div id = "nbr_ligne">Choissisez le nombre de co-auteurs supplémentaires : <input type = "text" name = "nbr_auteurs"/></div>
					<div id = "adresse-mail"><input type = "text" name = "email" placeholder = "Adresse Mail"/></div>
				<input type= "submit" value = "Go !"/>
				</form>
				<?php 
			} 
			else if($nbr_auteurs > 1 OR isset($_POST['nbr_auteurs'])){ 
				if(isset($_POST['nbr_auteurs'])){
					$new_title = $_POST['titre'].".txt";
					fseek($monfichier, 0);
					fputs($monfichier, $_POST['nbr_auteurs'] - 1);
					fseek($textes, 0, SEEK_END);
					fputs($textes, $_POST['texte']."\n"."\n"); 
					fseek($adresses, 0, SEEK_END);
					fputs($adresses, $_POST['email'].","); 
				}
				else{
					$nbr_auteurs--; 
					fseek($monfichier, 0);
					fputs($monfichier, $nbr_auteurs."\n");
					fseek($textes, 0, SEEK_END);
					fputs($textes, $_POST['texte']."\n"."\n"); 
					fseek($adresses, 0, SEEK_END);
					fputs($adresses, $_POST['email'].","); 
				}?>
					<div id = "pre-texte"><article><?php echo nl2br($_POST['texte']);?></article></div>
				<form method = "post" action = "accueil.php">
					<div id = "texte"><textarea name = "texte" rows = "8" cols = "81" placeholder="Rentrez 
votre texte"></textarea></div>
					<div id = "adresse-mail"><input type = "text" name = "email" placeholder = "Adresse 
Mail"/></div>
					<input type= "submit" value = "Go !"/>
				</form>
			<?php
			}
			else if($nbr_auteurs == 1){ ?><?php echo 'Attention vous êtes le dernier auteur !!'; 
					$nbr_auteurs--;
					fseek($monfichier, 0);
					fputs($monfichier, $nbr_auteurs."\n");
					fseek($textes, 0, SEEK_END);
					fputs($textes, $_POST['texte']."\n"."\n"); 
					fseek($adresses, 0, SEEK_END);
					fputs($adresses, $_POST['email'].","); 
			?>
					<div id = "pre-texte"><article><?php echo nl2br($_POST['texte']);?></article></div>
				<form method = "post" action = "accueil.php">
					<div id = "texte"><textarea name = "texte" rows = "8" cols = "81" placeholder="Rentrez 
votre texte"></textarea></div>
					<div id = "adresse-mail"><input type = "text" name = "email" placeholder = "Adresse 
Mail"/></div>
					<input type= "submit" value = "Go !"/>
				</form>
				<?php
			}
			else if($nbr_auteurs == 0){
				echo 'fini';
				fseek($textes, 0, SEEK_END);
				fputs($textes, $_POST['texte']."\n"."\n");  
				fseek($adresses, 0, SEEK_END);
				fputs($adresses, $_POST['email']);
				echo $new_title;
				rename("Textes.txt", $new_title); 				
				$adresse_mails = explode(",", file_get_contents('Adresses.txt'));
				//$ancien_texte = file_get_contents($textes);
				$transport = Swift_SmtpTransport::newInstance()
					->setHost('smtp.gmail.com')
					->setPort(587)
					->setEncryption('TLS')
					->setUsername('mixtorythestory@gmail.com')
					->setPassword('Poudlard1')
				;
				$mailer = Swift_Mailer::newInstance($transport);
				// Create the message
				$message = Swift_Message::newInstance();

				// Give the message a subject
				$message->setSubject('Votre cadavre exquis !');

				// Set the From address with an associative array
				$message->setFrom(array('mixtorythestory@gmail.com' => 'Mixtory'));

				// Set the To addresses with an associative array
				print_r($adresse_mails);
				
				$message->setTo($adresse_mails);

				// Give it a body
				$message->setBody('Merci d\'avoir participé à Mixtory ! Coeur sur vous <3');

				// And optionally an alternative body
				//$message->addPart('<q>Here is the message itself</q>', 'text/html');
				// Optionally add any attachments
				$message->attach(Swift_Attachment::fromPath($new_title));
				$result = $mailer->send($message);
			}
			else{}
			fclose($textes);
			fclose($adresses);
			fclose($monfichier);
			?>

			<div id = "ex-story">Voici les anciennes histoires
			</div> <!--Bouton-->
			<footer>
								Nous contacter : <a href="mailto:g.grammont@hotmail.fr">Mail</a>
			</footer>
		</div> <!-- fin id="globale"-->
	</body>
</html>
