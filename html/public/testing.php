<?php
require '../private/aws/aws-autoloader.php'; // Include the AWS SDK for PHP
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Exception\AwsException;

session_start();

$awsAccessKey = 'AKIA3QRSAJWSMMHJIYNO';
$awsSecretKey = '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';
$region = 'us-west-2';
$appClientId = '4n03or3o47btrp6fn7rsk0n84q';

$client = new CognitoClient($awsAccessKey, $awsSecretKey, $region, $appClientId);

try{
    $userSub = $client->createUser('crewderek@yahoo.com', 'user_password', 'John', 'Doe');

    echo json_encode(['success' => true, 'message' => "The user $userSub was created."]);
}catch(Exception $e){
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

class CognitoClient {
    private $client;
    private $appClientId;
    private $lastResult;

    public function __construct($awsAccessKey, $awsSecretKey, $region, $appClientId) {
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

    public function createUser($email, $password, $givenName, $familyName) {
        // Define the user attributes
        $userAttributes = [
            [
                'Name' => 'email',
                'Value' => $email,
            ],
            [
                'Name' => 'given_name',
                'Value' => $givenName,
            ],
            [
                'Name' => 'family_name',
                'Value' => $familyName,
            ],
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
        }
        catch(AwsException $e){
            $errorCode = $e->getAwsErrorCode();
            if($errorCode == 'UsernameExistsException'){
                throw new Exception('A user with that email already exists.');
            }elseif ('LimitExceededException'){
                throw new Exception('There have been too many creation attempts. Try again later.');
            }

            throw new Exception($e);
        }
    }
}