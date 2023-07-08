<div class="photoUpload-zone">
    <div class="photoUpload-detail" id="photoUpload-preview">
        <?= $func->getImage(['class' => 'rounded img-preview', 'upload' => $photoDetail['upload'], 'image' => $photoDetail['image']]) ?>
    </div>
    <label class="photoUpload-file" id="photo-zone" for="file-zone">
        <input type="file" name="file" id="file-zone">
        <i class="fas fa-cloud-upload-alt"></i>
        <p class="photoUpload-drop">Bấm vào đây</p>
        <p class="photoUpload-or">hoặc</p>
        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
    </label>
</div>