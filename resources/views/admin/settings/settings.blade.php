@extends('admin.layouts.master')
@push('title')
    Settings
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">Settings</h1>
                    <p class="page-subtitle-modern">Manage website configuration and social media links</p>
                </div>
                <button type="submit" form="settingsForm" class="btn btn-primary-modern">
                    <i class="fas fa-save me-2"></i> Save Changes
                </button>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="row">
            <div class="col-12">
                <form action="{{route('admin.settings.update',$settings->id)}}" method="post" id="settingsForm">
                    @csrf
                    @method("PUT")
                    
                    <!-- Analytics Settings -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-chart-line me-2 text-primary"></i>Analytics & Tracking
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gtm" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-tag me-2 text-success"></i>Google Tag Manager (GTM)
                                        </label>
                                        <input type="text" 
                                               name="gtm" 
                                               value="{{$settings->gtm}}" 
                                               class="form-control form-control-sm"
                                               placeholder="GTM-XXXXXXX"
                                               id="gtm">
                                        <small class="text-muted">Enter your Google Tag Manager container ID</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Settings -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-share-alt me-2 text-primary"></i>Social Media Links
                            </h5>
                            <p class="text-muted mb-0 small">Configure your social media profile URLs</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Facebook -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="facebook_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-facebook me-2 text-primary"></i>Facebook URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-primary text-white">
                                                <i class="fab fa-facebook"></i>
                                            </span>
                                            <input type="url" 
                                                   name="facebook_url" 
                                                   value="{{$settings->facebook_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://facebook.com/yourpage"
                                                   id="facebook_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- Instagram -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="instagram_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-instagram me-2 text-danger"></i>Instagram URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-danger text-white">
                                                <i class="fab fa-instagram"></i>
                                            </span>
                                            <input type="url" 
                                                   name="instagram_url" 
                                                   value="{{$settings->instagram_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://instagram.com/yourprofile"
                                                   id="instagram_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- X (Twitter) -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="x_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-x-twitter me-2 text-dark"></i>X (Twitter) URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fab fa-x-twitter"></i>
                                            </span>
                                            <input type="url" 
                                                   name="x_url" 
                                                   value="{{$settings->x_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://x.com/yourhandle"
                                                   id="x_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- LinkedIn -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="linkedin_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-linkedin me-2 text-primary"></i>LinkedIn URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-primary text-white">
                                                <i class="fab fa-linkedin"></i>
                                            </span>
                                            <input type="url" 
                                                   name="linkedin_url" 
                                                   value="{{$settings->linkedin_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://linkedin.com/company/yourcompany"
                                                   id="linkedin_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- YouTube -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="youtube_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-youtube me-2 text-danger"></i>YouTube URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-danger text-white">
                                                <i class="fab fa-youtube"></i>
                                            </span>
                                            <input type="url" 
                                                   name="youtube_url" 
                                                   value="{{$settings->youtube_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://youtube.com/@yourchannel"
                                                   id="youtube_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- TikTok -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="tiktok_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-tiktok me-2 text-dark"></i>TikTok URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fab fa-tiktok"></i>
                                            </span>
                                            <input type="url" 
                                                   name="tiktok_url" 
                                                   value="{{$settings->tiktok_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://tiktok.com/@yourusername"
                                                   id="tiktok_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- Pinterest -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="pinterest_url" class="form-label fw-semibold text-muted small">
                                            <i class="fab fa-pinterest me-2 text-danger"></i>Pinterest URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-danger text-white">
                                                <i class="fab fa-pinterest"></i>
                                            </span>
                                            <input type="url" 
                                                   name="pinterest_url" 
                                                   value="{{$settings->pinterest_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://pinterest.com/yourprofile"
                                                   id="pinterest_url">
                                        </div>
                                    </div>
                                </div>

                                <!-- Threads -->
                                <div class="col-md-6 mb-3">
                                    <div class="social-input-group">
                                        <label for="threads_url" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-threads me-2 text-dark"></i>Threads URL
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-threads"></i>
                                            </span>
                                            <input type="url" 
                                                   name="threads_url" 
                                                   value="{{$settings->threads_url}}" 
                                                   class="form-control form-control-sm"
                                                   placeholder="https://threads.net/@yourusername"
                                                   id="threads_url">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
function resetForm() {
    if (confirm('Are you sure you want to reset all changes? This will revert to the last saved values.')) {
        document.getElementById('settingsForm').reset();
    }
}

// Add some interactive features
document.addEventListener('DOMContentLoaded', function() {
    // Add focus effects to input groups
    const inputGroups = document.querySelectorAll('.input-group');
    inputGroups.forEach(group => {
        const input = group.querySelector('input');
        input.addEventListener('focus', function() {
            group.style.transform = 'scale(1.02)';
            group.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            group.style.transform = 'scale(1)';
        });
    });
});
</script>
@endpush
