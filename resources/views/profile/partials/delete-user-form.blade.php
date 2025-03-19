<section>
    <header class="mb-4">
        <h2 class="h5 mb-1">Delete Account</h2>
        <p class="text-muted mb-0">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
    </header>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="alert alert-warning mb-4">
                <h4 class="alert-heading h6 mb-2">Are you sure you want to delete your account?</h4>
                <p class="mb-0">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
                @csrf
                @method('delete')

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm-user-deletion-label">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="delete-user-form" class="btn btn-danger">Delete Account</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.modal-content {
    border: none;
    border-radius: 0.5rem;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}
</style> 