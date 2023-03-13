<?php
require_once '../../private/aws/aws-autoloader.php'; // Include the AWS SDK for PHP
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Exception\AwsException;

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['type'])) {
    die(json_encode(['success' => true, 'message' => "Could not identify your request"]));
}
//  Grab and parse the configuration file
$config = parse_ini_file('../../private/config/cognitoConfig.ini'); //  Require for Cognito configurations

//  Set the configuration file variables
$awsAccessKey = $config['awsAccessKey'];
$awsSecretKey = $config['awsSecretKey'];
$region = $config['region'];
$appClientId = $config['appClientId'];

// Get the value of the "username" parameter from the $_POST array
$email = $_POST['email'];
$password = $_POST['password'];
$type = $_POST['type'];

//  Start our user session to keep track of variables
session_start();

//  Create our new Cognito client to perform client functions
$client = new CognitoClient($awsAccessKey, $awsSecretKey, $region, $appClientId);

if($type == 'sign-up') {
    try {
        $userSub = $client->createUser($email, $password);

        echo json_encode(['success' => true, 'message' => "The user $userSub was created."]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}elseif($type == 'login'){

}

class CognitoClient
{
    private $client;
    private $appClientId;
    private $lastResult;

    public function __construct($awsAccessKey, $awsSecretKey, $region, $appClientId)
    {
        $this->client = new CognitoIdentityProviderClient([
            'version' => 'latest',
            'region' => $region,
            'credentials' => [
                'key' => $awsAccessKey,
                'secret' => $awsSecretKey,
            ],
        ]);
        $this->appClientId = $appClientId;
    }

    public function createUser($email, $password)
    {
        // Define the user attributes
        $userAttributes = [
            [
                'Name' => 'email',
                'Value' => $email,
            ]
        ];


        try {
            // Create the user in Cognito
            $result = $this->client->signUp([
                'ClientId' => $this->appClientId,
                'Username' => str_replace('@', '-at-', $email),
                'Password' => $password,
                'UserAttributes' => $userAttributes,
            ]);

            $this->lastResult = $result;

            // The result will contain the new user's ID and other information
            $userSub = $result['UserSub'];
            return $userSub;
        } catch (AwsException $e) {
            $errorCode = $e->getAwsErrorCode();
            if ($errorCode == 'UsernameExistsException') {
                throw new Exception('A user with that email already exists.');
            } elseif ($errorCode == 'LimitExceededException') {
                throw new Exception('There have been too many creation attempts. Try again later.' . $e);
            }

            throw new Exception($e);
        }
    }
}