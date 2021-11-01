<?php

use Withdrawal\CommissionTask\Currencies\Strategies\ApiCurrencyProvider;
use Withdrawal\CommissionTask\Currencies\Strategies\CurrencyProviderFactory;
use Withdrawal\CommissionTask\Currencies\Strategies\LocalCurrencyProvider;
use Withdrawal\CommissionTask\Operations\Strategies\AbstractOperationStrategy;
use Withdrawal\CommissionTask\Operations\Strategies\DepositBusinessOperationStrategy;
use Withdrawal\CommissionTask\Operations\Strategies\DepositPrivateOperationStrategy;
use Withdrawal\CommissionTask\Operations\Strategies\WithdrawBusinessOperationStrategy;
use Withdrawal\CommissionTask\Operations\Strategies\WithdrawPrivateOperationStrategy;
use Withdrawal\CommissionTask\Scripts\MathScript;
use Withdrawal\CommissionTask\Service\Math;

return [
    Math::class => DI\autowire()
        ->constructorParameter('scale', (int)$_ENV['BC_DEFAULT_SCALE']),

    ApiCurrencyProvider::class => DI\autowire()
        ->constructorParameter('location', $_ENV['RATES_LOCATION_API'])
        ->constructorParameter('baseCurrency', $_ENV['RATES_BASE_CURRENCY'])
        ->constructorParameter('apiKey', $_ENV['RATES_API_KEY'])
        ->constructorParameter('apiEndpoint', $_ENV['RATES_API_ENDPOINT']),

    CurrencyProviderFactory::class => DI\autowire()
        ->constructorParameter('strategyClass', $_ENV['RATES_STRATEGY']),

    LocalCurrencyProvider::class => DI\autowire()
        ->constructorParameter('location', $_ENV['RATES_LOCATION_LOCAL']),

    DepositBusinessOperationStrategy::class => DI\autowire()
        ->constructorParameter('baseCurrency', $_ENV['RATES_BASE_CURRENCY'])
        ->constructorParameter('fee', $_ENV['DEPOSIT_BUSINESS_FEE']),

    DepositPrivateOperationStrategy::class => DI\autowire()
        ->constructorParameter('baseCurrency', $_ENV['RATES_BASE_CURRENCY'])
        ->constructorParameter('fee', $_ENV['DEPOSIT_PRIVATE_FEE']),

    WithdrawBusinessOperationStrategy::class => DI\autowire()
        ->constructorParameter('baseCurrency', $_ENV['RATES_BASE_CURRENCY'])
        ->constructorParameter('fee', $_ENV['WITHDRAW_BUSINESS_FEE']),

    WithdrawPrivateOperationStrategy::class => DI\autowire()
        ->constructorParameter('baseCurrency', $_ENV['RATES_BASE_CURRENCY'])
        ->constructorParameter('fee', $_ENV['WITHDRAW_PRIVATE_FEE'])
        ->constructorParameter('freeLimit', $_ENV['WITHDRAW_FREE_LIMIT'])
        ->constructorParameter('freeCount', (int)$_ENV['WITHDRAW_FREE_COUNT']),

    MathScript::class => DI\autowire()
        ->constructorParameter('path', $_ENV['OPERATIONS_PATH'])
];