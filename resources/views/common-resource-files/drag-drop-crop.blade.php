{{--html codes--}}
{{--                                                drag drop crop start--}}
<!-- Drag & Drop Area -->
<!-- Drag & Drop Area -->
<div class="drag-drop-area" id="dragDropArea">
    <input type="file" class="file-input-hidden" id="profileImage" name="profile_image" accept="image/*">
    <div class="upload-content" id="uploadContent">
        <div class="upload-icon">📁</div>
        <h5>Drag & Drop your image here</h5>
        <p class="text-muted">or click to browse</p>
        <small class="text-muted">Supports: JPG, PNG, GIF (Max 5MB)</small>
    </div>
</div>

<!-- Image Preview & Cropping Area -->
<div class="preview-container" id="previewContainer" style="display: none;">
    <img id="imagePreview" style="max-width: 100%;">
</div>

<!-- Crop Controls -->
<div class="crop-controls mt-3" id="cropControls" style="display: none;">
    <div class="d-flex gap-2 justify-content-center">
        <button type="button" class="btn btn-outline-secondary btn-sm" id="resetCrop">
            🔄 Reset
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="rotateLeft">
            ↺ Rotate Left
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="rotateRight">
            ↻ Rotate Right
        </button>
        <button type="button" class="btn btn-success btn-sm" id="cropImage">
            ✂️ Crop Image
        </button>
        <button type="button" class="btn btn-success btn-sm" id="saveImage" style="display: none">
            ✂️ Save Image
        </button>
    </div>
</div>

<!-- Final Preview -->
<div class="text-center mt-3" id="finalPreviewContainer" style="display: none;">
    <h6>Cropped Image:</h6>
    <img id="finalPreview" class="final-preview" alt="Cropped preview">
    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm" id="changeImage">
            Change Image
        </button>
    </div>
</div>
<!-- Hidden input for cropped image data -->
<input type="hidden" id="croppedImageData" name="cropped_image_data">

<!-- Add the preview container, crop controls, and final preview divs here -->
<!-- (Copy from the artifact above) -->
{{--                                                drag drop crop end--}}

@php
    if (!isset($modelId))
        $modelId    = 'modal';
 @endphp

@push('script')
    <link rel="stylesheet" href="{{ asset('common-assets/drag-drop-crop/style.css') }}">
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">--}}
    <link href="{{ asset('/common-assets/cropper-js/cropper.min.css') }}" rel="stylesheet">
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>--}}
    <script src="{{ asset('/common-assets/cropper-js/cropper.min.js') }}"></script>
    <script src="{{ asset('common-assets/drag-drop-crop/script.js') }}"></script>
    <script>

        resetModalForDragDropCrop("{{ $modelId }}");
    </script>
@endpush
