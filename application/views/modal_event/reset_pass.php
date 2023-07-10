<div class="modal fade" id="reset_pass" tabindex="-1" aria-labelledby="reset_pass" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_resetpass">
                    <div class="mb-3">
                        <label for="username">Username :</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Username" name="username"
                            disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="password">New Password :</label>
                        <input type="text" class="form-control form-control-sm" minlength="4" placeholder="password"
                            name="password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-success btn-block">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>