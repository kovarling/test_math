<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Withdrawal\CommissionTask\Scripts\MathScript;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/config.php');
$containerBuilder->useAnnotations(true);
$container = $containerBuilder->build();


try {
    $mathScript = $container->get(MathScript::class);
    foreach ($mathScript->perform() as $line) {
        echo "$line\n";
    }
} catch (\Exception $e) {
    $exceptionType = (new \ReflectionClass($e))->getShortName();
    echo "Exception of type $exceptionType was thrown with details below\n";
    print_r([
        $e->getCode(),
        $e->getFile(),
        $e->getLine(),
        $e->getMessage()
    ]);
}
