@extends('admin.layouts.master')
@push('title')
    Blog Categories
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern">Blog Categories</h1>
                    <p class="page-subtitle-modern">Organize your blog posts with categories</p>
                </div>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#state_fee_add" class="btn btn-primary-modern">
                    <i class="fas fa-plus-circle me-2"></i>Add Category
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
                                <i class="fas fa-folder text-primary"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Categories</h6>
                                <h3 class="stats-value-modern mb-0">{{ $categories->total() }}</h3>
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
                                <i class="fas fa-newspaper text-success"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Total Posts</h6>
                                <h3 class="stats-value-modern mb-0">{{ $totalPosts ?? 0 }}</h3>
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
                                <i class="fas fa-eye text-warning"></i>
                            </div>
                            <div>
                                <h6 class="stats-label-modern text-muted mb-1">Active Categories</h6>
                                <h3 class="stats-value-modern mb-0">{{ $categories->where('status', 'active')->count() ?? 0 }}</h3>
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
                                <h6 class="stats-label-modern text-muted mb-1">Total Tags</h6>
                                <h3 class="stats-value-modern mb-0">{{ $totalTags ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Search Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-search me-2 text-primary"></i> Search Categories
                </h5>
            </div>
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control form-control-sm me-2" 
                                       placeholder="Search by category name, meta title, or description..." 
                                       name="q" 
                                       value="{{request()->q}}">
                                <button type="submit" class="btn btn-primary btn-sm me-2">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                @if(request()->q)
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                @endif
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
                    <i class="fas fa-list me-2 text-primary"></i> Categories List
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
                                    <i class="fas fa-folder me-1"></i>Category Name
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
                            @foreach($categories as $category)
                                <tr class="border-bottom">
                                    <td class="py-2 px-2 fw-semibold small text-center">{{++$i}}</td>
                                    <td class="py-2 px-2">
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted small">{{ \Carbon\Carbon::parse($category->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td class="py-2 px-2">
                                        <span class="fw-semibold small">{{$category->title}}</span>
                                        @if($category->meta_title)
                                            <br>
                                            <small class="text-muted small">{{ Str::limit($category->meta_title, 50) }}</small>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2">
                                        <code class="text-primary small">{{$category->slug}}</code>
                                    </td>
                                    <td class="py-2 px-2 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="javascript:void(0)" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#state_fee_edit{{$category->id}}" 
                                               class="btn btn-outline-primary btn-sm me-1" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" onclick="deleteCategory({{$category->id}}, '{{$category->title}}')">
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
            @if($categories->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="d-flex justify-content-md-end">
                                {{ $categories->render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach($categories as $category)
        <div class="modal fade" id="state_fee_edit{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$category->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-white border-0 py-3">
                        <h5 class="modal-title fw-bold text-dark" id="editModalLabel{{$category->id}}">
                            <i class="fas fa-edit me-2 text-primary"></i>Edit Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('categories.update', $category)}}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="mb-3">
                                <label for="name{{$category->id}}" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-folder me-2 text-primary"></i>Category Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-sm" 
                                       required 
                                       id="name{{$category->id}}" 
                                       value="{{$category->title}}" 
                                       name="name"
                                       placeholder="Enter category name">
                            </div>
                            <div class="mb-3">
                                <label for="meta_title{{$category->id}}" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-heading me-2 text-info"></i>Meta Title
                                </label>
                                <input type="text" 
                                       class="form-control form-control-sm" 
                                       id="meta_title{{$category->id}}" 
                                       value="{{$category->meta_title}}" 
                                       name="meta_title"
                                       placeholder="SEO meta title">
                            </div>
                            <div class="mb-3">
                                <label for="meta_description{{$category->id}}" class="form-label fw-semibold text-muted small">
                                    <i class="fas fa-align-left me-2 text-info"></i>Meta Description
                                </label>
                                <textarea class="form-control form-control-sm" 
                                          id="meta_description{{$category->id}}" 
                                          value="{{$category->meta_description}}" 
                                          name="meta_description"
                                          rows="3"
                                          placeholder="SEO meta description">{{$category->meta_description}}</textarea>
                            </div>
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary-modern btn-sm">
                                    <i class="fas fa-save me-2"></i> Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Modal -->
    <div class="modal fade" id="state_fee_add" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="addModalLabel">
                        <i class="fas fa-plus me-2 text-primary"></i>Add New Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('categories.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-folder me-2 text-primary"></i>Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   required 
                                   id="name" 
                                   name="name"
                                   placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <label for="meta_title" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-heading me-2 text-info"></i>Meta Title
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   id="meta_title" 
                                   name="meta_title"
                                   placeholder="SEO meta title">
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label fw-semibold text-muted small">
                                <i class="fas fa-align-left me-2 text-info"></i>Meta Description
                            </label>
                            <textarea class="form-control form-control-sm" 
                                      id="meta_description" 
                                      name="meta_description"
                                      rows="3"
                                      placeholder="SEO meta description"></textarea>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-sm">
                                <i class="fas fa-plus me-2"></i>Add Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal for Categories -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                        <p class="text-muted">You want to delete the category <strong class="text-dark" id="categoryTitle"></strong>?</p>
                        <p class="text-danger small">
                            <i class="fas fa-info-circle me-1"></i>This action cannot be undone and will affect all associated blog posts.
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary-modern btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form id="deleteCategoryForm" method="POST" class="d-inline">
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
function deleteCategory(id, title) {
    // Set the category title in the modal
    document.getElementById('categoryTitle').textContent = title;
    
    // Set the form action
    document.getElementById('deleteCategoryForm').action = `/admin/categories/${id}`;
    
    // Show the modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
    deleteModal.show();
}
</script>
@endpush
