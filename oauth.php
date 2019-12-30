<?php
// Requires google/apiclient, Install with composer or download via
// https://github.com/googleapis/google-api-php-client
require_once __DIR__ . '/vendor/autoload.php';

// Credentials config, will try to use path to credentials first
// Will use manual API and Secret if not
$credentials_path = 'credentials.json';
$client_id = '';
$client_secret = '';
// Set your redirect URI manually here
$redirect_uri = "http://{$_SERVER['HTTP_HOST']}/github/vue-oauth2/test.php";

session_start();

$client = new Google_Client();
if (file_exists($credentials_path)) {
    $client->setAuthConfig($credentials_path);
} else {
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
}
$client->setRedirectUri($redirect_uri); //Redirect URI's must also be approved on Google's API Auth side
$client->setScopes(array(
    'email',
    'profile'
));  //At the bare minimum the profile/email scope is required for access for most api access

// If there is an access token, check if it's expired and logout
if (isset($_SESSION['access_token'])) {
    if ($client->isAccessTokenExpired()) {
        session_destroy();
    }
}

// PHP Axios post compatibility
$_POST = json_decode(file_get_contents('php://input'), true);
$data['post'] = $_POST;

// If we're logging out we just need to clear our
// local access token in this case
if (isset($_POST['logout'])) { // If session variable logout is set
    session_destroy();
}

try {
    // If we have a code back from the OAuth 2.0 flow,
    // authenticate and retrieve access token
    if (isset($_GET['code'])) {
        if (isset($_SESSION['user_profile'])) {
            $data['user_profile'] = $_SESSION['user_profile'];
        } else {
            $data['access_token'] = $_SESSION['access_token'] = $client->authenticate($_GET['code']); // Authenticate to Google using the code
            $data['token'] = $client->getAccessToken(); // Assign session variable from the getAccessToken method.
        }
    }

    // If we have an access token, we can make requests, otherwise we generate an authentication URL.
    if (isset($_SESSION['access_token']) && !$_SESSION['access_token']['error']) {
        $client->setAccessToken($_SESSION['access_token']);
        $data['access_token'] = $_SESSION['access_token'];

        $_SESSION['user_profile'] = $data['user_profile'] = $client->verifyIdToken();
    } else {
        $data['authUrl'] = $client->createAuthUrl();
    }

} catch (Exception $e) {
    $data['error'] = $e->getMessage();
}

echo json_encode($data);
?>