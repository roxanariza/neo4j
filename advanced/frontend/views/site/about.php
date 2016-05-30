<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use Everyman\Neo4j\Client;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
<?php

// Connecting to the default port 7474 on localhost
$client = new Client();

// Connecting to a different port or host
//$client = new Everyman\Neo4j\Client('localhost', 7474);

// Connecting using HTTPS and Basic Auth
//$client = new Everyman\Neo4j\Client();
$client->getTransport()
  ->setAuth('neo4j', '123456');

// Test connection to server
//print_r($client->getServerInfo());

	$keanu = $client->makeNode()->setProperty('name', 'Actor 1')->save();
	$laurence = $client->makeNode()->setProperty('name', 'Actor 2')->save();
	$jennifer = $client->makeNode()->setProperty('name', 'Actor 3')->save();
	$kevin = $client->makeNode()->setProperty('name', 'Actor 4')->save();
//$client->saveNode($node);

?>