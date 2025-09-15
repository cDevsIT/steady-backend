@extends('admin.layouts.master')
@push('title')
    Create Blog Post
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Create New Blog Post</h1>
                    <p class="page-subtitle-modern">Write and publish engaging content for your audience</p>
                </div>
                <div class="header-actions">
                    <a href="{{route('blogs.index')}}" class="btn btn-outline-secondary-modern me-2">
                        <i class="fas fa-arrow-left me-2"></i> Back to Posts
                    </a>
                    <button type="submit" form="blogForm" class="btn btn-primary-modern">
                        <i class="fas fa-paper-plane me-2"></i> Publish Post
                    </button>
                </div>
            </div>
        </div>

        <!-- Blog Form -->
        <div class="row">
            <div class="col-12">
                <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-heading me-2 text-primary"></i>Post Title <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               required 
                                               value="{{old('title')}}" 
                                               class="form-control form-control-sm" 
                                               id="title" 
                                               name="title"
                                               placeholder="Enter a compelling title for your blog post">
                                        @error('title')
                                            <div class="text-danger mt-1 small">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="feature_image" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-image me-2 text-success"></i>Feature Image <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" 
                                               name="feature_image" 
                                               id="feature_image" 
                                               class="form-control form-control-sm"
                                               accept="image/*">
                                        @error('feature_image')
                                            <div class="text-danger mt-1 small">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-align-left me-2 text-info"></i>Description <span class="text-danger">*</span>
                                </label>
                                <input type="text"  
                                       required  
                                       class="form-control form-control-sm" 
                                       id="description" 
                                       name="description" 
                                       value="{{old('description')}}"
                                       placeholder="Brief description of your blog post">
                                @error('description')
                                    <div class="text-danger mt-1 small">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content & SEO -->
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Content Editor -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-edit me-2 text-primary"></i>Content
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="content" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-file-alt me-2 text-warning"></i>Post Content <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" 
                                                  id="content" 
                                                  name="post_body"
                                                  placeholder="Write your blog post content here...">{{old('post_body')}}</textarea>
                                        @error('post_body')
                                            <div class="text-danger mt-1 small">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Categories & Tags -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-tags me-2 text-primary"></i>Categories & Tags
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="category" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-folder me-2 text-info"></i>Category
                                        </label>
                                        <select class="form-control form-control-sm" id="category" name="category">
                                            <option value="">Select a category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="text-danger mt-1 small">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tags" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-tag me-2 text-success"></i>Tags
                                        </label>
                                        <select class="form-control form-control-sm" id="tags" name="tags[]" multiple="multiple">
                                            @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('tags')
                                            <div class="text-danger mt-1 small">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Settings -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-search me-2 text-primary"></i>SEO Settings
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-heading me-2 text-primary"></i>Meta Title
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               id="meta_title" 
                                               name="meta_title" 
                                               value="{{old('meta_title')}}"
                                               placeholder="SEO meta title">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label fw-semibold text-muted small">
                                            <i class="fas fa-align-left me-2 text-info"></i>Meta Description
                                        </label>
                                        <textarea name="meta_description" 
                                                  class="form-control form-control-sm" 
                                                  id="meta_description" 
                                                  rows="3"
                                                  placeholder="SEO meta description">{{old('meta_description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary-modern btn-sm" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary-modern btn-sm">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Post
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#category").select2({
                placeholder: "Select a category",
                allowClear: true
            })
            $('#tags').select2({
                tags: true,
                tokenSeparators: [','],
                createTag: function (params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                }
            });
        });
    </script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                placeholder: 'Write your blog post content here...',
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <script>
    function resetForm() {
        if (confirm('Are you sure you want to reset all changes? This will clear all form fields.')) {
            document.getElementById('blogForm').reset();
            $('#content').summernote('code', '');
        }
    }
    </script>
@endpush
