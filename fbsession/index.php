<?php

require 'facebook.php';

// Create our Application instance.

//Testing account

$facebook = new Facebook(array(
  'appId'  => '146645185372304',
  'secret' => '86399b9fc099975cbf37608defb2591a',
  'cookie' => true,
));


//VNMLS account
/*
$facebook = new Facebook(array('appId'  => '118396461549094',
											  'secret' => '6b7de85b3d2dff72a3a14415f32ad86a',
											  'cookie' => true
											));
*/
// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
$savedSession = false;

/*
$savedSession = array(
									    'access_token' => '146645185372304|abb0733224d5fb736259c135-100001562614771|78KGQCacBqnN859jxOxNqbffXNo.',
										'expires' => 0,
										'secret' => '992349bccf00508a8c1999ca8ffb4105',
										'session_key' => 'abb0733224d5fb736259c135-100001562614771',
    									'sig' => '392d58494568b75d4f5148663f159af1',
    									'uid' => '100001562614771'
										);


$savedSession = array(
									    'access_token' => '118396461549094|62a49d657a255af00a635040.0-100001346762390|lr84Zb2aNiUwo8CtMubVNX6s8ZM',
										'expires' => 0,
										'secret' => 'c11788f536d4937ad6631acfe1c93afb',
										'session_key' => '62a49d657a255af00a635040.0-100001346762390',
    									'sig' => 'b641d459fed4dee2d2f25628386c8068',
    									'uid' => '100001346762390',
										'base_domain' => 'vnmls.vn'
										);
*/
if ($savedSession){
	$facebook->setSession($savedSession);
	$session = $savedSession;
}else{
	$session = $facebook->getSession();
}
$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array('req_perms' => 'publish_stream,offline_access'));
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <!--
      We use the JS SDK to provide a richer user experience. For more info,
      look here: http://github.com/facebook/connect-js
    -->
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


    <h1><a href="example.php">php-sdk</a></h1>

    <?php if ($me): ?>
    <a href="<?php echo $logoutUrl; ?>">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
    <?php else: ?>
    <div>
      Using JavaScript &amp; XFBML: <fb:login-button  perms="publish_stream,offline_access"></fb:login-button>
    </div>
    <div>
      Without using JavaScript &amp; XFBML:
      <a href="<?php echo $loginUrl; ?>">
        <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
      </a>
    </div>
    <?php endif ?>

    <h3>Session</h3>
    <?php if ($me): ?>
    <pre><?php print_r($session); ?></pre>

    <h3>You</h3>
    <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
    <?php echo $me['name']; ?>

    <h3>Your User Object</h3>
    <pre><?php print_r($me); ?></pre>
    <?php else: ?>
    <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?> 
  </body>
</html>