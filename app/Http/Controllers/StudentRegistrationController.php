<?php

namespace App\Http\Controllers;

use App\Mail\StudentWelcomeMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Registration;
use App\Models\Classroom;
use App\Models\SchoolYear;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\PaymentMode;
use App\Models\PaymentType;
use App\Notifications\AdminPaymentNotification;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\StudentRegistered;
use App\Notifications\PaymentReceived;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class StudentRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $classrooms = Classroom::with('serie')->get();
        $currentSchoolYear = SchoolYear::current();
        return view('parent.register-student', compact('classrooms', 'currentSchoolYear'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'student_avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $temporaryPassword = Str::random(10);

        $student = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($temporaryPassword),
            'role_id' => 4, // Rôle étudiant
            'password_change_required' => true,
        ]);

        $avatarPath = $request->file('student_avatar')->store('avatars', 'public');

        $currentSchoolYear = SchoolYear::current();

        $registration = Registration::create([
            'student_id' => $student->id,
            'school_year_id' => $currentSchoolYear->id,
            'classroom_id' => $request->classroom_id,
            'student_avatar' => $avatarPath,
        ]);

        // Lier le parent à l'étudiant
        $parent = auth()->user();
        $parent->children()->attach($student->id);

        // Envoyer un email avec le mot de passe temporaire
        Mail::to($student->email)->send(new StudentWelcomeMail($student, $temporaryPassword));

        // Notifier le parent
        $parent->notify(new StudentRegistered($student));

        // Notifier les admins
        $admins = User::whereHas('role', function ($query) {
            $query->where('wording', 'admin');
        })->get();
        \Illuminate\Support\Facades\Notification::send($admins, new StudentRegistered($student));

        return redirect()->route('parent.dashboard')->with('success', 'Élève inscrit avec succès. Un email a été envoyé avec les informations de connexion.');
    }

    public function generateRegistrationForm($registrationId)
    {
        $registration = Registration::with(['student', 'classroom', 'schoolYear'])->findOrFail($registrationId);
        
         
        $imagePath = public_path('images/myschoologos.png');
         $pdf = Pdf::loadView('parent.registration-form', compact('registration', 'imagePath'));
        return $pdf->download( $registration->student->firstname . '_' . $registration->student->lastname . '_fiche_inscription.pdf');

    }

    public function showPaymentForm($registrationId)
    {
        $registration = Registration::with(['student', 'classroom', 'payments'])->findOrFail($registrationId);
        
        // Vérifiez si l'étudiant existe
        if (!$registration->student) {
            return redirect()->back()->with('error', 'Étudiant non trouvé pour cette inscription.');
        }

        $paymentTypes = PaymentType::all();
        $paymentModes = PaymentMode::all();

        $totalCost = $registration->classroom->costs;
        $totalPaid = $registration->payments->sum('amount');
        $remainingAmount = $totalCost - $totalPaid;

        $canPay = $remainingAmount > 0;

        $paymentCount = $registration->payments->count();
        if ($paymentCount == 0) {
            $suggestedPartialAmount = $totalCost / 3;
        } elseif ($paymentCount == 1) {
            $suggestedPartialAmount = $remainingAmount / 2;
        } else {
            $suggestedPartialAmount = $remainingAmount;
        }

        return view('parent.payment-form', compact('registration', 'paymentTypes', 'paymentModes', 'remainingAmount', 'canPay', 'suggestedPartialAmount'));
    }

    public function processPayment(Request $request, $registrationId)
    {
        $registration = Registration::with('student', 'classroom', 'payments')->findOrFail($registrationId);

        $request->validate([
            // 'payment_mode' => 'required|in:1,2',
            'payment_type_id' => 'required|exists:payment_types,id',
            'payment_mode_id' => 'required|exists:payment_modes,id',
        ]);

        $totalCost = $registration->classroom->costs;
        $totalPaid = $registration->payments->sum('amount');
        $remainingAmount = $totalCost - $totalPaid;

        if ($request->payment_mode === 'total') {
            $amountToPay = $remainingAmount;
        } else { // tranche
            $amountToPay = ceil($totalCost / 3);
            if ($amountToPay > $remainingAmount) {
                $amountToPay = $remainingAmount;
            }
        }

        // Vérifier si le montant à payer est valide
        if ($amountToPay <= 0 || $amountToPay > $remainingAmount) {
            return redirect()->back()->with('error', 'Montant de paiement invalide.');
        }

        $payment = Payment::create([
            'amount' => $amountToPay,
            'registration_id' => $registration->id,
            'student_id' => $registration->student_id,
            'classroom_id' => $registration->classroom->id,
            'payment_type_id' => $request->payment_type_id,
            'payment_mode_id' => $request->payment_mode_id,
        ]);

        $totalPaid = $registration->payments->sum('amount') + $amountToPay;
        $remainingAmount = $registration->classroom->costs - $totalPaid;
        $isFullPayment = $remainingAmount <= 0;
    
        // Envoyer une notification au parent pour les dit ce qu'il ont payer et leur informer de ce qui reste
        $parent = auth()->user();
        $parent->notify(new PaymentNotification($payment, $remainingAmount, $isFullPayment));

        // Envoyer une notification aux admins pour les notifier que un paiement a été effectué
        $admins = User::whereHas('role', function ($query) {
            $query->where('wording', 'admin');
        })->get();
    
        \Illuminate\Support\Facades\Notification::send($admins, new AdminPaymentNotification($payment, $remainingAmount));

        return redirect()->route('parent.dashboard')->with('success', 'Paiement effectué avec succès.');
    }
}
