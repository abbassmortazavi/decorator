<?php


namespace App\Domain\Product\Providers;


use App\Infrastructure\Abstracts\BaseServiceProvider;

class DomainServiceProvider extends BaseServiceProvider
{
    protected string $alias = 'product';

    protected bool $hasViews = true;

    protected bool $hasMigrations = true;

    protected bool $hasTranslations = true;

    protected array $providers = [
        RouteServiceProvider::class,
    ];
}
