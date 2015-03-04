<?php
require_once __DIR__ . "\\reportClient\autoload.dist.php";
 
use Jaspersoft\Client\Client;
 
$c = new Client("http://localhost:8080/jasperserver",
				"jasperadmin",
				"jasperadmin",
				"organization_1"
			);

$c->jobService()->getJobs("/Reports/Samples/Department");

$c->setRequestTimeout(60);

$info = $c->serverInfo();
 
print_r($info);   


