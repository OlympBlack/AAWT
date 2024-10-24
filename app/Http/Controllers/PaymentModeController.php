<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    public function index()
    {
        $paymentModes = PaymentMode::all();
        return view('payment_modes.index', compact('paymentModes'));
    }

    public function create()
    {
        return view('payment_modes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'wording' => 'required|string|max:255',
        ]);

        PaymentMode::create($validatedData);

        return redirect()->route('payement-modes.index')->with('success', 'Mode de paiement créé avec succès.');
    }

    public function show(PaymentMode $paymentMode)
    {
        return view('payment_modes.show', compact('paymentMode'));
    }

    public function edit(PaymentMode $paymentMode)
    {
        return view('payment_modes.edit', compact('paymentMode'));
    }

    public function update(Request $request, PaymentMode $paymentMode)
    {
        $validatedData = $request->validate([
            'wording' => 'required|string|max:255',
        ]);

        $paymentMode->update($validatedData);

        return redirect()->route('payement-modes.index')->with('success', 'Mode de paiement mis à jour avec succès.');
    }

    public function destroy(PaymentMode $paymentMode)
    {
        $paymentMode->delete();

        return redirect()->route('payement-modes.index')->with('success', 'Mode de paiement supprimé avec succès.');
    }
}
