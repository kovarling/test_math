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

$mathScript = $container->get(MathScript::class);
$mathScript->output();