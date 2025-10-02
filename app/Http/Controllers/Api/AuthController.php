<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\PasswordResetOTP;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            if (!$user->active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Account is inactive'
                ], 403);
            }

            // Create token
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'role' => $user->role,
                        'active' => $user->active,
                        'full_name' => $user->full_name,
                        'country_of_residence' => $user->country_of_residence,
                        'timezone' => $user->timezone,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register new user
     */
    public function signup(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|same:password',
                'phone' => 'nullable|string|max:20',
                'country_of_residence' => 'nullable|string|max:255',
                'timezone' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if email already exists
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already exists'
                ], 409);
            }

            // Create user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'temp_password' => $request->password,
                'role' => 2, // Customer role
                'active' => true,
                'country_of_residence' => $request->country_of_residence ?? 'USA',
                'timezone' => $request->timezone ?? config('app.timezone'),
            ]);

            // Create token
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'role' => $user->role,
                        'active' => $user->active,
                        'full_name' => $user->full_name,
                        'country_of_residence' => $user->country_of_residence,
                        'timezone' => $user->timezone,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'active' => $user->active,
                    'full_name' => $user->full_name,
                    'country_of_residence' => $user->country_of_residence,
                    'timezone' => $user->timezone,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get user info',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user's companies
     */
    public function userCompanies(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            // Debug: Log the API call
            \Log::info('User companies API called', [
                'user_id' => $user->id,
                'email' => $user->email,
                'timestamp' => now()
            ]);
            
            $companies = Company::where('user_id', $user->id)
                ->with(['order'])
                ->latest()
                ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $companies
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in userCompanies API', [
                'error' => $e->getMessage(),
                'user_id' => $request->user()?->id
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get user companies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user's profile information
     */
    public function userProfile(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'country_of_residence' => $user->country_of_residence ?? 'USA',
                    'timezone' => $user->timezone ?? config('app.timezone'),
                    'avatar' => $user->avatar,
                    'role' => $user->role,
                    'active' => $user->active,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update authenticated user's profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            // Debug: Log the incoming request data
            \Log::info('Profile update request data:', $request->all());
            
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'country_of_residence' => 'nullable|string|max:255',
                'timezone' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();
            
            $user->first_name = trim($request->first_name);
            $user->last_name = trim($request->last_name);
            // Email is not updated for security reasons
            $user->phone = $request->phone ? trim($request->phone) : null;
            $user->country_of_residence = $request->country_of_residence ? trim($request->country_of_residence) : null;
            $user->timezone = $request->timezone ? trim($request->timezone) : null;
            $user->save();

            \Log::info('Profile updated successfully for user:', ['user_id' => $user->id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'country_of_residence' => $user->country_of_residence,
                    'timezone' => $user->timezone,
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile update failed:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload avatar for authenticated user
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        try {
            \Log::info('Avatar upload request received', [
                'has_file' => $request->hasFile('avatar'),
                'file_size' => $request->file('avatar') ? $request->file('avatar')->getSize() : 'no file',
                'file_type' => $request->file('avatar') ? $request->file('avatar')->getMimeType() : 'no file'
            ]);

            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            if ($validator->fails()) {
                \Log::error('Avatar validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();
            \Log::info('Processing avatar upload for user:', ['user_id' => $user->id]);

            // Delete old avatar if exists
            if ($user->avatar) {
                $oldAvatarPath = public_path('storage/' . $user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                    \Log::info('Deleted old avatar:', ['path' => $oldAvatarPath]);
                }
            }

            // Store new avatar
            $avatar = $request->file('avatar');
            $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');

            \Log::info('Avatar stored successfully:', [
                'original_name' => $avatar->getClientOriginalName(),
                'stored_path' => $avatarPath,
                'file_size' => $avatar->getSize()
            ]);

            // Update user avatar
            $user->avatar = $avatarPath;
            $user->save();

            \Log::info('User avatar updated in database:', ['user_id' => $user->id, 'avatar' => $avatarPath]);

            return response()->json([
                'status' => 'success',
                'message' => 'Avatar uploaded successfully',
                'data' => [
                    'avatar' => $avatarPath,
                    'avatar_url' => asset('storage/' . $avatarPath)
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Avatar upload failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload avatar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get company details for the authenticated user
     */
    public function userCompany(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $companyId = $request->query('company_id');
            
            // Get company by ID if provided, otherwise get the first company
            $query = Company::with(['order', 'owners'])
                ->where('user_id', $user->id);
            
            if ($companyId) {
                $company = $query->where('id', $companyId)->first();
            } else {
                $company = $query->first();
            }

            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No company found for this user'
                ], 404);
            }

            // Format the response based on the company page requirements
            $companyData = [
                'company_name' => $company->company_name,
                'entity_type' => $company->business_type,
                'ein' => $company->order?->ein_number ?? 'N/A',
                'business_address' => $company->plan_street_address ? 
                    $company->plan_street_address . ', ' . $company->plan_city . ', ' . $company->plan_state . ', ' . $company->plan_zip_country :
                    'N/A',
                'registration_date' => $company->incorporation_date ? 
                    date('d M, Y', strtotime($company->incorporation_date)) : 
                    'N/A',
                'renewal_date' => $company->renewal_date ? 
                    date('d M, Y', strtotime($company->renewal_date)) : 
                    'N/A',
                'formation_state' => $company->order?->state_name ?? 'N/A',
                'status' => $company->order?->compliance_status ?? 'Active',
                'headquarters' => $company->plan_city && $company->plan_zip_country ? 
                    $company->plan_city . ', ' . $company->plan_zip_country : 
                    'N/A',
                'address_line_1' => $company->plan_street_address ?? 'N/A',
                'address_line_2' => $company->plan_city . ', ' . $company->plan_state ?? 'N/A',
                'zip' => $company->plan_zip_code ?? 'N/A',
                'address_status' => 'Active',
                'last_mail_received_date' => 'N/A', // This field doesn't exist in current schema
                'upgrade_premium_address' => 'If free'
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Company details retrieved successfully',
                'data' => $companyData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve company details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update authenticated user's password
     */
    public function updatePassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();

            // Check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update password',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate temporary login token and return user credentials
     */
    public function validateTempToken(Request $request): JsonResponse
    {
        try {
            $tempToken = $request->query('temp_login_token');
            
            if (!$tempToken) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Temporary token is required'
                ], 400);
            }

            $user = User::where('temp_login_token', $tempToken)
                       ->where('temp_token_expires_at', '>', now())
                       ->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid or expired temporary token'
                ], 400);
            }

            // Clear the temporary token
            $user->temp_login_token = null;
            $user->temp_token_expires_at = null;
            $user->save();

            // Return user credentials for auto-login
            return response()->json([
                'status' => 'success',
                'message' => 'Temporary token validated successfully',
                'data' => [
                    'email' => $user->email,
                    'temp_password' => $user->temp_password,
                    'user_id' => $user->id
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to validate temporary token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user (Revoke the token)
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send OTP for password reset
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            
            // Check if user exists and is active
            $user = User::where('email', $email)->where('active', true)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No active account found with this email address'
                ], 404);
            }

            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store OTP in cache for 10 minutes
            $cacheKey = "password_reset_otp_{$email}";
            Cache::put($cacheKey, [
                'otp' => $otp,
                'user_id' => $user->id,
                'attempts' => 0
            ], 600); // 10 minutes

            // Send OTP via email
            try {
                Mail::to($email)->send(new PasswordResetOTP($otp, $user->full_name, 10));
                
                Log::info('Password Reset OTP sent via email', [
                    'email' => $email,
                    'user_id' => $user->id,
                    'expires_at' => now()->addMinutes(10)
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to send OTP email', [
                    'email' => $email,
                    'error' => $mailException->getMessage()
                ]);
                
                // Still return success but log the email failure
                // The OTP is still valid and can be used
            }

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully to your email address. Please check your email (including spam folder).',
                'data' => [
                    'email' => $email,
                    'expires_in' => 600, // 10 minutes in seconds
                    'debug_otp' => $otp // Remove this in production - for testing only
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Forgot password failed:', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'not provided'
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP for password reset
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp' => 'required|string|size:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            $otp = $request->otp;
            
            $cacheKey = "password_reset_otp_{$email}";
            $cachedData = Cache::get($cacheKey);

            if (!$cachedData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'OTP has expired or is invalid'
                ], 400);
            }

            // Check attempts limit
            if ($cachedData['attempts'] >= 3) {
                Cache::forget($cacheKey);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Too many failed attempts. Please request a new OTP'
                ], 429);
            }

            // Verify OTP
            if ($cachedData['otp'] !== $otp) {
                // Increment attempts
                $cachedData['attempts']++;
                Cache::put($cacheKey, $cachedData, 600);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP'
                ], 400);
            }

            // Generate reset token
            $resetToken = Str::random(60);
            $resetCacheKey = "password_reset_token_{$resetToken}";
            
            // Store reset token for 30 minutes
            Cache::put($resetCacheKey, [
                'email' => $email,
                'user_id' => $cachedData['user_id']
            ], 1800); // 30 minutes

            // Clear OTP cache
            Cache::forget($cacheKey);

            Log::info('OTP verified successfully for password reset', [
                'email' => $email,
                'user_id' => $cachedData['user_id']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully',
                'data' => [
                    'token' => $resetToken,
                    'expires_in' => 1800 // 30 minutes in seconds
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('OTP verification failed:', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'not provided'
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to verify OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend OTP for password reset
     */
    public function resendOtp(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            
            // Check if user exists and is active
            $user = User::where('email', $email)->where('active', true)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No active account found with this email address'
                ], 404);
            }

            // Generate new 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store OTP in cache for 10 minutes
            $cacheKey = "password_reset_otp_{$email}";
            Cache::put($cacheKey, [
                'otp' => $otp,
                'user_id' => $user->id,
                'attempts' => 0
            ], 600); // 10 minutes

            // Send OTP via email
            try {
                Mail::to($email)->send(new PasswordResetOTP($otp, $user->full_name, 10));
                
                Log::info('Password Reset OTP resent via email', [
                    'email' => $email,
                    'user_id' => $user->id,
                    'expires_at' => now()->addMinutes(10)
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to resend OTP email', [
                    'email' => $email,
                    'error' => $mailException->getMessage()
                ]);
                
                // Still return success but log the email failure
                // The OTP is still valid and can be used
            }

            return response()->json([
                'status' => 'success',
                'message' => 'OTP resent successfully to your email address. Please check your email (including spam folder).',
                'data' => [
                    'email' => $email,
                    'expires_in' => 600, // 10 minutes in seconds
                    'debug_otp' => $otp // Remove this in production - for testing only
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Resend OTP failed:', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'not provided'
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to resend OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset password using token
     */
    public function resetPassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'token' => 'required|string',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            $token = $request->token;
            $password = $request->password;
            
            $resetCacheKey = "password_reset_token_{$token}";
            $cachedData = Cache::get($resetCacheKey);

            if (!$cachedData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Reset token has expired or is invalid'
                ], 400);
            }

            // Verify email matches
            if ($cachedData['email'] !== $email) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid reset token for this email'
                ], 400);
            }

            // Get user and update password
            $user = User::find($cachedData['user_id']);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

            // Update password
            $user->password = Hash::make($password);
            $user->save();

            // Clear reset token
            Cache::forget($resetCacheKey);

            // Revoke all existing tokens for security
            $user->tokens()->delete();

            Log::info('Password reset successfully', [
                'user_id' => $user->id,
                'email' => $email
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully. Please login with your new password.',
                'data' => [
                    'email' => $email
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Password reset failed:', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'not provided'
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reset password',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 