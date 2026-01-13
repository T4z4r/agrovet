<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use OwenIt\Auditing\Models\Audit;

class WebAuditController extends Controller
{
    /**
     * Display a listing of the audits.
     */
    public function index(): View
    {
        $audits = Audit::with('user')->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.audits.index', compact('audits'));
    }
}