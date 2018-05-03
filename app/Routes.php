<?php

use App\Controllers\Articles\ArticleController;
use App\Controllers\HomeController;
use App\Middlewares\{CsrfMiddleware, OldInputMiddleware, ValidationErrorsMiddleware};
use Tuupola\Middleware\HttpBasicAuthentication;

/**
 * Web Routes
 */

$app->group('/', function () {
	$this->map(['GET', 'POST'],'', [HomeController::class, 'index'])->setName('home');
	$this->get('article', [HomeController::class, 'list'])->setname('article.index');
	$this->get('article/{id}', [HomeController::class, 'show'])->setname('article.show');
})->add(CsrfMiddleware::class);

/**
 * Api Routes
 */
$app->group('/api', function() {
    $this->group('/article', function () {
        $this->get('', [ArticleController::class, 'index']);
        $this->post('', [ArticleController::class, 'store']);
        $this->get('/{id:[0-9]+}', [ArticleController::class, 'show']);
        $this->put('/{id:[0-9]+}', [ArticleController::class, 'update']);
        $this->delete('/{id:[0-9]+}', [ArticleController::class, 'delete']);
        $this->get('/seed/{count:[0-9]+}', [ArticleController::class, 'seed']);
    });
});

/**
 * Global Middlewares
 */
$app->add(ValidationErrorsMiddleware::class);
$app->add(OldInputMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));
