<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Checking Controller Methods ===\n\n";

try {
    $controller = new Chatify\Http\Controllers\Api\MessagesController();
    echo "Controller loaded: " . get_class($controller) . "\n\n";

    echo "Checking specific methods:\n";
    echo "  idFetchData exists: " . (method_exists($controller, 'idFetchData') ? 'YES' : 'NO') . "\n";
    echo "  send exists: " . (method_exists($controller, 'send') ? 'YES' : 'NO') . "\n";
    echo "  deleteConversation exists: " . (method_exists($controller, 'deleteConversation') ? 'YES' : 'NO') . "\n";
    echo "  deleteConversationForMe exists: " . (method_exists($controller, 'deleteConversationForMe') ? 'YES' : 'NO') . "\n";

    echo "\nAll methods containing 'delete':\n";
    $methods = get_class_methods($controller);
    foreach($methods as $method) {
        if(stripos($method, 'delete') !== false) {
            echo "  - " . $method . "\n";
        }
    }

    echo "\nAll public methods:\n";
    foreach($methods as $method) {
        echo "  - " . $method . "\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
