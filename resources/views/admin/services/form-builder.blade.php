@extends('admin.layouts.master')
@push('title')
    Form Builder - {{ $service->name }}
@endpush
@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title-modern mb-2">
                        <i class="fas fa-form me-2"></i>Form Builder
                    </h1>
                    <p class="page-subtitle-modern">{{ $service->name }} - User Information Form</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.show', $service) }}" class="btn btn-outline-secondary-modern">
                        <i class="fas fa-arrow-left me-2"></i>← Back to Service
                    </a>
                </div>
            </div>
        </div>

        <!-- Notice Banner -->
        @if($service->forms->where('form_type', 'custom')->count() > 0)
            <div class="alert alert-info border-0 mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Form Already Exists:</strong> You already have a custom form for this service. Creating a new form will replace the existing one.
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 py-3">
                <h5 class="card-title-modern mb-0">
                    <i class="fas fa-form me-2"></i>Form Builder
                </h5>
            </div>
            <div class="card-body p-4">
                @if($service->forms->where('form_type', 'custom')->count() > 0)
                    <div class="alert alert-warning border-0 mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Notice:</strong> A form of this type already exists for this service. Creating a new form will replace the existing one.
                    </div>
                @endif

                <form action="{{ route('admin.services.storeCustomForm', $service) }}" method="POST" id="formBuilderForm">
                    @csrf
                    
                    <!-- Form Configuration -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-cog me-2 text-primary"></i>Form Configuration
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="form_name" class="form-label fw-semibold">
                                    Form Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="form_name" name="form_name" 
                                       value="{{ old('form_name', 'User info Form') }}" required>
                                @error('form_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="form_status" class="form-label fw-semibold">Status</label>
                                <select class="form-select" id="form_status" name="form_status">
                                    <option value="active" {{ old('form_status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('form_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="form_description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" id="form_description" name="form_description" rows="3" 
                                          placeholder="Enter form description...">{{ old('form_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-list me-2 text-primary"></i>Form Fields
                            </h6>
                            <button type="button" class="btn btn-primary btn-sm" id="addNewField">
                                <i class="fas fa-plus me-2"></i>Add New Field
                            </button>
                        </div>
                        
                        <div id="formFieldsContainer" class="mb-3">
                            <!-- Dynamic form fields will be added here -->
                        </div>
                        
                        <div class="alert alert-info border-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> Use the "Add New Field" button to add form fields. You can drag and drop fields to reorder them.
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="border-top pt-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-save me-2 text-primary"></i>Form Actions
                            <small class="text-muted fw-normal">Save your form configuration.</small>
                        </h6>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.services.show', $service) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>× Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Form
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Form Field Modal -->
    <div class="modal fade" id="addFieldModal" tabindex="-1" role="dialog" aria-labelledby="addFieldModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-white border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="addFieldModalLabel">
                        <i class="fas fa-plus me-2 text-primary"></i>Add Form Field
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="fieldType" class="form-label fw-semibold">
                            Field Type <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="fieldType" required>
                            <option value="">Select Field Type</option>
                            <option value="text">Text Input</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Select Dropdown</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio Button</option>
                            <option value="file">File Upload</option>
                            <option value="date">Date</option>
                            <option value="datetime">Date & Time</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="requiredField" class="form-label fw-semibold">Required Field</label>
                        <select class="form-select" id="requiredField">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fieldLabel" class="form-label fw-semibold">
                            Field Label <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="fieldLabel" required>
                    </div>
                    <div class="mb-3">
                        <label for="fieldNote" class="form-label fw-semibold">Help Text/Note</label>
                        <input type="text" class="form-control" id="fieldNote" placeholder="Optional help text for this field">
                    </div>
                    <div class="mb-3" id="extensionsField" style="display: none;">
                        <label for="allowedExtensions" class="form-label fw-semibold">Allowed Extensions</label>
                        <input type="text" class="form-control" id="allowedExtensions" placeholder="jpg, jpeg, png, pdf">
                        <div class="form-text">Separate extensions with commas</div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addFieldBtn">Add Field</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .form-field-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }
    
    .form-field-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-color: #007bff;
    }
    
    .form-field-card.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
    }
    
    .field-handle {
        cursor: move;
        color: #6c757d;
        padding: 0.25rem;
    }
    
    .field-handle:hover {
        color: #007bff;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .alert {
        border-radius: 8px;
        border: none;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .modal-header {
        border-bottom: 1px solid #f1f3f4;
    }
    
    .modal-footer {
        border-top: 1px solid #f1f3f4;
    }
</style>
@endpush

@push('js')
<script>
    let fieldCounter = 0;
    
    document.addEventListener('DOMContentLoaded', function() {
        const addNewFieldBtn = document.getElementById('addNewField');
        const addFieldModal = document.getElementById('addFieldModal');
        const addFieldBtn = document.getElementById('addFieldBtn');
        const fieldTypeSelect = document.getElementById('fieldType');
        const extensionsField = document.getElementById('extensionsField');
        const formFieldsContainer = document.getElementById('formFieldsContainer');
        
        // Show extensions field when file type is selected
        fieldTypeSelect.addEventListener('change', function() {
            if (this.value === 'file') {
                extensionsField.style.display = 'block';
            } else {
                extensionsField.style.display = 'none';
            }
        });
        
        // Add new field button click
        addNewFieldBtn.addEventListener('click', function() {
            // Reset modal form
            document.getElementById('fieldType').value = '';
            document.getElementById('requiredField').value = '0';
            document.getElementById('fieldLabel').value = '';
            document.getElementById('fieldNote').value = '';
            document.getElementById('allowedExtensions').value = '';
            extensionsField.style.display = 'none';
            
            // Show modal
            const modal = new bootstrap.Modal(addFieldModal);
            modal.show();
        });
        
        // Add field from modal
        addFieldBtn.addEventListener('click', function() {
            const fieldType = document.getElementById('fieldType').value;
            const requiredField = document.getElementById('requiredField').value;
            const fieldLabel = document.getElementById('fieldLabel').value;
            const fieldNote = document.getElementById('fieldNote').value;
            const allowedExtensions = document.getElementById('allowedExtensions').value;
            
            if (!fieldType || !fieldLabel) {
                alert('Please fill in all required fields.');
                return;
            }
            
            addFormField(fieldType, requiredField, fieldLabel, fieldNote, allowedExtensions);
            
            // Hide modal
            const modal = bootstrap.Modal.getInstance(addFieldModal);
            modal.hide();
        });
        
        // Add form field to container
        function addFormField(type, required, label, note, extensions = '') {
            fieldCounter++;
            
            const fieldCard = document.createElement('div');
            fieldCard.className = 'form-field-card';
            fieldCard.draggable = true;
            fieldCard.innerHTML = `
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-grip-vertical field-handle me-2"></i>
                            <div>
                                <div class="fw-semibold">${label}</div>
                                <small class="text-muted">${getFieldTypeText(type)}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="fw-semibold">${type}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">${note || 'No note provided'}</div>
                    </div>
                    <div class="col-md-1">
                        <div class="fw-semibold">${required === '1' ? 'Yes' : 'No'}</div>
                    </div>
                    ${type === 'file' ? `<div class="col-md-2"><div class="text-muted small">${extensions}</div></div>` : ''}
                    <div class="col-md-${type === 'file' ? '0' : '2'}">
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-primary btn-sm edit-field" data-field-id="${fieldCounter}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-field" data-field-id="${fieldCounter}">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden inputs for form submission -->
                <input type="hidden" name="fields[${fieldCounter}][field_type]" value="${type}">
                <input type="hidden" name="fields[${fieldCounter}][field_label]" value="${label}">
                <input type="hidden" name="fields[${fieldCounter}][field_note]" value="${note}">
                <input type="hidden" name="fields[${fieldCounter}][is_required]" value="${required}">
                ${type === 'file' ? `<input type="hidden" name="fields[${fieldCounter}][allowed_extensions]" value="${extensions}">` : ''}
            `;
            
            formFieldsContainer.appendChild(fieldCard);
            
            // Add event listeners for edit and remove
            addFieldEventListeners(fieldCard, fieldCounter);
            
            // Add drag and drop functionality
            addDragAndDrop(fieldCard);
        }
        
        // Get field type display text
        function getFieldTypeText(type) {
            const typeMap = {
                'text': 'Text Input',
                'textarea': 'Textarea',
                'select': 'Select Dropdown',
                'checkbox': 'Checkbox',
                'radio': 'Radio Button',
                'file': 'File Upload',
                'date': 'Date',
                'datetime': 'Date & Time'
            };
            return typeMap[type] || type;
        }
        
        // Add event listeners for field actions
        function addFieldEventListeners(fieldCard, fieldId) {
            // Edit button
            const editBtn = fieldCard.querySelector('.edit-field');
            editBtn.addEventListener('click', function() {
                editFormField(fieldCard, fieldId);
            });
            
            // Remove button
            const removeBtn = fieldCard.querySelector('.remove-field');
            removeBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove this field?')) {
                    fieldCard.remove();
                }
            });
        }
        
        // Edit form field
        function editFormField(fieldCard, fieldId) {
            // Get current values
            const type = fieldCard.querySelector('input[name*="[field_type]"]').value;
            const required = fieldCard.querySelector('input[name*="[is_required]"]').value;
            const label = fieldCard.querySelector('input[name*="[field_label]"]').value;
            const note = fieldCard.querySelector('input[name*="[field_note]"]').value;
            const extensions = fieldCard.querySelector('input[name*="[allowed_extensions]"]')?.value || '';
            
            // Set modal values
            document.getElementById('fieldType').value = type;
            document.getElementById('requiredField').value = required;
            document.getElementById('fieldLabel').value = label;
            document.getElementById('fieldNote').value = note;
            document.getElementById('allowedExtensions').value = extensions;
            
            if (type === 'file') {
                extensionsField.style.display = 'block';
            }
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('addFieldModal'));
            modal.show();
            
            // Update add button to save changes
            const addFieldBtn = document.getElementById('addFieldBtn');
            addFieldBtn.textContent = 'Update Field';
            addFieldBtn.onclick = function() {
                updateFormField(fieldCard, fieldId);
                modal.hide();
            };
        }
        
        // Update form field
        function updateFormField(fieldCard, fieldId) {
            const fieldType = document.getElementById('fieldType').value;
            const requiredField = document.getElementById('requiredField').value;
            const fieldLabel = document.getElementById('fieldLabel').value;
            const fieldNote = document.getElementById('fieldNote').value;
            const allowedExtensions = document.getElementById('allowedExtensions').value;
            
            if (!fieldType || !fieldLabel) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Update the field card content
            fieldCard.innerHTML = `
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-grip-vertical field-handle me-2"></i>
                            <div>
                                <div class="fw-semibold">${fieldLabel}</div>
                                <small class="text-muted">${getFieldTypeText(fieldType)}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="fw-semibold">${fieldType}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">${fieldNote || 'No note provided'}</div>
                    </div>
                    <div class="col-md-1">
                        <div class="fw-semibold">${requiredField === '1' ? 'Yes' : 'No'}</div>
                    </div>
                    ${fieldType === 'file' ? `<div class="col-md-2"><div class="text-muted small">${allowedExtensions}</div></div>` : ''}
                    <div class="col-md-${fieldType === 'file' ? '0' : '2'}">
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-primary btn-sm edit-field" data-field-id="${fieldId}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm remove-field" data-field-id="${fieldId}">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden inputs for form submission -->
                <input type="hidden" name="fields[${fieldId}][field_type]" value="${fieldType}">
                <input type="hidden" name="fields[${fieldId}][field_label]" value="${fieldLabel}">
                <input type="hidden" name="fields[${fieldId}][field_note]" value="${fieldNote}">
                <input type="hidden" name="fields[${fieldId}][is_required]" value="${requiredField}">
                ${fieldType === 'file' ? `<input type="hidden" name="fields[${fieldId}][allowed_extensions]" value="${allowedExtensions}">` : ''}
            `;
            
            // Re-add event listeners
            addFieldEventListeners(fieldCard, fieldId);
            addDragAndDrop(fieldCard);
            
            // Reset modal button
            const addFieldBtn = document.getElementById('addFieldBtn');
            addFieldBtn.textContent = 'Add Field';
            addFieldBtn.onclick = function() {
                const fieldType = document.getElementById('fieldType').value;
                const requiredField = document.getElementById('requiredField').value;
                const fieldLabel = document.getElementById('fieldLabel').value;
                const fieldNote = document.getElementById('fieldNote').value;
                const allowedExtensions = document.getElementById('allowedExtensions').value;
                
                if (!fieldType || !fieldLabel) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                addFormField(fieldType, requiredField, fieldLabel, fieldNote, allowedExtensions);
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('addFieldModal'));
                modal.hide();
            };
        }
        
        // Add drag and drop functionality
        function addDragAndDrop(fieldCard) {
            fieldCard.addEventListener('dragstart', function(e) {
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.outerHTML);
            });
            
            fieldCard.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
            });
            
            fieldCard.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });
            
            fieldCard.addEventListener('drop', function(e) {
                e.preventDefault();
                const draggedHTML = e.dataTransfer.getData('text/html');
                const draggedElement = this.parentNode.querySelector('.dragging');
                
                if (draggedElement && draggedElement !== this) {
                    this.parentNode.insertBefore(draggedElement, this);
                }
            });
        }
        
        // Form validation
        document.getElementById('formBuilderForm').addEventListener('submit', function(e) {
            const fields = formFieldsContainer.querySelectorAll('.form-field-card');
            if (fields.length === 0) {
                e.preventDefault();
                alert('Please add at least one form field.');
                return false;
            }
        });
    });
</script>
@endpush
