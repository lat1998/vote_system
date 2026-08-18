<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$body = '{"email":"test@example.com","password":"secret"}';
$request = Illuminate\Http\Request::create('/api/login', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json'], $body);

var_dump($request->getContent());
echo PHP_EOL;
var_dump($request->json()->all());
echo PHP_EOL;
var_dump($request->all());
