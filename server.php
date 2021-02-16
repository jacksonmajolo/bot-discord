<?php

require_once 'init.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Lib\Application;
use Lib\Annotation\Command;
use App\Commands;

try {

    $reflectionClass = new ReflectionClass(Commands::class);
    $annotationReader = new AnnotationReader();

    $commands = [];
    foreach ($reflectionClass->getMethods() as $reflectionMethod) {
        $methodAnnotation = $annotationReader->getMethodAnnotation($reflectionMethod, Command::class);
        if (!$methodAnnotation) {
            continue;
        }

        $commands[$methodAnnotation->getCommand()] = $reflectionMethod->name;
    }

    $application = Application::getInstance();
    $application->discord->on('ready', function ($discord) use ($commands) {
        $discord->on('message', function ($message, $discord) use ($commands) {
            $method = (isset($message['content']) and isset($commands[$message['content']]) and $commands[$message['content']]) ? $commands[$message['content']] : NULL;
            if ($method and method_exists(Commands::class, $method)) {
                Commands::$method($discord, $message);
            }
        });
    }, function ($e) {
        echo $e->getMessage() . PHP_EOL;
    });

    $application->discord->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
