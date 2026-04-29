<?php

namespace App\Http\Controllers;

use App\Models\GeneralDebt;
use App\Models\GeneralDebtPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeneralDebtController extends Controller
{
    public function index()
    {
        $debts = GeneralDebt::where('shop_id', Auth::user()->shop_id)
            ->with('recordedBy', 'payments.recordedBy')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $debts,
            'message' => 'General debts retrieved successfully',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedDebt($request);
        $data['shop_id'] = Auth::user()->shop_id;
        $data['recorded_by'] = Auth::id();
        $data['amount_paid'] = 0;
        $data['status'] = 'unpaid';

        return response()->json([
            'success' => true,
            'data' => GeneralDebt::create($data)->load('recordedBy'),
            'message' => 'General debt created successfully',
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => $this->findDebt($id)->load('recordedBy', 'payments.recordedBy'),
            'message' => 'General debt retrieved successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $debt = $this->findDebt($id);
        $data = $this->validatedDebt($request);

        if ((float) $data['amount'] < (float) $debt->amount_paid) {
            return response()->json([
                'success' => false,
                'message' => 'Debt amount cannot be less than payments already recorded.',
            ], 422);
        }

        $debt->update($data);
        $debt->refreshPaymentState();

        return response()->json([
            'success' => true,
            'data' => $debt->fresh()->load('recordedBy', 'payments.recordedBy'),
            'message' => 'General debt updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->findDebt($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'General debt deleted successfully',
        ]);
    }

    public function storePayment(Request $request, $id)
    {
        $debt = $this->findDebt($id);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . $debt->balance],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($debt, $data) {
            $data['recorded_by'] = Auth::id();
            $debt->payments()->create($data);
            $debt->refreshPaymentState();
        });

        return response()->json([
            'success' => true,
            'data' => $debt->fresh()->load('recordedBy', 'payments.recordedBy'),
            'message' => 'Payment recorded successfully',
        ], 201);
    }

    public function destroyPayment($debtId, $paymentId)
    {
        $debt = $this->findDebt($debtId);

        DB::transaction(function () use ($debt, $paymentId) {
            GeneralDebtPayment::where('general_debt_id', $debt->id)->findOrFail($paymentId)->delete();
            $debt->refreshPaymentState();
        });

        return response()->json([
            'success' => true,
            'data' => $debt->fresh()->load('recordedBy', 'payments.recordedBy'),
            'message' => 'Payment deleted successfully',
        ]);
    }

    private function validatedDebt(Request $request): array
    {
        return $request->validate([
            'debtor_name' => ['required', 'string', 'max:255'],
            'debtor_phone' => ['nullable', 'string', 'max:255'],
            'debtor_email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'debt_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:debt_date'],
        ]);
    }

    private function findDebt($id): GeneralDebt
    {
        return GeneralDebt::where('shop_id', Auth::user()->shop_id)->findOrFail($id);
    }
}
