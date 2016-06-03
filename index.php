<?php
if(isset($_GET['phpinfo'])){
    echo '<a href="/">← Home</a>';
    phpinfo();
}
elseif(isset($_GET['onlineoffline'])){
    $_SERVER['argv'][1] = ($wampConf['status'] == "offline") ? "on" : "off";
    require("../scripts/onlineOffline.php");
    header('Location: /?refresh');
}
elseif(isset($_GET['refresh'])){
    require("../scripts/refresh.php");
    header('Location: /');
}
else{
    // Page créé par Dryusdan <contact@dryusdan.fr>
    // Fork de la page d'accueil de WampServer

    //Par défaut la valeur est "../"
    //$server_dir = "WAMPROOT/";
    $server_dir = "../";

    require $server_dir.'scripts/config.inc.php';
    require $server_dir.'scripts/wampserver.lib.php';

    //chemin jusqu'aux fichiers alias
    $aliasDir = $server_dir.'alias/';

    //Fonctionne à condition d'avoir ServerSignature On et ServerTokens Full dans httpd.conf
    $server_software = $_SERVER['SERVER_SOFTWARE'];
    $error_content = '';

    $langues = array(
            'en' => array(
                    'langue' => 'English',
                    'locale' => 'english',
                    'autreLangue' => 'Version Française',
                    'autreLangueLien' => 'fr',
                    'titreHtml' => 'WAMPSERVER Homepage',
                    'titreConf' => 'Server Configuration',
                    'versa' => 'Apache Version:',
                    'doca2.2' => 'httpd.apache.org/docs/2.2/en/',
                    'doca2.4' => 'httpd.apache.org/docs/2.4/en/',
                    'versp' => 'PHP Version:',
                    'versCli' => 'PHP CLI Version:',
                    'server' => 'Server Software:',
                    'docp' => 'www.php.net/manual/en/',
                    'versm' => 'MySQL Version:',
                    'docm' => 'dev.mysql.com/doc/index.html',
                    'phpExt' => 'Loaded Extensions : ',
                    'titrePage' => 'Tools',
                    'txtProjet' => 'Your Projects',
                    'txtNoProjet' => 'No projects yet.<br />To create a new one, just create a directory in \'www\'.',
                    'txtAlias' => 'Your Aliases',
                    'txtNoAlias' => 'No Alias yet.<br />To create a new one, use the WAMPSERVER menu.',
                    'txtVhost' => 'Your VirtualHost',
                    'txtServerName' => 'The ServerName %s has syntax error in file %s',
                    'txtVhostNotClean' => 'The %s file has not been cleaned. There remain VirtualHost examples like: dummy-host.example.com',
                    'txtNoVhost' => 'No VirtualHost yet. Add one for each project in the file: wamp/bin/apache/apache%s/conf/extra/httpd-vhosts.conf',
                    'txtNoIncVhost' => 'Uncomment or add <i>Include conf/extra/httpd-vhosts.conf</i> in file wamp/bin/apache/apache%s/conf/httpd.conf',
                    'txtNoVhostFile' => 'The file: %s does not exists',
                    'txtNoPath' => 'The path %s for %s does not exist (File %s)',
                    'txtNotWritable' => 'The file: %s is not writable',
                    'txtNbNotEqual' => 'The number of %s does not match the number of %s in %s file',
                    'txtAddVhost' => 'Add a Virtual Host',
                    'txtPortNumber' => 'Port number for %s has not correct value or is not the same in file %s',
                    'txtCorrected' => 'Some VirtualHosts errors can be corrected.',
                    'forum' => 'http://forum.wampserver.com/list.php?2',
                    'portUsed' => 'Port defined for Apache: ',
                    'mysqlportUsed' => 'Port defined for MySQL: ',
                    'nolocalhost' => 'It\'s a bad idea to add localhost in the url of launching projects. It is best to define VirtualHost in<br />wamp/bin/apache/apache%s/conf/extra/httpd-vhosts.conf<br />file and not add localhost in the url.',
                    'serverStatusOffline' => 'Serveur hors ligne',
                    'serverStatusOnline' => 'Serveur en ligne',
            ),
            'fr' => array(
                    'langue' => 'Français',
                    'locale' => 'french',
                    'autreLangue' => 'English Version',
                    'autreLangueLien' => 'en',
                    'titreHtml' => 'Accueil WAMPSERVER',
                    'titreConf' => 'Configuration Serveur',
                    'versa' => 'Version Apache :',
                    'doca2.2' => 'httpd.apache.org/docs/2.2/fr/',
                    'doca2.4' => 'httpd.apache.org/docs/2.4/fr/',
                    'versp' => 'Version de PHP :',
                    'verspCli' => 'Version de PHP CLI',
                    'server' => 'Server Software :',
                    'docp' => 'www.php.net/manual/fr/',
                    'versm' => 'Version de MySQL :',
                    'docm' => 'dev.mysql.com/doc/index.html',
                    'phpExt' => 'Extensions&nbsp;Chargées&nbsp;:',
                    'titrePage' => 'Outils',
                    'txtProjet' => 'Vos Projets',
                    'txtServerName' => 'Le ServerName %s comporte des erreurs de syntaxe dans le fichier %s',
                    'txtVhostNotClean' => 'Le fichier %s n\'a pas été nettoyé. Il reste des exemples de VirtualHost comme : dummy-host.example.com',
                    'txtNoProjet' => 'Aucun projet.<br /> Pour en ajouter un nouveau, créez simplement un répertoire dans \'www\'.',
                    'txtAlias' => 'Vos Alias',
                    'txtNoAlias' => 'Aucun alias.<br /> Pour en ajouter un nouveau, utilisez le menu de WAMPSERVER.',
                    'txtVhost' => 'Vos VirtualHost',
                    'txtNoVhost' => 'Aucun VirtualHost. Ajouter-en un par projet dans le fichier : wamp/bin/apache/apache%s/conf/extra/httpd-vhosts.conf',
                    'txtNoIncVhost' => 'Décommentez ou ajouter <i>Include conf/extra/httpd-vhosts.conf</i> dans le fichier wamp/bin/apache/apache%s/conf/httpd.conf',
                    'txtNoVhostFile' => 'Le fichier : %s n\'existe pas',
                    'txtNoPath' => 'Le chemin %s pour %s n\'existe pas (Fichier %s)',
                    'txtNotWritable' => 'Le fichier : %s est en lecture seule',
                    'txtNbNotEqual' => 'Le nombre %s ne correspond pas au nombre de %s dans le fichier %s',
                    'txtAddVhost' => 'Ajouter un Virtual Host',
                    'txtCorrected' => 'Certaines erreurs VirtualHosts pourront être corrigées.',
                    'txtPortNumber' => 'Le numéro de port pour %s n\'est pas correct ou ne sont pas identiques dans le fichier %s',
                    'forum' => 'http://forum.wampserver.com/list.php?1',
                    'portUsed' => 'Port défini pour Apache : ',
                    'mysqlportUsed' => 'Port défini pour MySQL : ',
                    'nolocalhost' => 'C\'est une mauvaise idée d\'ajouter localhost dans les url de lancement des projets. Il est préférable de définir des VirtualHost dans le fichier<br />wamp/bin/apache/apache%s/conf/extra/httpd-vhosts.conf<br />et de ne pas ajouter localhost dans les url.',
                    'serverStatusOffline' => 'Serveur hors ligne',
                    'serverStatusOnline' => 'Serveur en ligne',
            )
    );
    $lang = 'fr';
    //var_dump($wampConf);
    $version['apache'] = $wampConf;
    $version['php'] = $wampConf;
    $version['phpCli'] = $wampConf;
    $version['mysql'] = $wampConf;
    //var_dump(get_loaded_extensions());
    $loaded_extensions = get_loaded_extensions();
    // classement alphabétique des extensions
    setlocale(LC_ALL,"{$langues[$lang]['locale']}");
    sort($loaded_extensions,SORT_LOCALE_STRING);
    $connectMySQLTested = false;
    $connectMySQLValid = false;
    $phpExtContents = "<ul>";
    foreach ($loaded_extensions as $extension){
        $phpExtContents .= "<li>${extension}</li>";
        if($extension == "PDO" && !$connectMySQLTested){
            try{
              $db = new PDO('mysql:host=127.0.0.1;dbname="";port=3306;charset=utf8', "root", "performance_schema");
              $connectMySQLValid = true;
            }
            catch (Exception $e){
              $mysqlError = $e->getMessage();
            }
            $connectMySQLTested = true;
        }
        elseif($extension == "mysqli" && !$connectMySQLTested){
            $mysqli = @new mysqli('127.0.0.1', 'root', '', 'performance_schema', $wampConf['mysqlPortUsed']);
            if ($mysqli->connect_error) {
                $mysqlError = utf8_encode($mysqli->connect_error);
            }
            else{
                $connectMySQLValid = true;
                $mysqli->close();
            }
            $connectMySQLTested = true;
        }
    }
    $phpExtContents = "</ul>";
    if($wampConf['VirtualHostSubMenu'] == "on"){
        $vhostError = false;
        $vhostsContents = check_virtualhost()['ServerName'];

        if(empty($vhostsContents)) {
		$vhostDisplay['vhost'][0] = "<li><i style='color:red:'>No VirtualHost</i></li>";
		$vhostError = true;
		$error_message[] = sprintf($langues[$lang]['txtNoVhost'],$wampConf['apacheVersion']);
	}
        else{
            $vhostAccess = "";
            foreach ($vhostsContents as $url) {
                $vhostDisplay['vhost'][] = $url;
            }
        }
	if(!$c_hostsFile_writable){
		$vhostError = true;
		$error_message[] = sprintf($langues[$lang]['txtNotWritable'],$c_hostsFile);
	}
	if($vhostError) {
            foreach($error_message as $value) {
                $vhostDisplay['error'][] = $value;
            }
	}
        $vhost['title'] = $langues[$lang]['txtVhost'];
    }
    else{
        $vhost['title'] = $langues[$lang]['nolocalhost'];
    }
    $aliasDir = $server_dir.'alias/';
    $aliasContents = '';

// récupération des alias
if (is_dir($aliasDir))
{
    $handle=opendir($aliasDir);
    $vhost['aliasTitle'] = $langues[$lang]['txtAlias'];
    while (($file = readdir($handle))!==false)
    {
        if (is_file($aliasDir.$file) && strstr($file, '.conf'))
        {
	    $msg = '';
	    $vhost['alias'][] = str_replace('.conf','',$file);
        }
    }
    closedir($handle);
}
if (empty($vhost['alias'])){
    $vhost['alias'][0] = $langues[$lang]['txtNoAlias'];
}
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Accueil WampServer</title>
            <link rel="stylesheet" href="wampthemes/metro/normalize.css">
            <link rel="stylesheet" href="wampthemes/metro/style.css">
        </head>
        <header>
            <div class="container">
                <img src="wampthemes/metro/img/logo.png">
                <nav>
                    <ul>
                        <li>
                            <a href="/phpmyadmin/">PHPMyAdmin</a>
                        </li>
                        <li>
                            <a href="add_vhost.php?lang=<?php echo $lang;?>"><?php echo $langues[$lang]['txtAddVhost'];?></a>
                        </li>
                        <li>
                            <a href="" class="noClic">Information</a>
                            <div class="animated scrollDown">
                                <h2 class="titleConf animated fadeInDown"><?php echo $langues[$lang]['titreConf'];?></h2>
                                <div class="grid animated fadeInDown">
                                    <div class="tabConfTitle"><p><?php echo $langues[$lang]['versa'];?></p></div>
                                    <div class="col-2"><p><?php echo $wampConf['apacheVersion'];?></p></div>
                                    <div class="tabPortTitle"><p><?php echo $langues[$lang]['portUsed'];?></p></div>
                                    <div class="col-1"><p class="success"><?php echo $wampConf['apachePortUsed'];?></p></div>
                                    <div class="tabPortTitle" style="width:5%;"><p>Status :</p></div>
                                    <div class="col-1"><p><a href="/?onlineoffline" class="<?php echo ($wampConf['status'] == 'offline')?'error':'success';?>"><?php echo ($wampConf['status'] == 'offline')?$langues[$lang]['serverStatusOffline']:$langues[$lang]['serverStatusOnline'];?></a></p></div>
                                </div>
                                <div class="grid animated fadeInDown">
                                    <div class="tabConfTitle"><p><?php echo $langues[$lang]['versp'];?></p></div>
                                    <div class="col-2"><p><?php echo $wampConf['phpVersion'];?></p></div>
                                    <div class="tabPortTitle"><p><?php echo $langues[$lang]['verspCli'];?></p></div>
                                    <div class="col-1"><p><?php echo $wampConf['phpCliVersion'];?></p></div>
                                    <div class="col-2"><p><a href="/?phpinfo=1">phpinfo</a></p></div>                                
                                </div>
                                <div class="grid animated fadeInDown">
                                    <div class="tabConfTitle"><p><?php echo $langues[$lang]['versm'];?></p></div>
                                    <div class="col-2"><p><?php echo $wampConf['mysqlVersion'];?></p></div>
                                    <div class="tabPortTitle"><p><?php echo $langues[$lang]['mysqlportUsed'];?></p></div>
                                    <div class="col-2"><p class="<?php echo ($connectMySQLValid)? 'success':'error';?>"><?php echo (!$connectMySQLValid)?$mysqlError:$wampConf['mysqlPortUsed'];?></p></div>
                                </div>
                                <p></p>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <div class="container">
                <h1><?php echo $vhost['title'];?></h1>
                <div>
                    <?php
                        if(!empty($vhostDisplay['error'])){
                            foreach ($vhostDisplay['error'] as $value) {
                                ?>
                                <h3><i style='color:red;'>Error(s)</i> See below</h3>
                                <p class="error">
                                <?php
                                    echo $value;
                                ?>
                                </p>
                                <?php 
                            }
                        }
                        else{
                            foreach ($vhostDisplay['vhost'] as $url) {
                                ?>
                                <div class="vhost">
                                    <a href="http://<?php echo $url;?>" >
                                        <img src="http://lorempicsum.com/simpsons/255/200/2">
                                        <span><?php echo $url;?></span>
                                    </a>
                                </div>
                                <?php
                                
                            }
                        }
                    ?>
                <h1><?php echo $vhost['aliasTitle'];?></h1>
                <div>
                    <?php
                        if(!empty($vhostDisplay['error'])){
                            foreach ($vhostDisplay['error'] as $value) {
                                ?>
                                <h3><i style='color:red;'>Error(s)</i> See below</h3>
                                <p class="error">
                                <?php
                                    echo $value;
                                ?>
                                </p>
                                <?php 
                            }
                        }
                        else{
                            foreach ($vhost['alias'] as $url) {
                                ?>
                                <div class="vhost">
                                    <a href="http://localhost/<?php echo $url;?>" >
                                        <img src="http://lorempicsum.com/simpsons/255/200/2">
                                        <span><?php echo $url;?></span>
                                    </a>
                                </div>
                                <?php
                                
                            }
                        }
                    ?>
                </div>
            </div>
        </main>
        <footer>
            <div class="container"><p><a href="http://www.dryusdan.fr">Dryusdan</a> | <a href="<?php echo $langues[$lang]['forum'];?>">WampServer Forum</a></p></div>
        </footer>
    </html>
<?php } ?>