<?php
namespace Aoloe\Demo;

use \Silex\Application as SilexApplication;
use \Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

class Application extends SilexApplication
{
    public function __construct()
    {
        parent::__construct();

        $app = $this;

        $app['debug'] = true;

        date_default_timezone_set('Europe/Zurich');

        $app['monolog.options'] = [
            'monolog.logfile' => APP_BASEDIR.'/var/logs/app.log',
            'monolog.name' => 'app',
            // 'monolog.level' => 300, // = Logger::WARNING
        ];
        $app->register(new \Silex\Provider\MonologServiceProvider(), $app['monolog.options']);


        $app->register(
            new \Silex\Provider\SessionServiceProvider([
                'session.storage.save_path' => APP_BASEDIR.'/var/sessions',
                'session.storage.options' => [
                    'cookie_lifetime' => (60 * 60 * 24), // 24 hours
                ]
            ])
        );
        $app->register(new \Silex\Provider\SecurityServiceProvider());

        $app['security.default_encoder'] = function ($app) {
            return new PlaintextPasswordEncoder();
        };

        $users = [
            'admin' => ['ROLE_USER', 'password']
        ];

        $app['security.firewalls'] = [
            'login_path' => array(
                'pattern' => '^/login$',
                'anonymous' => true
            ),
            'root' => [
                'pattern' => '^/.*$',
                'form' => [
                    'login_path' => '/login',
                    'check_path' => '/login_check'
                ],
                'logout' => [
                    'logout_path' => '/logout',
                    'invalidate_session' => false,
                ],
                'users' => $users,
            ],
        ];

        $app['security.access_rules'] = [
           ['^/login','IS_AUTHENTICATED_ANONYMOUSLY'],
           ['^.*$', 'ROLE_USER'],
        ];
        
        $app->boot();

        $app->register(new \Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => APP_BASEDIR.'/resources/template',
        ));

    }
}
