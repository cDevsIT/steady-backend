<div class="modal fade" id="editPassword" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-0 py-3">
                <div class="modal-title-wrapper">
                    <h5 class="modal-title fw-bold text-dark mb-1" id="passwordModalLabel">
                        <i class="fas fa-key me-2 text-primary"></i>Change Password
                    </h5>
                    <p class="text-muted mb-0 small">Update your account password</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body bg-white p-4">
                <form action="{{route('passwordUpdate')}}" method="post" id="passwordForm">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="password" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-lock me-2 text-primary"></i>New Password
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   name="password" 
                                   class="form-control form-control-sm" 
                                   id="password" 
                                   placeholder="Enter new password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength mt-2" id="password-strength"></div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-muted small">
                            <i class="fas fa-check-circle me-2 text-success"></i>Confirm Password
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control form-control-sm" 
                                   id="password_confirmation" 
                                   placeholder="Confirm new password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                        <div class="password-match mt-2" id="password-match"></div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modal-content {
    border-radius: 12px;
    overflow: hidden;
}

.modal-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.modal-title {
    font-size: 1.1rem;
    color: #495057;
}

.modal-body {
    background: white;
}

.form-label {
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.password-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.form-control {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    padding-right: 2.5rem;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    outline: none;
}

.password-toggle {
    position: absolute;
    right: 0.5rem;
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.password-toggle:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.password-strength, .password-match {
    font-size: 0.75rem;
    padding: 0.375rem 0.5rem;
    border-radius: 6px;
    display: none;
}

.password-strength.weak {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    display: block;
}

.password-strength.medium {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    display: block;
}

.password-strength.strong {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    display: block;
}

.password-match.match {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    display: block;
}

.password-match.no-match {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    display: block;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-close {
    background: rgba(108, 117, 125, 0.1);
    border-radius: 50%;
    padding: 0.5rem;
    transition: all 0.2s ease;
}

.btn-close:hover {
    background: rgba(108, 117, 125, 0.2);
}
</style>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(inputId + '-eye');
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Password strength checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthDiv = document.getElementById('password-strength');
    
    if (password.length === 0) {
        strengthDiv.style.display = 'none';
        return;
    }
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    strengthDiv.className = 'password-strength mt-2';
    if (strength <= 2) {
        strengthDiv.classList.add('weak');
        strengthDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Weak password';
    } else if (strength <= 3) {
        strengthDiv.classList.add('medium');
        strengthDiv.innerHTML = '<i class="fas fa-info-circle me-1"></i>Medium strength password';
    } else {
        strengthDiv.classList.add('strong');
        strengthDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i>Strong password';
    }
});

// Password confirmation checker
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    const matchDiv = document.getElementById('password-match');
    
    if (confirmation.length === 0) {
        matchDiv.style.display = 'none';
        return;
    }
    
    if (password === confirmation) {
        matchDiv.className = 'password-match mt-2 match';
        matchDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i>Passwords match';
    } else {
        matchDiv.className = 'password-match mt-2 no-match';
        matchDiv.innerHTML = '<i class="fas fa-times-circle me-1"></i>Passwords do not match';
    }
});

// Form validation
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    
    if (password !== confirmation) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long!');
        return false;
    }
});
</script>
