<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

try {
    if (Schema::hasTable('obat')) {
        Schema::table('obat', function (Blueprint $table) {
            if (Schema::hasColumn('obat', 'harga') && !Schema::hasColumn('obat', 'harga_obat')) {
                echo "Renaming 'harga' to 'harga_obat' in 'obat' table...\n";
                $table->renameColumn('harga', 'harga_obat');
            }
            if (!Schema::hasColumn('obat', 'stok')) {
                echo "Adding 'stok' column to 'obat' table...\n";
                $table->integer('stok')->default(0);
            }
        });
        echo "Database fix completed successfully.\n";
    } else {
        echo "Table 'obat' not found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
