<div class="photoUpload-zone">
    <div class="photoUpload-detail" id="photoUpload-preview">
        <?= $func->getImage(['class' => 'rounded', 'size-error' => '250x250x1', 'upload' => $photoDetail['upload'], 'image' => $photoDetail['image']]) ?>
    </div>
    <label class="photoUpload-file" id="photo-zone" for="file-zone">
        <input type="file" name="file" id="file-zone">
        <i class="fas fa-cloud-upload-alt"></i>
        <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
        <p class="photoUpload-or">hoặc</p>
        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
    </label>
</div>