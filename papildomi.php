<?php

class config {
	public $audio_dir = '/home/simne/domains/greitas.com/public_html/audio';
	
	public $martynas_pdo_dsn = 'mysql:host=localhost;dbname=simne_demo';
	public $martynas_pdo_user = 'sekuritis';
	public $martynas_pdo_password = '~WFKb#}FjA4!{%fn';
	public $pdo_dsn = 'sqlite:databases/nerijus.greitas.sqlite3';
	public $pdo_user = null;
	public $pdo_password = null;
	public $pdo_options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	
	
}

global $db, $config;
$config = new config();

$db = new PDO($config->pdo_dsn, $config->pdo_user, $config->pdo_password, $config->pdo_options);

if(isset($_GET['init'])) {
// 	$db->exec('CREATE TABLE IF NOT EXISTS statistic ( id INTEGER PRIMARY KEY ASC, ip, laikas, useragent )');
// 	$db->exec('CREATE TABLE IF NOT EXISTS naujienos ( id INTEGER PRIMARY KEY ASC, pavadinimas, autorius, tekstas, tema, laikas )');
// 	$db->exec('ALTER TABLE naujienos ADD COLUMN ordering_category');
// 	$db->exec('ALTER TABLE naujienos ADD COLUMN ordering');
// 	$db->exec('ALTER TABLE naujienos RENAME TO naujienos_old');
// 	$db->exec('CREATE TABLE naujienos ( id INTEGER PRIMARY KEY ASC, pavadinimas, autorius, tekstas, tema_id, laikas, ordering )');
// 	$db->exec('CREATE TABLE tema ( id INTEGER PRIMARY KEY ASC, pavadinimas, ordering )');
// 	$db->exec('INSERT INTO tema (pavadinimas, ordering) SELECT distinct tema, 0 FROM naujienos_old');
// 	$db->exec('INSERT INTO naujienos (pavadinimas, autorius, tekstas, tema_id, laikas, ordering) SELECT pavadinimas, autorius, tekstas, (select id FROM tema where naujienos_old.tema = tema.pavadinimas), laikas, ordering FROM naujienos_old');
// 	$db->exec('DROP TABLE naujienos_old ');
// 	$db->exec('ALTER TABLE tema RENAME TO temos ');
// 	var_dump($db->query("SELECT * FROM sqlite_master WHERE type='table';")->fetchAll());
}

/*
 * Lankomumas
 */
$ip = $_SERVER['REMOTE_ADDR'];
$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
try {
	$sth = $db->prepare("INSERT INTO statistic (ip, laikas, useragent) VALUES (?,date('now'), ?)");
	$sth->execute(array($ip, $useragent));
} catch (Exception $e) {
// 	var_dump($e->getMessage());
}

/*
 * Access-Control-Allow-Origin
 */
$httpReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
$ref = null;

if (null !== $httpReferer) {
    foreach (['http://nerijus.snekuciai.com'] as $site) {
        if (strpos($httpReferer, $site) === 0) {
            $ref = $site;
            break;
        }
    }
}

if (null !== $ref) {
    header("Access-Control-Allow-Origin: " . $ref);
}
