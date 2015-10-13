<?php
session_start();

require 'includes/autoloader.php';

use core\Database;
use core\Authentication;

$isLoggedIn = Authentication::isLoggedIn();

if ($isLoggedIn) {
    if (isset($_GET['logout']) && $_GET['logout']) {
        Authentication::logout();
        header('Location: /');
    } 
} elseif (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            $database = new Database();
            $isLoggedIn = Authentication::login($email, $password, $database); 

            $database = null;
        } catch (PDOException $e) {
            echo $e;
        }
    }		
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>99 Party! | Festas em S&atilde;o Paulo</title>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="description" content="O 99 Party permite que voc&ecirc; localize festas estudant&iacute;s em S&atilde;o Paulo." />
        
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="css/home-minified.css" rel="stylesheet" type="text/css" />
        <link rel="canonical" href="http://99party.esy.es/" />
    </head>

    <body onload="carregar();">
        <div id="wrapper">

            <!-- MODAL ADVANCED SEARCH -->
            <div id="advanced-search" class="modal hide fade">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>Pesquisa avan&ccedil;ada</h3>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal">
                    
                        <div class="control-group">
                            <label class="control-label">Raio de pesquisa</label>
                        
                            <div class="controls">
                                <select id="distancia_prox" name="distancia_prox" disabled="disabled">
                                    <option value=100000></option>
                                    <option value=1>1 km.</option>
                                    <option value=2>2 km.</option>
                                    <option value=5>5 km.</option>
                                    <option value=10>10 km.</option>
                                    <option value=15>15 km.</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Nome da rep&uacute;blica</label>

                            <div class="controls">
                                <input id="pesquisar_nome" name="pesquisar_nome" type="text" value="" size="40"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Valor mensal</label>

                            <div class="controls">
                                <select id="aluguel" name="aluguel">
                                    <option value=100000></option>
                                    <option value=50>Até R$50,00</option>
                                    <option value=100>Até R$100,00</option>
                                    <option value=150>Até R$150,00</option>
                                    <option value=200>Até R$200,00</option>
                                </select>
                            </div>
                        </div>
 
                        <div class="control-group">
                            <label class="control-label">Tipo</label>

                            <div class="controls">
                                <select id="tipo" name="tipo">	
                                    <option value=100000></option>
                                	<option value="masculina">Masculina</option>
                                	<option value="feminina">Feminina</option>
                                	<option value="mista">Mista</option>
                                </select>
                            </div>
                        </div>
	
                        <div class="control-group">
	                        <label class="control-label">Distância até a EACH</label>

                            <div class="controls">
                                <select id="distancia_each" name="distancia" >
                                	<option value=100000></option>
                                	<option value=300>Até 300m</option>
                                	<option value=500>Até 500m</option>
                                	<option value=1000>Até 1km</option>
                                	<option value=2000>Até 2km</option>
                                	<option value=5000>Até 5km</option>
                                	<option value=10000>Até 10km</option>
                                	<option value=15000>Até 15km</option>
                                </select>
                            </div>
                        </div> 
                    </form>
                </div>

                <div class="modal-footer">
				    <button data-dismiss="modal" aria-hidden="true" class="btn">Fechar</button>
				    <button data-dismiss="modal" aria-hidden="true" class="btn btn-info" onclick="pesquisar();">Buscar</button>
				</div>
            </div>
            <!--/ MODAL ADVANCED SEARCH -->
                
            <header>
                <h1>99 Party</h1>
                
                <div id="header-right"> 
                    
                    
                    
                    <div id="search-options" class="input-append">
                        <input class="search-box-input" id="endereco_prox" type="text" placeholder="Digite o endere&ccedil;o ou a localiza&ccedil;&atilde;o aproximada" name="endereco_prox" onblur="habilitarOuDesabilitarDist();"/>
                        <button class="btn" type="button" onclick="pesquisar();"> Buscar </button>
   		                
                    </div>
	                
                </div>                   
            </header>

            <?php if (isset($loginSuccess) && !$loginSuccess) : ?>
                <div class="alert alert-error">
                    <b>Aten&ccedil;&atilde;o:</b> N&atilde;o foi poss&iacute;vel fazer login. E-mail e senha n&atilde;o correspondem.
                </div>
            <?php endif; ?>
            
            

            <!-- MAPA -->
            <div id="google_map" style="width: 838px; height: 576px;"></div>
            <!--/ MAPA -->

<footer>
                <nav>
                    <ul class="navbar">
                       
                    </ul>
                </nav>

                
            </footer>
        </div>

        <script type="text/javascript">
            function login() { document.forms['login-form'].submit(); }
        </script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false"></script>
        <script type="text/javascript" src="js/maps.js"></script>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
        <!-- Google Plus One -->
        <script type="text/javascript">
            window.___gcfg = {lang: 'pt-BR'};
        
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        </script>
        <!--/ Google Plus -->
        
        <!-- Twitter -->
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <!--/ Twitter -->
        
        <!-- Facebook -->
        <div id="fb-root"></div> 
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=115164028643627";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <!--/ Facebook -->
        
        <!-- Google Analytics -->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-29750007-3']);
            _gaq.push(['_setDomainName', '99party.esy.es']);
            _gaq.push(['_trackPageview']);
        
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <!--/ Google Analytics -->
    </body>
</html>