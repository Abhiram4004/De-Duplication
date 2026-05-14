<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $file = new \Illuminate\Http\UploadedFile('C:\\Users\\abhir\\OneDrive\\Documents\\Desktop\\De Dupilication of price list\\sample_price_list.csv', 'sample.csv', 'text/csv', null, true);
    
    $req = new \Illuminate\Http\Request();
    $req->files->set('file', $file);
    
    $user = \App\Models\User::first();
    auth()->login($user);
    
    $controller = app('App\Http\Controllers\UploadController');
    $response = $controller->store($req);
    
    print("Success!\n");
    if ($response->getSession()) {
        print("Session Success: " . session('success') . "\n");
        print("Session Error: " . session('error') . "\n");
    }
} catch (\Exception $e) {
    print("Exception thrown: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n");
}
