<?php

require_once 'init.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Discord\Parts\Channel\Message;
use Lib\Application;
use Lib\Annotation\Command;
use App\Commands;

try {
    $application = Application::getInstance();

    $annotationReader = new AnnotationReader();

    $reflectionClass = new ReflectionClass(Commands::class);
    foreach ($reflectionClass->getMethods() as $reflectionMethod) {
        $methodAnnotation = $annotationReader->getMethodAnnotation($reflectionMethod, Command::class);
        if (!$methodAnnotation) {
            continue;
        }

        $command = $reflectionMethod->name;
        $application->discord->registerCommand($methodAnnotation->getCommand(), function (Message $message) use ($application, $command) {
            $logger = $application->discord->getLogger();
            if ($logger) {
                $logger->info("{$message->member->username}: {$message->content}");
            }

            Commands::$command($application->discord, $message);
        });
    }

    $application->discord->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
