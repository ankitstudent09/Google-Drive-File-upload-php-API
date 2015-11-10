<?php
require __DIR__ . '/vendor/autoload.php'; //api
session_start();

define('DRIVE_SCOPE', 'https://www.googleapis.com/auth/drive');
define('SERVICE_ACCOUNT_EMAIL', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@developer.gserviceaccount.com'); // gservice account from Add Credentials for that New project with service Account
define('SERVICE_ACCOUNT_PKCS12_FILE_PATH', 'xxxxxxxxx.p12');  // Downlaod Private ket p12 from project created on google developer Console and save in root directory of the project file
$emailID = "xxxxxxxxxx@gmail.com";// Provide your email here
/**
 * Build and returns a Drive service object authorized with the service accounts
 * that acts on behalf of the given user.
 *
 * @param userEmail The email of the user.
 * @return Google_Service_Drive service object.
 */
function buildService($userEmail) {
  $key = file_get_contents(SERVICE_ACCOUNT_PKCS12_FILE_PATH);
  $auth = new Google_Auth_AssertionCredentials(
      SERVICE_ACCOUNT_EMAIL,
      array(DRIVE_SCOPE),
      $key);
  $auth->sub = $userEmail;
  $client = new Google_Client();
  $client->setAssertionCredentials($auth);
  $service = new Google_Service_Drive($client);
  
  $file = new Google_Service_Drive_DriveFile();
  $file->setTitle("test.txt");				// Provide file name here and path in below 
$result = $service->files->insert($file, array(
  'data' => file_get_contents("test.txt"),
  'mimeType' => 'application/octet-stream',
  'uploadType' => 'media'
));

echo '<pre>'; print_r($result); echo'</pre>';
  
}

buildService($emailID);  
?>
