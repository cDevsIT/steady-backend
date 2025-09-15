<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Admin Login - Steady Formation</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .login-form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            position: relative;
        }
        
        .login-header {
            padding: 2rem 2rem 0 2rem;
            background: #ffffff;
            max-width: 1200px;
        }
        
        .login-form-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #ffffff;
        }
        
        .login-image-section {
            flex: 1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-content {
            max-width: 400px;
            width: 100%;
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-bottom: 0;
        }
        
        .logo-img {
            height: 40px;
            width: auto;
        }
        
        .welcome-text {
            margin-bottom: 2rem;
        }
        
        .welcome-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.2;
        }
        
        .welcome-subtitle {
            font-size: 16px;
            color: #6b7280;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.2s ease;
            background: #ffffff;
            position: relative;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-control.error {
            border-color: #ef4444;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-action-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: #ef4444;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .input-action-icon::before {
            content: '•••';
            color: white;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
        }
        
        .checkbox-input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: #667eea;
        }
        
        .checkbox-label {
            font-size: 14px;
            color: #374151;
        }
        
        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .forgot-link:hover {
            color: #5a67d8;
        }
        
        .btn-primary {
            width: 100%;
            padding: 12px 24px;
            background: #667eea;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #5a67d8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .login-image {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
        }
        
        .error-feedback {
            color: #ef4444;
            font-size: 14px;
            margin-top: 6px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-image-section {
                display: none;
            }
            
            .login-form-section {
                min-height: 100vh;
            }
            
            .login-header {
                padding: 1.5rem 1.5rem 0 1.5rem;
                margin: 0 auto;
            }
            
            .login-form-content {
                padding: 1.5rem;
            }
            
            .welcome-title {
                font-size: 28px;
            }
        }
        
        @media (max-width: 480px) {
            .login-header {
                padding: 1rem 1rem 0 1rem;
            }
            
            .login-form-content {
                padding: 1rem;
            }
            
            .welcome-title {
                font-size: 24px;
            }
            
            .form-control {
                padding: 10px 14px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Section - Login Form -->
        <div class="login-form-section">
            <!-- Header with Logo -->
            <div class="login-header">
                <a href="#" class="brand-logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Steady Formation Logo" class="logo-img">
                </a>
            </div>
            
            <!-- Login Form Content -->
            <div class="login-form-content">
                <div class="login-content">
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h1 class="welcome-title">Welcome back,</h1>
                        <p class="welcome-subtitle">Welcome back! Please enter your details.</p>
                    </div>
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-wrapper">
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') error @enderror" 
                                       value="{{ old('email', 'olee@goglobalbd.net') }}" 
                                       placeholder="Enter your email"
                                       required>
                                <div class="input-action-icon"></div>
                            </div>
                            @error('email')
                                <div class="error-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control @error('password') error @enderror" 
                                       value="••••••••"
                                       placeholder="Enter your password"
                                       required>
                                <div class="input-action-icon"></div>
                            </div>
                            @error('password')
                                <div class="error-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Form Options -->
                        <div class="form-options">
                            <div class="checkbox-group">
                                <input type="checkbox" id="remember" name="remember" class="checkbox-input">
                                <label for="remember" class="checkbox-label">Remember for 30 days</label>
                            </div>
                            <a href="#" class="forgot-link">Forgot password</a>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Right Section - Promotional Image -->
        <div class="login-image-section">
            <img src="{{ asset('assets/images/login-page-steady-formations.png') }}" 
                 alt="Steady Formation" 
                 class="login-image">
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            // Remove error styling on input
            function removeError(input) {
                input.classList.remove('error');
                const errorDiv = input.parentNode.querySelector('.error-feedback');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }
            
            // Add error styling
            function addError(input, message) {
                input.classList.add('error');
                let errorDiv = input.parentNode.querySelector('.error-feedback');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-feedback';
                    input.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            }
            
            // Real-time validation
            emailInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    removeError(this);
                }
            });
            
            passwordInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    removeError(this);
                }
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validate email
                if (emailInput.value.trim() === '') {
                    addError(emailInput, 'Email is required');
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                    addError(emailInput, 'Please enter a valid email address');
                    isValid = false;
                }
                
                // Validate password
                if (passwordInput.value.trim() === '') {
                    addError(passwordInput, 'Password is required');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
