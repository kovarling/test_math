<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Withdrawal\CommissionTask\Scripts\MathScript;

$container = new DI\Container();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

try {
    $mathScript = $container->get(MathScript::class);
    foreach ($mathScript->perform() as $line) {
        echo "$line\n";
    }
} catch (\Exception $e) {
    print_r([
        $e->getCode(),
        $e->getFile(),
        $e->getLine(),
        $e->getMessage()
    ]);
}
