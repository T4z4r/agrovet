<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminOtp;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\Tasks\Backup\BackupJob;
use Illuminate\Support\Facades\Storage;

class WebAdminController extends Controller
{
    public function index()
    {
        // if (auth()->user()->role !== 'superadmin') {
        //     abort(403, 'Unauthorized');
        // }

        // Get list of tables, excluding system tables
        $tablesResult = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $allTables = array_map(function($t) use ($dbName) {
            return $t->{'Tables_in_' . $dbName};
        }, $tablesResult);

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

    public function sendOtp(Request $request)
    {
        $user = auth()->user();
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        AdminOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(30),
        ]);

        // Here you would send the OTP via SMS or email
        // For now, just return success

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function clear(Request $request, $table)
    {
        // if (auth()->user()->role !== 'superadmin') {
        //     abort(403, 'Unauthorized');
        // }

        $request->validate([
            'password' => 'required|string',
            'otp' => 'required|string',
        ]);

        // Check password
        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->route('web.admin.index')->with('error', 'Invalid password');
        }

        // Check OTP
        $adminOtp = AdminOtp::where('user_id', auth()->id())
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$adminOtp) {
            return redirect()->route('web.admin.index')->with('error', 'Invalid or expired OTP');
        }

        // Delete the used OTP
        $adminOtp->delete();

        // Validate table exists
        $tablesResult = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $allTables = array_map(function($t) use ($dbName) {
            return $t->{'Tables_in_' . $dbName};
        }, $tablesResult);

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
