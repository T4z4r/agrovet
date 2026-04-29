<?php

namespace App\Http\Controllers;

use App\Models\GeneralDebt;
use App\Models\GeneralDebtPayment;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebGeneralDebtController extends Controller
{
    public function index()
    {
        $query = GeneralDebt::with('shop', 'recordedBy')->latest();

        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('shop_id', Auth::user()->shop_id);
        }

        $debts = $query->get();

        return view('general-debts.index', compact('debts'));
    }

    public function create()
    {
        $shops = $this->availableShops();

        return view('general-debts.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedDebt($request);
        $data['shop_id'] = $this->resolveShopId($data['shop_id'] ?? null);
        $data['recorded_by'] = Auth::id();
        $data['amount_paid'] = 0;
        $data['status'] = 'unpaid';

        GeneralDebt::create($data);

        return redirect()->route('web.general-debts.index')->with('success', 'Debt created successfully');
    }

    public function show($id)
    {
        $debt = $this->findDebt($id)->load('shop', 'recordedBy', 'payments.recordedBy');

        return view('general-debts.show', compact('debt'));
    }

    public function edit($id)
    {
        $debt = $this->findDebt($id);
        $shops = $this->availableShops();

        return view('general-debts.edit', compact('debt', 'shops'));
    }

    public function update(Request $request, $id)
    {
        $debt = $this->findDebt($id);
        $data = $this->validatedDebt($request);
        $data['shop_id'] = $this->resolveShopId($data['shop_id'] ?? null);

        if ((float) $data['amount'] < (float) $debt->amount_paid) {
            return back()->withInput()->with('error', 'Debt amount cannot be less than payments already recorded.');
        }

        $debt->update($data);
        $debt->refreshPaymentState();

        return redirect()->route('web.general-debts.index')->with('success', 'Debt updated successfully');
    }

    public function destroy($id)
    {
        $this->findDebt($id)->delete();

        return redirect()->route('web.general-debts.index')->with('success', 'Debt deleted successfully');
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

        return redirect()->route('web.general-debts.show', $debt)->with('success', 'Payment recorded successfully');
    }

    public function destroyPayment($debtId, $paymentId)
    {
        $debt = $this->findDebt($debtId);

        DB::transaction(function () use ($debt, $paymentId) {
            GeneralDebtPayment::where('general_debt_id', $debt->id)->findOrFail($paymentId)->delete();
            $debt->refreshPaymentState();
        });

        return redirect()->route('web.general-debts.show', $debt)->with('success', 'Payment deleted successfully');
    }

    private function validatedDebt(Request $request): array
    {
        return $request->validate([
            'shop_id' => Auth::user()->hasRole('superadmin') ? ['required', 'exists:shops,id'] : ['nullable', 'exists:shops,id'],
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
        $query = GeneralDebt::query();

        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('shop_id', Auth::user()->shop_id);
        }

        return $query->findOrFail($id);
    }

    private function availableShops()
    {
        if (Auth::user()->hasRole('superadmin')) {
            return Shop::orderBy('name')->get();
        }

        return Shop::where('id', Auth::user()->shop_id)->get();
    }

    private function resolveShopId(?int $shopId): int
    {
        if (Auth::user()->hasRole('superadmin')) {
            return $shopId;
        }

        return Auth::user()->shop_id;
    }
}
