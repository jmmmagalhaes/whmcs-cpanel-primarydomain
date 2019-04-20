<?php
//die("This feature is temporarily unavailable. Please check back within 24 hours.");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



use WHMCS\ClientArea;
use WHMCS\Database\Capsule;

define('CLIENTAREA', true);

require __DIR__ . '/init.php';

require_once("custom/cpanel.php");

error_reporting(0);
$ca = new ClientArea();

$notifemail = "test@example.com" // Email to receive notifs on change

$ca->setPageTitle('Modify Primary Domain');

$ca->addToBreadCrumb('index.php', Lang::trans('globalsystemname'));
$ca->addToBreadCrumb('update-domain.php', 'Modify Primary Domain');

$ca->initPage();

$ca->requireLogin(); // Uncomment this line to require a login to access this page


// Check login status
if ($ca->isLoggedIn()) {

    $owner = Capsule::table('tblhosting')->where('id', '=', $id)->value("userid");

    if($owner == $ca->getUserID()) {
		// Product is owned by user

    	$status = Capsule::table('tblhosting')->where('id', '=', $id)->value("domainstatus");

    	if($status == "Active") {
    		// Status is active


    		if(isset($_POST['domain']) && isset($_POST['domain2'])) {

    			$domain = $_POST['domain'];
    			$domain2 = $_POST['domain2'];

    			if($domain == $domain2) {

    				$server = Capsule::table('tblhosting')->where('id', '=', $id)->value("server");

    				if($server == 4) {
    					$cpanelServer = "west04";
    				}else if($server == 6) {
    					$cpanelServer = "west05";
    				}else if($server == 7) {
    					$cpanelServer = "west06";
    				}else if($server == 8) {
    					$cpanelServer = "west07";
    				}else {
    					$cPanelserver = null;
    				}


    				if($cpanelServer != null) {

    					$domain3 = Capsule::table('tblhosting')->where('id', '=', $id)->value("domain");

    					if($domain != $domain3) {

    						$domain = trim($domain, '/');
    						$domain = str_replace(array('http://','https://', '/', 'www.'), '', $domain);
    						$domain = preg_replace('/[^a-zA-Z0-9.]/', '', $domain);


    						$xmlapi = new xmlapi($servers[$cpanelServer]['ip']);
    						$xmlapi->password_auth("root", $servers[$cpanelServer]['password']);

    						$xmlapi->set_debug(1);
    						$xmlapi->set_output('json');

    						$username = Capsule::table('tblhosting')->where('id', '=', $id)->value("username");

    						$return = $xmlapi->modifyacct($username, array("domain"=>$domain));



    						$info = json_decode($return, true);

    						mail($notifemail, "Domain Updated via WHMCS", "Old Domain: " . $domain3 . ", New Domain: " . $domain2 . ", Result: " . $info["result"][0]["statusmsg"]);



    						if($info["result"][0]["status"] == 1) {

    							Capsule::table('tblhosting')->where('id', '=', $id)->update(
    								[
    								'domain' => $domain,
    								]
    								);


    							$ca->assign("output", "Your domain has been updated.");
    						}else {

                            mail($notifemail, "Domain Updated via WHMCS", "Old Domain: " . $domain3 . ", New Domain: " . $domain2 . ", Result: " . $info["result"][0]["statusmsg"]);


    							$ca->assign("output", "There was an error updating your domain. Please check that it's not already added as an Addon Domain or Alias, and that you've entered a valid domain name. If the issue persists, please contact support.");
    						}

    					}else {
    						$ca->assign("output", "That's already your domain.");
    					}

    				}else {
    					$ca->assign("output", "This tool only works on Web Hosting products.");
    				}

    			}else {
    				$ca->assign("output", "Your domains did not match.");
    			}


    		}


    	}else {
    		// Product is not active
    		header("Location: clientarea.php");
    		exit();
    	}

    	$domain = Capsule::table('tblhosting')->where('id', '=', $id)->value("domain");
    	
    	$ca->assign("domain", $domain);

    }else {
		// Product is not owned by user
    	header("Location: clientarea.php");
    	exit();
    }


} else {

	// User is not logged in

	header("Location: login.php");
	exit();
}

$ca->setTemplate('updatedomain');

$ca->output();
