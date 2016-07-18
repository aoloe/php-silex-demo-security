# Silex and Security Demo

- Only one template that shows a login form if the user is not logged in.
- The user's password is stored encrypted in an array.

## Todo

- There is a session problem:

  ~~~
    [2016-07-18 11:06:21] app.INFO: Matched route "{route}". {"route":"login_check","route_parameters":{"_controller":null,"_route":"login_check"},"request_uri":"http://ww.tanne.ch/aoloe-security/login_check","method":"POST"} []
    [2016-07-18 11:06:22] app.INFO: User has been authenticated successfully. {"username":"alice"} []
    [2016-07-18 11:06:22] app.DEBUG: < 302 http://ww.tanne.ch/aoloe-security/ [] []
    [2016-07-18 11:06:22] app.DEBUG: Stored the security token in the session. {"key":"_security_secured"} []
    [2016-07-18 11:06:22] app.INFO: Matched route "{route}". {"route":"GET_","route_parameters":{"_controller":"[object] (Closure: {})","_route":"GET_"},"request_uri":"http://ww.tanne.ch/aoloe-security/","method":"GET"} []
    [2016-07-18 11:06:22] app.DEBUG: Read existing security token from the session. {"key":"_security_secured"} []
    [2016-07-18 11:06:22] app.DEBUG: User was reloaded from a user provider. {"username":"alice","provider":"Symfony\\Component\\Security\\Core\\User\\InMemoryUserProvider"} []
    [2016-07-18 11:06:22] app.INFO: An AuthenticationException was thrown; redirecting to authentication entry point. {"exception":"[object] (Symfony\\Component\\Security\\Core\\Exception\\CredentialsExpiredException(code: 0): User credentials have expired. at /Users/ale/src/aoloe/php-silex-demo-security/vendor/symfony/security/Core/User/UserChecker.php:64)"} []
    [2016-07-18 11:06:22] app.DEBUG: Calling Authentication entry point. [] []
    [2016-07-18 11:06:22] app.INFO: The security token was removed due to an AccountStatusException. {"exception":"[object] (Symfony\\Component\\Security\\Core\\Exception\\CredentialsExpiredException(code: 0): User credentials have expired. at /Users/ale/src/aoloe/php-silex-demo-security/vendor/symfony/security/Core/User/UserChecker.php:64)"} []
    [2016-07-18 11:06:22] app.DEBUG: < 302 http://ww.tanne.ch/aoloe-security/login [] []
    [2016-07-18 11:06:23] app.INFO: Matched route "{route}". {"route":"GET_login","route_parameters":{"_controller":"[object] (Closure: {})","_route":"GET_login"},"request_uri":"http://ww.tanne.ch/aoloe-security/login","method":"GET"} []
    [2016-07-18 11:06:23] app.DEBUG: > GET /aoloe-security/login [] []
    [2016-07-18 11:06:23] app.DEBUG: < 200 [] []
  ~~~~
