<?php
/**
 * Created by PhpStorm.
 * User: Chaz Schooler
 * Date: 3/28/2016
 * Time: 4:31 PM
 */

require 'vendor/autoload.php';

$database_connection = new PDO("adv.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com:3306", "dbadmin", "amazonisamazing");

$db_select = "SELECT `id`, `channel_name`, `instance_id` FROM ChannelTranscription.active_transcription WHERE `active`='1'";
$db_update = "UPDATE `ChannelTranscription`.`active_transcription` SET `active`='0', `instance_id`='NULL' WHERE `id`=";

$curl = curl_init();

$curl_headers = array(
    "Accept: application/vnd.twitchtv.v2+json"
);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_headers);

$ec2Client = Ec2Client::factory(array(
    'key' => '',
    'secret' => '',
    'region' => 'us-east1'
));

while(true)
{
    foreach($database_connection->query($db_select) as $row) {
        $channel_url = "https://api.twitch.tv/kraken/streams/".$row['channel_name'];
        curl_setopt($curl, CURLOPT_URL, $channel_url);

        $result = curl_exec($curl);

        if($result === false)
        {
            continue;
        }

        $stream_obj = json_decode($result);

        if($stream_obj['stream'] === null)
        {
            //Terminate instance and update db
            $ec2Client->terminateInstances(array(
                'InstanceIds' => array($row['instance_id'])
            ));
            $id = $row['id'];
            $database_connection->exec($db_update."'$id'");
        }
    }

    sleep(3000);
}
