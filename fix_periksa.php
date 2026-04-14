<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "=== Poliklinik Fix: Add status_periksa column ===\n\n";

$table = 'daftar_poli';
$column = 'status_periksa';

if (Schema::hasTable($table)) {
    echo "✓ Table '$table' exists.\n";
    
    if (!Schema::hasColumn($table, $column)) {
        echo "✗ Column '$column' missing. Adding...\n";
        DB::statement("ALTER TABLE `$table` ADD COLUMN `$column` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `no_antrian`");
        echo "✓ Column '$column' added successfully.\n";
    } else {
        echo "✓ Column '$column' already exists.\n";
    }
    
    // Verify
    $describe = DB::select("DESCRIBE `$table`");
    $hasColumn = false;
    foreach ($describe as $field) {
        if ($field->Field === $column) {
            $hasColumn = true;
            echo "✓ Verified: $column ({$field->Type}, default: {$field->Default})\n";
            break;
        }
    }
    
    if (!$hasColumn) {
        echo "✗ Verification failed.\n";
        exit(1);
    }
} else {
    echo "✗ Table '$table' does not exist!\n";
    exit(1);
}

echo "\n=== Fix completed safely. Test your patient dashboard now! ===\n";
echo "Run: php artisan route:clear && php artisan cache:clear\n";

