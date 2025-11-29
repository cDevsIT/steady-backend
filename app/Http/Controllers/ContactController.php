<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormNotification;
use App\Mail\ContactFormConfirmation;
use App\Models\GetInTouch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'countryCode' => 'nullable|string|max:10',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'privacy' => 'required|boolean|accepted'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Save to database
            $contactData = [
                'name' => $request->firstName . ' ' . $request->lastName, // Keep for backward compatibility
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            // Add optional fields if provided
            if ($request->phone) {
                $contactData['phone'] = $request->phone;
            }
            if ($request->countryCode) {
                $contactData['country_code'] = $request->countryCode;
            }

            $contact = GetInTouch::create($contactData);

            // Send email to admin (don't fail if email fails)
            try {
                $adminEmail = env('ADMIN_EMAIL', 'info@steadyformation.com');
                
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new ContactFormNotification([
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'countryCode' => $request->countryCode ?? '+1',
                        'subject' => $request->subject,
                        'message' => $request->message,
                    ]));
                }
            } catch (\Exception $emailError) {
                \Log::error('Failed to send contact form email: ' . $emailError->getMessage());
            }

            // Send confirmation email to user (don't fail if email fails)
            try {
                $userEmail = $request->email;
                
                if ($userEmail) {
                    Mail::to($userEmail)->send(new ContactFormConfirmation([
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'subject' => $request->subject,
                    ]));
                }
            } catch (\Exception $emailError) {
                \Log::error('Failed to send confirmation email: ' . $emailError->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us! We will get back to you soon.',
                'data' => $contact
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Contact form submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit your message. Please try again later.'
            ], 500);
        }
    }
}

