<?php
namespace Aoloe\Demo;

use \Silex\Application as SilexApplication;

class Application extends SilexApplication
{
    public function __construct()
    {
        parent::__construct();

        $app = $this;

        $app['debug'] = true;

        date_default_timezone_set('Europe/Zurich');

        $app->register(new \Silex\Provider\SecurityServiceProvider());
        $app->register(new \Silex\Provider\SessionServiceProvider());

        $app['monolog.options'] = [
            'monolog.logfile' => APP_BASEDIR.'/var/logs/app.log',
            'monolog.name' => 'app',
            // 'monolog.level' => 300, // = Logger::WARNING
        ];

        $app->register(new \Silex\Provider\MonologServiceProvider(), $app['monolog.options']);
		// $app['monolog']->addError('My logger is now ready');

        $users = [
            'alice' => [
                'ROLE_USER',
                // 'password'
                $app['security.default_encoder']->encodePassword('password', ''),
            ]
        ];

        /* TODO: does not work (anymore!)
        $app['security.encoder.digest'] = function ($app) {
            return new \Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder();
        };
        */

        $app['security.firewalls'] = [
            'login' => [
                'pattern' => '^/login$',
            ],
            'secured' => [
                'pattern' => '^.*$',
                'form' => [
                    'login_path' => '/login',
                    'check_path' => '/login_check'
                ],
                'logout' => ['logout_path' => '/logout'],
                'users' => $users,
            ],
        ];

        /*
        $app['security.utils'] = function ($app) {
            return new \Symfony\Component\Security\Http\Authentication\AuthenticationUtils($app['request_stack']);
        };
        */

        $app['security.access_rules'] = array(
            array('^/admin', 'ROLE_ADMIN'),
            array('^.*$', 'ROLE_USER'),
        );

        $app->register(new \Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => APP_BASEDIR.'/resources/template',
        ));

    }
}
