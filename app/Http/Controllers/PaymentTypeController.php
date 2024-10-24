<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentTypes = PaymentType::all();
        return view('payment_types.index', compact('paymentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255|unique:payment_types',
        ]);

        PaymentType::create($request->only('wording'));

        return redirect()->route('payement-types.index')
            ->with('success', 'Type de paiement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        return view('payment_types.show', compact('paymentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        return view('payment_types.edit', compact('paymentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $request->validate([
            'wording' => 'required|string|max:255|unique:payment_types,wording,' . $paymentType->id,
        ]);

        $paymentType->update($request->only('wording'));

        return redirect()->route('payement-types.index')
            ->with('success', 'Type de paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $paymentType->delete();

        return redirect()->route('payment_types.index')
            ->with('success', 'Type de paiement supprimé avec succès.');
    }
}
