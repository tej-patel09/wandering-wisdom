<?php
require 'assets.php';

use Google\Client;
use Google\Service\Drive;

function dd($param)
{
  echo ('<pre>' . var_export($param, true) . '</pre>');
}
function getClient()
{
  $client = new Client();
  $client->setApplicationName('Google Drive API PHP Quickstart');
  $client->setScopes('https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/userinfo');
  $client->addScope('email');
  $client->addScope('profile');
  $client->setAuthConfig('.\credentials.json');
  $client->setAccessType('offline');
  $client->setRedirectUri("http://localhost/wandering-wisdom/externalAssets/googleAuth.php");
  $client->setPrompt('select_account consent');

  $tokenPath = 'token.json';
  if (file_exists($tokenPath)) {
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);
  }
  if (isset($_GET['code'])) {
    $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    $client->setAccessToken($accessToken);

    if (array_key_exists('error', $accessToken)) {
      throw new Exception(join(', ', $accessToken));
    }
    if (!file_exists(dirname($tokenPath))) {
      mkdir(dirname($tokenPath), 0700, true);
    }
    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    header('Location: ' . "http://localhost/wandering-wisdom/externalAssets/googleAuth.php");
    exit;
  }
  if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    } else {
      $authUrl = $client->createAuthUrl();
      header('Location: ' . $authUrl);
      exit;
    }
  }
  return $client;
}

$client = getClient();
$service = new Drive($client);
$google_service = new Google\Service\Oauth2($client);
try {
  $data = $google_service->userinfo->get();
  $response = $WanderingWisdom->{$collection['googleCred']}->updateOne(
    ['email' => $data['email']],
    ['$set' => $client->getAccessToken()]
  );
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
      printf("%s - (%s) - (%s)<br />", $file->getId(), $file->getName(), $file->getMimeType());
    }
  }
} catch (Exception $e) {
  echo 'Message: ' . $e->getMessage();
}
