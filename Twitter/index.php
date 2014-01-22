<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "2303667030-6CCrhUIpPygYTxRzfIHOojFwkZIckrQOyUGvAPD",
    'oauth_access_token_secret' => "kltx7LxpSkTJJzXy3JlWXsOjCq40Am2W293IsXyXux8GX",
    'consumer_key' => "TrCISOCep7awpIGpqpFMg",
    'consumer_secret' => "57mcDymerrsAA2ciN91RmEhjZiJYplP6GHvnKaY"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);

/** Perform a POST request and echo the response **/
/*
$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
*/

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
//$url = 'https://api.twitter.com/1.1/search/tweets.json?q=%23freebandnames.json';
$url = 'https://api.twitter.com/1.1/followers/ids.json';
$getfield = '?screen_name=hgreve1222';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
//echo $twitter->setGetfield($getfield)
//             ->buildOauth($url, $requestMethod)
//             ->performRequest();

$url = 'https://api.twitter.com/1.1/statuses/update.json'; 
$requestMethod = 'POST';
$postfields = array(
    'status' => 'sabes http://www.record.xl.pt/emdireto/?id_game=72695&id_post=1896175' ); 
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();
