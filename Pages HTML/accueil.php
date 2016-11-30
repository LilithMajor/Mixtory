<!DOCTYPE HTML>
<html>
	<head>
		<title>Mixtory</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <!-- mobile specific info ... mobile specify windows size to 800/900 whereas device-width is less in general, resulting in small texte etc.- those meta correct this... -->
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
			$nbr_lignes_restantes = $POST_['nbr_ligne'] - $POST_['text'][size];
			if (isset($_POST['texte'])){ ?>
				<form method = "post" action = "accueil.php">
					<div id = "texte"><textarea name = "texte">Rentrez votre texte</textarea></div>
					<div id = "nbr_ligne">Choissisez le nombre de lignes : <input type = "text" name = "nbr_lignes"/></div>
					<div id = "adresse-mail"><input type = "text" name = "email" value = "Adresse Mail"/></div>
				<input type= "submit" value = "Go !"/>
				</form>
				<?php 
			}
			else{ ?>
				<div id = "pre-texte"><article><?php echo $POST_['texte']?></article></div>
				<div id = "nbr_ligne_restante">Il reste <?php echo $nbr_ligne_restantes?> lignes !</div>
			<?php
			}
			?>

			<div id = "ex-story">Voici les anciennes histoires
			</div> <!--Bouton-->
			
			<footer>
								Nous contacter : <a href="mailto:g.grammont@hotmail.fr">Mail</a>
			</footer>
		</div> <!-- fin id="globale"-->
	</body>
</html>