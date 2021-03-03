<?php require_once 'config.php';?>


<?php

// On vérifie si la variable existe et sinon elle vaut NULL
$recup_pays = $_POST['pays'] ? $_POST['pays'] : NULL;
$recup_region = $_POST['region'] ? $_POST['region'] : NULL;
$recup_ville = $_POST['ville'] ? $_POST['ville'] : NULL;
$recup_code_postal = $_POST['code_postal'] ? $_POST['code_postal'] : NULL;

$req = $base->prepare(' SELECT *  
         FROM team
         WHERE 
         pays = :pays 
         OR
         region = :region
         OR
         ville = :ville
         OR
         code_postal = :code_postal
         ORDER BY nom ')  ;

$req->execute(array(
                     ':pays'=> $recup_pays,
                     ':region'=> $recup_region,
                     ':ville'=> $recup_ville,
                     ':code_postal'=> $recup_code_postal,
));


while($row = $req->fetch()){
    $data = $row['nom'].$data['prenom']."<br />\n";
    echo $data;

}
$req->closeCursor();      
?>


<!DOCTYPE html>
<!-- saved from url=(0145)https://landing.eovi-mcd.fr/deces/?origine=2go&gclid=Cj0KCQiAvc_xBRCYARIsAC5QT9n1n_By2QMU2dpksR2SJ2bdgw1w5q_rNsxFe4XybO4hiYjrMrK05nQaAvAxEALw_wcB -->
<html lang="fr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title>{% block title %}Waloude Prévoyance Décès{% endblock %}</title>
	<link rel="stylesheet" href="../fichiers/main.min.css">
	<link rel="stylesheet" href="../fichiers/styles.css">
	<link rel="stylesheet" href="../fichiers/jquery-ui.css">
	<link href="./fonts/css/all.css" rel="stylesheet"> <!--load all styles -->
	<link rel="Shortcut icon" type="image/x-icon" href="../fichiers/favicon.png">
    <script type="text/javascript" async="" src="../fichiers/hotjar-1054370.js"></script>
    <script type="text/javascript" async="" src="../fichiers/analytics.js"></script>
    <script async="" src="../fichiers/gtm.js"></script>
    <script src="../fichiers/jquery-1.12.4.js"></script>
    <script src="../fichiers/jquery-ui.js"></script>
	<script src="../fichiers/app.min.js" async="" defer=""></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style type="text/css">
.ui-front{z-index:1000 !important;}
</style>


<script>
$(function() {
  $(document).ready( function() {
	// désactive le champs Ville
	$('#city').attr('disabled','disabled');
  });
  $('#city').focus( function() {
    // affecte l'autocompilation au champs Ville
	$(this).autocomplete('search', '');
  });
  // OnKeyDown Function - click
  $('#zipcode').keyup(function() {
    // valeur du champs Code Postal
    var zip_in = $(this);
    var zip_box = $('#zipcode');
    // erreur : si le code postal est supérieur à 5 caractères 
    if (zip_in.val().length < 5)
    {
      zip_box.addClass('error').removeClass('success');
    }
	// il faut taper 5 caractères pour afficher l'autocomplétion
    else if (zip_in.val().length == 5)
    {
      // active le champs Ville
	  $('#city').removeAttr('disabled');
	  $('#city').attr('required','required');
      // Création de la requette Code Postal
      $.ajax({ url: '../inc/zipcode/codePostalVille.php', cache: false,
        dataType: 'json',
        data: { CPostal: zip_in.val() },
		type: 'POST',
        success: function(result, success) {
		  // créé la liste des ville
		  suggestions = [];
          for (ii in result['localites'])
		  {
            suggestions.push(result['localites'][ii]['localite']);
          }
          $('#city').autocomplete({
		    source:suggestions,
			//delay:1,
			disabled:false,
			minLength:0
		  });
          if (suggestions.length > 0){
            $('#city').placeholder = suggestions[0];
          }
          zip_box.addClass('success').removeClass('error');
        },
		// s'il n'y a pas de ville trouvé
        error: function(result, success) {
          zip_box.removeClass('success').addClass('error');
        }
      });
    }
  });
});
</script>

<!-- Google Tag Manager -->

<!-- End Google Tag Manager -->
<link rel="stylesheet" type="text/css" href="../fichiers/cookieLevel.css">	
<style type="text/css">
@font-face {
  font-weight: 400;
  font-style:  normal;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-Regular.woff2') format('woff2');
}
@font-face {
  font-weight: 400;
  font-style:  italic;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-Italic.woff2') format('woff2');
}

@font-face {
  font-weight: 500;
  font-style:  normal;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-Medium.woff2') format('woff2');
}
@font-face {
  font-weight: 500;
  font-style:  italic;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-MediumItalic.woff2') format('woff2');
}

@font-face {
  font-weight: 700;
  font-style:  normal;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-Bold.woff2') format('woff2');
}
@font-face {
  font-weight: 700;
  font-style:  italic;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-BoldItalic.woff2') format('woff2');
}

@font-face {
  font-weight: 900;
  font-style:  normal;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-Black.woff2') format('woff2');
}
@font-face {
  font-weight: 900;
  font-style:  italic;
  font-family: 'Inter-Loom';

  src: url('https://cdn.loom.com/assets/fonts/inter/Inter-UI-BlackItalic.woff2') format('woff2');
}</style><script async="" src="../fichiers/modules.9ad849c74ae56ab50f63.js" charset="utf-8"></script><style type="text/css">iframe#_hjRemoteVarsFrame {display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;}</style></head>
<body class="lp_deces js-focus-visible" style="" cz-shortcut-listen="true">

	<!-- Google Tag Manager (noscript) -->

	<!-- End Google Tag Manager (noscript) -->

	<header>
		<div class="container">
    <div class="columns">
    		<div class="column is-four-fifths">
			<a href="{{ path('accueil')}}"><img class="logo-eovi" src="../fichiers/logo.png" width="300px"></a>
		</div>
    <div class="column">
    {% if not app.user %}
			<button><a href="{{ path('app_login')}}">Espace personnel</a></button>
      {% else %}
      <button style="background-color: #00d1b2; border: #00d1b2 solid 2px;"><a href="{{ path('moncompte')}}">Espace personnel</a><br><span style="color:white">Vous êtes connecté(e)</span></button>
      <br><a href="{{ path('app_logout')}}" style="color:#00d1b2">Se déconnecter</a>
      {% endif %}
		</div>

    </div>
		<nav class="navbar is-center" role="navigation" aria-label="main navigation">
      <div class="navbar-menu is-active">
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
      <div class="navbar-start">
      <a class="navbar-item" href="#">Accueil</a></a>
				<a class="navbar-item" href="{{ path('waloude')}}">Waloude</a></a>
				<a class="navbar-item" href="#">Prévoyance</a></a>
      </div>
      <div class="navbar-end">  
				<a class="navbar-item" href="{{ path('faq_index')}}">FAQ</a></li>
				<a class="navbar-item" href="#">Contactez-nous</a></a>
      </div>
		</div>
    </nav>
		<div class="container">
    <div class="columns is-mobile">
      <div class="column is-11 is-offset-1">
		<h2 class="texte_defile">Avec Waloude ,mettez à l’abri ceux que vous aimez des conséquences financières d’un décès</h2>
	</div>
  </div>
  </div>
	</header>

      <!-- debut du corps de la page -->
      <form  method="post" action="search_engine.php">

<label>Pays</label>
<select name="pays">
		    <?php
$req_pays = $base->query('SELECT DISTINCT  pays FROM team');

	//echo ('<option value="Nom" selected=""> Selectionnez un patient</option>');

 while($donnees1 = $req_pays->fetch()) {


       echo ('<option value="'.$donnees1['id'].'">'.$donnees1['pays'].'</option>');
      }
$req_pays->closeCursor();
?>

</select>

<label>Région</label>
<select name="pays">
		    <?php
$req_region = $base->query('SELECT DISTINCT  region FROM team');

	//echo ('<option value="Nom" selected=""> Selectionnez un patient</option>');

 while($donnees1 = $req_region->fetch()) {


       echo ('<option value="'.$donnees1['id'].'">'.$donnees1['region'].'</option>');
      }
$req_pays->closeCursor();
?>

</select>

<label>Ville</label>
<select name="ville">
		    <?php
$req_ville = $base->query('SELECT DISTINCT  ville FROM team');

	//echo ('<option value="Nom" selected=""> Selectionnez un patient</option>');

 while($donnees1 = $req_ville->fetch()) {


       echo ('<option value="'.$donnees1['id'].'">'.$donnees1['ville'].'</option>');
      }
$req_ville->closeCursor();
?>

</select>

<label>Code postal</label>
<select name="code_postal">
		    <?php
$req_code_postal = $base->query('SELECT DISTINCT  code_postal FROM team');

	//echo ('<option value="Nom" selected=""> Selectionnez un patient</option>');

 while($donnees1 = $req_code_postal->fetch()) {


       echo ('<option value="'.$donnees1['id'].'">'.$donnees1['code_postal'].'</option>');
      }
$req_code_postal->closeCursor();
?>

</select>

<input type="submit" value="Envoyer" />
</form>
<!--fin de la page -->


	<footer>
		<div class="container">
			<div class="columns">
				<div class="column is-5">Waloude assurance décès. 2020 Tous droits réservés</div>
				<div class="column is-7 has-text-right"><a href="{{ path('accueil">Mentions légales</a> | <a href="{{ path('accueil">Réglements et statuts</a> | <a href="{{ path('politique-de-confidentialite" target="_blank">Protection des données</a> | <a onclick="openCookieLevelPopIn()" style="cursor:pointer;">Gestion des cookies</a></div>
			</div>
		</div>

		<div class="container">
				<div class="column is-12 has-text-right">
					<span>Suivez-nous sur:</span>
					<a href="https://symfony.com/"><i class="fab fa-facebook"></i></a>
					<a href="https://symfony.com/"><i class="fab fa-twitter"></i></i></a>
					<a href="https://symfony.com/"><i class="fab fa-linkedin"></i></a>
					<a href="https://symfony.com/"><i class="fab fa-youtube"></i></a>
				</div>
			</div>
		</div>
	</footer>

<!-- Div #1 -->
        <div id="popinrgpd">
            <div id="popinrgpdtitle"></div>
            <p id="popinrgpdfirstp"></p>
            <p id="popinrgpdsecondp"></p>
            <!--hr-->
            <div id="bgwrapper">
                <div id="level3" class="level">
                    <div id="level3h2" class="headerlevel"></div>
                    <div class="corelevel">
                        <ul>
                            <li id="levelthreefirstli"></li>
                            <li id="levelthreesecondli"></li>
                            <li id="levelthreethirdli"></li>
                        </ul>
                        <div onclick="setCookieLevel(&#39;level3&#39;);closeCookieLevelPopIn();window.location.reload();" class="choisirlevel"></div>
                    </div>
                </div>
                <div id="level2" class="level">
                    <div id="level2h2" class="headerlevel"></div>
                    <div class="corelevel">
                        <ul>
                            <li id="leveltwofirstli"></li>
                            <li id="leveltwosecondli"></li>
                            <li id="leveltwothirdli"></li>
                        </ul>   
                        <div onclick="setCookieLevel(&#39;level2&#39;);closeCookieLevelPopIn();window.location.reload();" class="choisirlevel"></div>
                    </div>
                </div>
                <div id="level1" class="level">
                    <div id="level1h2" class="headerlevel"></div>
                    <div class="corelevel">
                        <ul>
                            <li id="levelonefirstli"></li>
                            <li id="levelonesecondli"></li>
                            <li id="levelonethirdli"></li>
                        </ul>
                        <div onclick="setCookieLevel(&#39;level1&#39;);closeCookieLevelPopIn();window.location.reload();" class="choisirlevel"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <!-- Div #2 -->
        <div onclick="closeCookieLevelPopIn();" id="greybg"></div>

        <!-- Div #3 -->
        <div id="bandeaurgpd" style="display: none;">
            <p>Ce site web utilise des cookies afin d'optimiser l'expérience utilisateur. En naviguant sur le site, vous acceptez l'usage de ces cookies.</p>
            <div onclick="setCookieLevel(&#39;level3&#39;);closeCookieLevelBand();dataLayer.push({&#39;event&#39;:&#39;level3&#39;});" class="boutonrgpd">Accepter</div>
            <div onclick="closeCookieLevelBand();openCookieLevelPopIn()" class="lienrgpd">En savoir plus</div>
            <div onclick="closeCookieLevelBand()" id="croixrgpd" class="boutonrgpd">X</div>
        </div>  <script type="text/javascript" src="../fichiers/cookieLevel.js"></script>


<script type="text/javascript" id="">if(google_tag_manager["GTM-KH6DFB6"].macro(3).match("utm_campaign\x3dpack.senior")){var cname="pack-senior-campaign",cvalue="true",d=new Date;d.setTime(d.getTime()+864E5);var expires="expires\x3d"+d.toUTCString();document.cookie=cname+"\x3d"+cvalue+";"+expires+";path\x3d/"};</script>
<script type="text/javascript" id="" src="../fichiers/ld.js"></script>
<script type="text/javascript" id="">window.criteo_q=window.criteo_q||[];var deviceType=/iPad/.test(navigator.userAgent)?"t":/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent)?"m":"d";window.criteo_q.push({event:"setAccount",account:4932},{event:"setSiteType",type:deviceType},{event:"viewItem",item:"1"},{event:"viewBasket",item:[{id:"1",price:1,quantity:1}]});</script> 
<iframe name="_hjRemoteVarsFrame" title="_hjRemoteVarsFrame" id="_hjRemoteVarsFrame" src="../fichiers/box-469cf41adb11dc78be68c1ae7f9457a4.html" style="display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;"></iframe><div id="criteo-tags-div" style="display: none;"></div><span style="border-radius: 3px !important; text-indent: 20px !important; width: auto !important; padding: 0px 4px 0px 0px !important; text-align: center !important; font: bold 11px / 20px &quot;Helvetica Neue&quot;, Helvetica, sans-serif !important; color: rgb(255, 255, 255) !important; background: url(&quot;data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxIj48L3BhdGg+PHBhdGggZD0iTTE0LjczMywxLjY4NiBDNy41MTYsMS42ODYgMS42NjUsNy40OTUgMS42NjUsMTQuNjYyIEMxLjY2NSwyMC4xNTkgNS4xMDksMjQuODU0IDkuOTcsMjYuNzQ0IEM5Ljg1NiwyNS43MTggOS43NTMsMjQuMTQzIDEwLjAxNiwyMy4wMjIgQzEwLjI1MywyMi4wMSAxMS41NDgsMTYuNTcyIDExLjU0OCwxNi41NzIgQzExLjU0OCwxNi41NzIgMTEuMTU3LDE1Ljc5NSAxMS4xNTcsMTQuNjQ2IEMxMS4xNTcsMTIuODQyIDEyLjIxMSwxMS40OTUgMTMuNTIyLDExLjQ5NSBDMTQuNjM3LDExLjQ5NSAxNS4xNzUsMTIuMzI2IDE1LjE3NSwxMy4zMjMgQzE1LjE3NSwxNC40MzYgMTQuNDYyLDE2LjEgMTQuMDkzLDE3LjY0MyBDMTMuNzg1LDE4LjkzNSAxNC43NDUsMTkuOTg4IDE2LjAyOCwxOS45ODggQzE4LjM1MSwxOS45ODggMjAuMTM2LDE3LjU1NiAyMC4xMzYsMTQuMDQ2IEMyMC4xMzYsMTAuOTM5IDE3Ljg4OCw4Ljc2NyAxNC42NzgsOC43NjcgQzEwLjk1OSw4Ljc2NyA4Ljc3NywxMS41MzYgOC43NzcsMTQuMzk4IEM4Ljc3NywxNS41MTMgOS4yMSwxNi43MDkgOS43NDksMTcuMzU5IEM5Ljg1NiwxNy40ODggOS44NzIsMTcuNiA5Ljg0LDE3LjczMSBDOS43NDEsMTguMTQxIDkuNTIsMTkuMDIzIDkuNDc3LDE5LjIwMyBDOS40MiwxOS40NCA5LjI4OCwxOS40OTEgOS4wNCwxOS4zNzYgQzcuNDA4LDE4LjYyMiA2LjM4NywxNi4yNTIgNi4zODcsMTQuMzQ5IEM2LjM4NywxMC4yNTYgOS4zODMsNi40OTcgMTUuMDIyLDYuNDk3IEMxOS41NTUsNi40OTcgMjMuMDc4LDkuNzA1IDIzLjA3OCwxMy45OTEgQzIzLjA3OCwxOC40NjMgMjAuMjM5LDIyLjA2MiAxNi4yOTcsMjIuMDYyIEMxNC45NzMsMjIuMDYyIDEzLjcyOCwyMS4zNzkgMTMuMzAyLDIwLjU3MiBDMTMuMzAyLDIwLjU3MiAxMi42NDcsMjMuMDUgMTIuNDg4LDIzLjY1NyBDMTIuMTkzLDI0Ljc4NCAxMS4zOTYsMjYuMTk2IDEwLjg2MywyNy4wNTggQzEyLjA4NiwyNy40MzQgMTMuMzg2LDI3LjYzNyAxNC43MzMsMjcuNjM3IEMyMS45NSwyNy42MzcgMjcuODAxLDIxLjgyOCAyNy44MDEsMTQuNjYyIEMyNy44MDEsNy40OTUgMjEuOTUsMS42ODYgMTQuNzMzLDEuNjg2IiBmaWxsPSIjZTYwMDIzIj48L3BhdGg+PC9nPjwvc3ZnPg==&quot;) 3px 50% / 14px 14px no-repeat rgb(230, 0, 35) !important; position: absolute !important; opacity: 1 !important; z-index: 8675309 !important; display: none; cursor: pointer !important; border: none !important; -webkit-font-smoothing: antialiased !important; top: 1026.78px; left: 1131.31px;">Enregistrer</span><span style="border-radius: 12px; width: 24px !important; height: 24px !important; background: url(&quot;data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pjxzdmcgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDI0IDI0IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxkZWZzPjxtYXNrIGlkPSJtIj48cmVjdCBmaWxsPSIjZmZmIiB4PSIwIiB5PSIwIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHJ4PSI2IiByeT0iNiIvPjxyZWN0IGZpbGw9IiMwMDAiIHg9IjUiIHk9IjUiIHdpZHRoPSIxNCIgaGVpZ2h0PSIxNCIgcng9IjEiIHJ5PSIxIi8+PHJlY3QgZmlsbD0iIzAwMCIgeD0iMTAiIHk9IjAiIHdpZHRoPSI0IiBoZWlnaHQ9IjI0Ii8+PHJlY3QgZmlsbD0iIzAwMCIgeD0iMCIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSI0Ii8+PC9tYXNrPjwvZGVmcz48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIGZpbGw9IiNmZmYiIG1hc2s9InVybCgjbSkiLz48L3N2Zz4=&quot;) 50% 50% / 14px 14px no-repeat rgba(0, 0, 0, 0.4) !important; position: absolute !important; opacity: 1 !important; z-index: 8675309 !important; display: none; cursor: pointer !important; border: none !important; top: 1026.78px; left: 1510.31px;"></span></body><loom-container id="lo-engage-ext-container"><div></div><loom-shadow classname="resolved"></loom-shadow></loom-container></html>