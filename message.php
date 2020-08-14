<?php

require __DIR__ . '/vendor/autoload.php';



// Change the following with your app details:

// Create your own pusher account @ https://app.pusher.com



$options = array(

   'cluster' => 'mt1',

   'encrypted' => true

 );

 $pusher = new Pusher\Pusher(


  '0236851609a3ec023318',

   '40149d5864bc43e26eb8',

   '1053092',

   $options

 );
/*
 app_id = "1053092"
key = "0236851609a3ec023318"
secret = "40149d5864bc43e26eb8"
cluster = "mt1"
*/
// Check the receive message

if(isset($_POST['message']) && !empty($_POST['message'])) {

  $data = $_POST['message'];

// Return the received message

if($pusher->trigger('test_channel', 'my_event', $data)) {

echo 'success';

} else {

echo 'error';

}

}