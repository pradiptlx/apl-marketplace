<?php

use Idy\Idea\Application\CreateNewIdea\CreateNewIdeaService;
use Idy\Idea\Application\RateIdea\RateIdeaService;
use Idy\Idea\Application\ViewAllIdeas\ViewAllIdeasService;
use Idy\Idea\Application\VoteIdea\VoteIdeaService;
use Idy\Idea\Infrastructure\Transport\SwiftMailer;
use Phalcon\Mvc\View;
use Idy\Idea\Infrastructure\Persistence\SqlIdeaRepository;

$di['voltServiceMail'] = function($view) use ($di) {

    $config = $di->get('config');

    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
    if (!is_dir($config->mail->cacheDir)) {
        mkdir($config->mail->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT' ? true : false;

    $volt->setOptions(array(
        "compiledPath" => $config->mail->cacheDir,
        "compiledExtension" => ".compiled",
        "compileAlways" => $compileAlways
    ));
    return $volt;
};

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$di['db'] = function () use ($di) {

    $config = $di->get('config');

    $dbAdapter = $config->database->adapter;

    return new $dbAdapter([
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ]);
};


$di->set('swiftMailerTransport', function ()  use ($di) {
    $config = $di->get('config');
    $transport = (new Swift_SmtpTransport($config->mail->smtp->server, $config->mail->smtp->port))
        ->setUsername($config->mail->smtp->username)
        ->setPassword($config->mail->smtp->password);

    return $transport;
});

$di->set('swiftMailer', function () use ($di) {
    $mailer = new Swift_Mailer($di->get('swiftMailerTransport'));

    return new SwiftMailer($mailer);
});

$di->set('ideaRepository', function() use ($di) {
    return new SqlIdeaRepository($di->get('db'));
});

$di->set('viewAllIdeasService', function () use ($di) {
   return new ViewAllIdeasService($di->get('ideaRepository'));
});

$di->set('createNewIdeaService', function () use ($di) {
   return new CreateNewIdeaService($di->get('ideaRepository'));
});

$di->set('voteIdeaService', function () use ($di) {
   return new VoteIdeaService($di->get('ideaRepository'));
});

$di->set('rateIdeaService', function () use ($di) {
   return new RateIdeaService($di->get('ideaRepository'));
});
