<?php
require '../vendor/autoload.php';

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

use Google\Client;
use Google\Service\Drive;
function getClient()
{
  $client = new Client();
  $client->setApplicationName('Google Drive API PHP Quickstart');
  $client->setScopes('https://www.googleapis.com/auth/drive.readonly');
  $client->setAuthConfig('D:\Program Files\xampp\htdocs\wandering-wisdom\externalAssets\credentials.json');
  $client->setAccessType('offline');
  $client->setRedirectUri("http://localhost/externalAssets/googleAuth.php");
  $client->setPrompt('select_account consent');

  $tokenPath = 'token.json';
  if (file_exists($tokenPath)) {
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);
  }

  if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    } else {
      $authUrl = $client->createAuthUrl();
      printf("Open the following link in your browser:\n%s\n", $authUrl);
      print 'Enter verification code: ';
      $authCode = trim(fgets(STDIN));

      $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

      $client->setAccessToken($accessToken);

      if (array_key_exists('error', $accessToken)) {
        throw new Exception(join(', ', $accessToken));
      }
    }
    if (!file_exists(dirname($tokenPath))) {
      mkdir(dirname($tokenPath), 0700, true);
    }
    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

$client = getClient();
$service = new Drive($client);

try {
  $optParams = array(
    'pageSize' => 10,
    'fields' => 'files(id,name,mimeType)',
    'q' => 'mimeType = "application/vnd.google-apps.folder" and "root" in parents',
    'orderBy' => 'name'
  );
  $results = $service->files->listFiles($optParams);
  $files = $results->getFiles();

  if (empty($files)) {
    print "No files found.\n";
  } else {
    print "Files:\n";
    foreach ($files as $file) {
      $id = $file->id;

      printf("%s - (%s) - (%s)\n", $file->getId(), $file->getName(), $file->getMimeType());
    }
  }
} catch (Exception $e) {
  echo 'Message: ' . $e->getMessage();
}
