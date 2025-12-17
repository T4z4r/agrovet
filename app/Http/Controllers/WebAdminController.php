<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WebAdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        // Get list of tables, excluding system tables
        $allTables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        $systemTables = ['migrations', 'cache', 'jobs', 'personal_access_tokens', 'failed_jobs', 'password_resets', 'sessions'];
        $tables = array_diff($allTables, $systemTables);

        $tableData = [];
        foreach ($tables as $table) {
            $count = DB::table($table)->count();
            $tableData[] = [
                'name' => $table,
                'count' => $count,
            ];
        }

        return view('admin.index', compact('tableData'));
    }

    public function clear(Request $request, $table)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        // Validate table exists
        $allTables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        if (!in_array($table, $allTables)) {
            return redirect()->route('web.admin.index')->with('error', 'Table not found');
        }

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table($table)->truncate();
            $message = "Table {$table} cleared successfully";
        } catch (\Exception $e) {
            $message = "Error clearing table {$table}: " . $e->getMessage();
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return redirect()->route('web.admin.index')->with('success', $message);
    }
}
