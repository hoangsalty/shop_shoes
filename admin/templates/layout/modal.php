<form id="form_product_size" class="validation-form" novalidate method="post" enctype="multipart/form-data">
    <div class="modal fade" id="popup_product_size" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    
                    <div class="form-group">
                        <label for="name">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tiêu đề" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
                    <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_product_color" class="validation-form" novalidate method="post" enctype="multipart/form-data">
    <div class="modal fade" id="popup_product_color" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="name">Tiêu đề:</label>
                            <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tiêu đề" required>
                        </div>

                        <div class="form-group col-md-6 col-sm-6">
                            <label class="d-block" for="color">Màu sắc:</label>
                            <input type="color" class="form-control text-sm" name="data[color]" id="color" maxlength="7" value="#000000">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
                    <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
                </div>
            </div>
        </div>
    </div>
</form>