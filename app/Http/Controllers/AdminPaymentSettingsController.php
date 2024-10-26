<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class AdminPaymentSettingsController extends Controller
{
    public function index()
    {
        $paymentModes = PaymentMode::all();
        $paymentTypes = PaymentType::all();
        return view('admin.payment-settings', compact('paymentModes', 'paymentTypes'));
    }

    public function storePaymentMode(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255|unique:payment_modes,wording'
        ]);

        PaymentMode::create($request->all());

        return redirect()->route('admin.payment-settings')->with('success', 'Mode de paiement ajouté avec succès.');
    }

    public function storePaymentType(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255|unique:payment_types,wording',
            'is_partial' => 'required|boolean'
        ]);

        PaymentType::create([
            'wording' => $request->wording,
            'is_partial' => $request->is_partial
        ]);

        return redirect()->route('admin.payment-settings')->with('success', 'Type de paiement ajouté avec succès.');
    }

    public function destroyPaymentMode(PaymentMode $paymentMode)
    {
        $paymentMode->delete();
        return redirect()->route('admin.payment-settings')->with('success', 'Mode de paiement supprimé avec succès.');
    }

    public function destroyPaymentType(PaymentType $paymentType)
    {
        $paymentType->delete();
        return redirect()->route('admin.payment-settings')->with('success', 'Type de paiement supprimé avec succès.');
    }
}
