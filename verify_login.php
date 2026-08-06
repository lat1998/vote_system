<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$body = '{"email":"test@example.com","password":"secret"}';
$request = Illuminate\Http\Request::create('/api/login', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json'], $body);
$response = $app->handle($request);

echo $response->getStatusCode(), PHP_EOL;
echo $response->getContent(), PHP_EOL;
