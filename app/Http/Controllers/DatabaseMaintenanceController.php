<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DatabaseMaintenanceController extends Controller
{
    public function renameWpTables()
    {
        $database = env('DB_DATABASE');

        $tables = DB::table('information_schema.tables')
            ->where('table_schema', $database)
            ->where('table_name', 'like', 'Lubpo8Jc8_%')
            ->pluck('table_name');

        $renamed = [];
        $failed = [];

        foreach ($tables as $oldTableName) {
            $newTableName = str_replace('lubpo8jc8_', 'wp_', $oldTableName);
            $renameSql = "RENAME TABLE `$oldTableName` TO `$newTableName`;";

            try {
                DB::statement($renameSql);
                $renamed[] = "$oldTableName → $newTableName";
            } catch (\Exception $e) {
                $failed[] = "❌ Failed: $oldTableName → " . $e->getMessage();
            }
        }

        return response()->json([
            'status' => 'done',
            'renamed_tables' => $renamed,
            'failed_tables' => $failed,
        ]);
    }
}
