# Google API OAuth2 Login Button
This is a vue component which uses axios and a client/server web model to authenticate to Google using Oauth2.

## Requires
Required PHP, Composer, Vue and Axios

## How to use
* Upload this directory to where you intend to use the button.
* Run `composer install` to install google api client
* Configure in oauth.php
  * Path to credentials OR
  * Client ID/Client secret
  * Redirect path/URI where user will be redirected after logging in (This URI must be allowed in your Google API configuration), or you will get an error when attempting to auth

Note that if the path to oauth.php changes that will also need to be re-configured in google-oauth2-button.js

If all is configured correctly, test.php will produce a google button.
Once clicked that button will forward you to the auth URL created in oauth.php.
Then you'll be re-directed to the value set in oauth.php under $redirect_uri.
If you redirect back to the test page, the user's profile image and display name of their profile will replace the button.

More configuration and docs to come.  I find myself re-creating this component a lot so I wanted to create one master version I could
re-use and be done with it.  Also because OAuth was pretty torturous to get right the first few times I've implemented, and even more so
getting it to be compatible with a JS front-end component that runs http requests as opposed to using forwards between pages which google uses in its examples,
I'm hoping this will save someone else some headache.