<?php
//ini_set('display_errors', 1);
//require_once('Twitter\TwitterAPIExchange.php');
require_once('./Twitter/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ * */
$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "",
    'consumer_secret' => ""
);

$twitter = new TwitterAPIExchange($settings);


$user_info = file_get_contents('http://hagreve.com/api/v2/allstrikes');
$user_info = json_decode($user_info, true);


$user_info = array_slice($user_info, -10, 10, true);
$new_array = array();
$json_read = json_decode(file_get_contents('last.json'), true);
$json_read = array_values($json_read);

$valid = 0;
foreach ($user_info as $key => $value) {
    if ($value['source_link'] != $json_read[0]['source_link'] && $valid == 1) {

        /*
          $company = $value['company']['name'];
          $description = $value['description'];
          $start_date = $value['start_date'];
          $end_date = $value['end_date'];
          $state = $value['canceled'];
         */
        $new_array[$key] = $value;


        /*
          if(strtotime($end_date)-  strtotime($start_date) < 1800){
          echo'Igual: '; print_r($description);echo '</br>';
          }
         */
    } elseif ($value['source_link'] == $json_read[0]['source_link']) {
        $valid = 1;
    }
}

$user_info = array_slice($user_info, -1, 1, true);
$fp = fopen('last.json', 'w+');
fwrite($fp, json_encode($user_info));
fclose($fp);

setlocale(LC_ALL, 'pt_PT.utf8');

$result = '@Greve ' . '@'.$company . '!! ' /* . ' De' .  strftime( "%e %B %Y ",strtotime($start_date)) .
          'a' . strftime( "%e %B %Y",strtotime($end_date)) . '. ' */ . $description;

//print_r($result);

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';

echo 'Array a inserir '; var_dump($new_array);

foreach ($new_array as $key => $value) {
    if (strtotime($value['end_date']) - strtotime($value['start_date']) < 1800) {
        $result = '@Greve ' . '@'.$value['company']['name'] . '!! ' /* . ' De' .  strftime( "%e %B %Y ",strtotime($start_date)) .
                  'a' . strftime( "%e %B %Y",strtotime($end_date)) . '. ' */ . $value['description'] . ' ' . $value['source_link'];
    } elseif (strtotime($value['end_date']) - strtotime($value['start_date']) < 86400) {
        $result = '@Greve ' . '@'.$value['company']['name'] . '!! ' . 'No dia' . strftime("%e %B", strtotime($start_date)) /* .
                  'a' . strftime( "%e %B %Y",strtotime($end_date)) . '. ' */ . '. ' . $value['description'] . ' ' . $value['source_link'];
    } else {
        $result = '@Greve ' . '@'.$value['company']['name'] . '!! ' . 'Começa dia' . strftime("%e %B", strtotime($start_date)) /* .
                  'a' . strftime( "%e %B %Y",strtotime($end_date)) . '. ' */ . '. ' . $value['description'] . ' ' . $value['source_link'];
    }
//var_dump($result);
    $postfields = array(
        'status' => $result);
    echo $twitter->buildOauth($url, $requestMethod)
            ->setPostfields($postfields)
            ->performRequest();
}
?>