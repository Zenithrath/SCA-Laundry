<?php
// Set up artisan environment
define('LARAVEL_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Manually test rendering
try {
    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
    
    // Create request to admin dashboard
    $request = \Illuminate\Http\Request::create('/admin', 'GET');
    
    // Test if view renders without error
    ob_start();
    try {
        $response = $kernel->handle($request);
        $content = ob_get_clean();
        
        echo "=== Response Status ===\n";
        echo "Status Code: " . $response->status() . "\n\n";
        
        echo "=== Content Checks ===\n";
        
        if (str_contains($response->content(), 'Admin Dashboard')) {
            echo "[OK] Admin Dashboard title found\n";
        } else {
            echo "[FAIL] Admin Dashboard title NOT found\n";
        }
        
        if (str_contains($response->content(), 'Kelola Layanan')) {
            echo "[OK] Services section found\n";
        } else {
            echo "[FAIL] Services section NOT found\n";
        }
        
        if (str_contains($response->content(), 'Laporan Keuangan')) {
            echo "[OK] Finance section found\n";
        } else {
            echo "[FAIL] Finance section NOT found\n";
        }
        
        echo "\nTotal content length: " . strlen($response->content()) . " bytes\n";
        
    } catch (\Exception $e) {
        ob_end_clean();
        echo "Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
} catch (\Exception $e) {
    echo "Bootstrap Error: " . $e->getMessage() . "\n";
}
?>
