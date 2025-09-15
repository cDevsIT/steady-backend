@extends('admin.layouts.master')
@push('title')
    Blog Management
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Blog Posts</h1>
                    <p class="page-subtitle-modern">Manage and publish blog content</p>
                </div>
                <a href="{{route('blogs.create')}}" class="btn btn-primary-modern">
                    <i class="fas fa-plus-circle me-2"></i> Create New Post
                </a>
            </div>
        </div>

        <!-- Modern Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-primary-subtle rounded-lg me-3">
                                <i class="fas fa-newspaper text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Posts</h6>
                                <h3 class="stats-value-modern mb-0">{{ $blogs->total() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-success-subtle rounded-lg me-3">
                                <i class="fas fa-eye text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Published</h6>
                                <h3 class="stats-value-modern mb-0">{{ $blogs->where('status', 'published')->count() ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-warning-subtle rounded-lg me-3">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Draft</h6>
                                <h3 class="stats-value-modern mb-0">{{ $blogs->where('status', 'draft')->count() ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card-modern card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-modern bg-info-subtle rounded-lg me-3">
                                <i class="fas fa-tags text-info"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Categories</h6>
                                <h3 class="stats-value-modern mb-0">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Filters Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-primary"></i>Search & Filters
                </h5>
            </div>
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-2 text-primary"></i>From Date
                            </label>
                            <input type="date" class="form-control form-control-sm" name="from_date" value="{{request()->from_date}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-calendar me-2 text-primary"></i>To Date
                            </label>
                            <input type="date" class="form-control form-control-sm" name="to_date" value="{{request()->to_date}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">
                                <i class="fas fa-search me-2 text-success"></i>Search
                            </label>
                            <input type="text" class="form-control form-control-sm" placeholder="Search by title..." name="q" value="{{request()->q}}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" name="submit_type" value="search" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <button type="submit" name="submit_type" value="csv" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modern Main Content Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i> Blog Posts List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 50px;">#</th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 120px;">
                                    <i class="fas fa-calendar me-1"></i>Created Date
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 200px;">
                                    <i class="fas fa-newspaper me-1"></i>Title
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small" style="width: 150px;">
                                    <i class="fas fa-link me-1"></i>Slug
                                </th>
                                <th class="border-0 py-2 px-2 fw-semibold text-muted small text-center" style="width: 120px;">
                                    <i class="fas fa-cogs me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{++$i}}</td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted small">{{ \Carbon\Carbon::parse($blog->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{$blog->title}}</span>
                                        <br>
                                        <small class="text-muted small">{{ Str::limit($blog->description, 50) }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <code class="text-primary small">{{$blog->slug}}</code>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{route('blogs.edit',$blog)}}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{route('web.post',$blog->slug)}}" class="btn btn-outline-success btn-sm me-1" target="_blank" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" onclick="deleteBlog({{$blog->id}}, '{{$blog->title}}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modern Pagination -->
            @if($blogs->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $blogs->firstItem() ?? 0 }} to {{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $blogs->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal for Blog Posts -->
    <div class="modal fade" id="deleteBlogModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Are you sure?</h5>
                        <p class="text-muted">You want to delete the blog post <strong class="text-dark" id="blogTitle"></strong>?</p>
                        <p class="text-danger small">
                            <i class="fas fa-info-circle me-1"></i>This action cannot be undone and will remove all content permanently.
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form id="deleteBlogForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
function deleteBlog(id, title) {
    // Set the blog title in the modal
    document.getElementById('blogTitle').textContent = title;
    
    // Set the form action
    document.getElementById('deleteBlogForm').action = `/admin/blogs/${id}`;
    
    // Show the modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteBlogModal'));
    deleteModal.show();
}
</script>
@endpush
