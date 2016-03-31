<?php
/**
 * Created by PhpStorm.
 * User: Chaz Schooler
 * Date: 3/27/2016
 * Time: 10:55 PM
 */

require 'vendor/autoload.php';

$database_connection = new PDO("adv.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com:3306", "dbadmin", "amazonisamazing");


function checkTranscriptionExists($db, $channel)
{
    $results = $db->query("SELECT * FROM `ChannelTranscription`.`active_transcription` WHERE channel_name='$channel'");

    if($results->rowCount() == 0)
    {
        return false;
    }

    $channel_result = $results->fetch(PDO::FETCH_ASSOC);

    return $channel_result['active'] != 0;
}

function setTranscriptionExists($db, $channel, $instance)
{
    $results = $db->query("SELECT * FROM `ChannelTranscription`.`active_transcription` WHERE channel_name='$channel'");

    if($results->rowCount() == 0)
    {
        //Insert new record
        $db->exec("INSERT INTO `ChannelTranscription`.`active_transcription` (`channel_name`, `active`, `instance_id`) VALUES ('$channel', '1', '$instance')");
    }
    else
    {
        //Update old record
        $obj = $results->fetch(PDO::FETCH_ASSOC);
        $id = $obj['id'];
        $db->exec("UPDATE `ChannelTranscription`.`active_transcription` SET `active`='1', `instance_id`='$instance' WHERE `id`='$id'");
    }
}

use Aws\Ec2\Ec2Client;

if(checkTranscriptionExists($_POST['channel_name']))
{
    return;
}


$channel_name = $_POST['channel_name'];
$ec2Client = Ec2Client::factory(array(
   'key' => '',
    'secret' => '',
    'region' => 'us-east1'
));

$keyPairName = 'transcription-key';
$saveKeyLocation = getenv('HOME') . "/.ssh/{$keyPairName}.pem";
if(!file_exists($saveKeyLocation))
{
    //Create and store an ssh key
    $result = $ec2Client->createKeyPair(array(
        'KeyName' => $keyPairName
    ));

    file_put_contents($saveKeyLocation, $result['keyMaterial']);
    chmod($saveKeyLocation, 0600);

    unset($result);
}


$result = $ec2Client->runInstances(array(
    'ImageId' => 'ami-3cc4cd56',
    'MinCount' => 1,
    'MaxCount' => 1,
    'InstanceType' => 't2.medium',
    'KeyName' => $keyPairName,
    'SecurityGroups' => array("Transcription Security")
));

$instance_id = $result['Instances'][0]['InstanceId'];
$instance_dns = $result['Instances'][0]['PublicDnsName'];

$ssh_command = "nohup ./a2t --channel ".$channel_name. " --database_port 3306 --db_username dbadmin --db_password amazonisamazing --database_host adv.c0dpqj5xfw8m.us-east-1.rds.amazonaws.com > /dev/null 2>&1 < /dev/null &";

$ssh_connection = ssh2_connect($instance_dns);
ssh2_exec($ssh_connection, $ssh_command);

setTranscriptionExists($database_connection, $channel_name, $instance_id);