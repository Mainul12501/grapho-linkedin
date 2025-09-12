let cropper = null;
let originalFile = null;

// DOM Elements
const dragDropArea = document.getElementById('dragDropArea');
const fileInput = document.getElementById('profileImage');
const uploadContent = document.getElementById('uploadContent');
const previewContainer = document.getElementById('previewContainer');
const imagePreview = document.getElementById('imagePreview');
const cropControls = document.getElementById('cropControls');
const finalPreviewContainer = document.getElementById('finalPreviewContainer');
const finalPreview = document.getElementById('finalPreview');
const croppedImageData = document.getElementById('croppedImageData');

// Event Listeners
dragDropArea.addEventListener('click', () => fileInput.click());
dragDropArea.addEventListener('dragover', handleDragOver);
dragDropArea.addEventListener('drop', handleDrop);
dragDropArea.addEventListener('dragleave', handleDragLeave);
fileInput.addEventListener('change', handleFileSelect);

document.getElementById('resetCrop').addEventListener('click', () => cropper.reset());
document.getElementById('rotateLeft').addEventListener('click', () => cropper.rotate(-90));
document.getElementById('rotateRight').addEventListener('click', () => cropper.rotate(90));
document.getElementById('cropImage').addEventListener('click', handleCropImage);
document.getElementById('changeImage').addEventListener('click', resetUpload);
document.getElementById('saveImage').addEventListener('click', handleSaveImage);

// Drag and Drop Functions
function handleDragOver(e) {
    e.preventDefault();
    dragDropArea.classList.add('dragover');
}

function handleDragLeave(e) {
    e.preventDefault();
    dragDropArea.classList.remove('dragover');
}

function handleDrop(e) {
    e.preventDefault();
    dragDropArea.classList.remove('dragover');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleFile(files[0]);
    }
}

function handleFileSelect(e) {
    const file = e.target.files[0];
    if (file) {
        handleFile(file);
    }
}

function handleFile(file) {
    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file.');
        return;
    }

    // Validate file size (5MB max)
    if (file.size > 5 * 1024 * 1024) {
        alert('File size must be less than 5MB.');
        return;
    }

    originalFile = file;

    // Create FileReader to display image
    const reader = new FileReader();
    reader.onload = function(e) {
        displayImageForCropping(e.target.result);
    };
    reader.readAsDataURL(file);
}

function displayImageForCropping(imageSrc) {
    // Hide upload area and show preview
    uploadContent.style.display = 'none';
    previewContainer.style.display = 'block';
    cropControls.style.display = 'block';
    finalPreviewContainer.style.display = 'none';

    // Set image source
    imagePreview.src = imageSrc;

    // Initialize cropper
    if (cropper) {
        cropper.destroy();
    }

    cropper = new Cropper(imagePreview, {
        aspectRatio: 1, // Square crop for profile image
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 0.8,
        restore: false,
        guides: true,
        center: true,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
    });
}

function handleCropImage() {
    if (!cropper) return;

    // Get cropped canvas
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });

    // Convert to blob and display final preview
    canvas.toBlob((blob) => {
        const url = URL.createObjectURL(blob);
        finalPreview.src = url;

        // Store cropped image data
        croppedImageData.value = canvas.toDataURL('image/jpeg', 0.8);

        // Show final preview and hide cropping interface
        previewContainer.style.display = 'none';
        cropControls.style.display = 'none';
        finalPreviewContainer.style.display = 'block';

    }, 'image/jpeg', 0.8);
}

function resetUpload() {
    // Reset everything
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }

    fileInput.value = '';
    croppedImageData.value = '';
    originalFile = null;

    // Show upload area
    uploadContent.style.display = 'block';
    previewContainer.style.display = 'none';
    cropControls.style.display = 'none';
    finalPreviewContainer.style.display = 'none';
}

function handleSaveImage() {
    if (!croppedImageData.value) {
        alert('Please select and crop an image first.');
        return;
    }

    // Here you can submit the form or handle the cropped image data
    // The cropped image data is available in croppedImageData.value as base64

    console.log('Cropped image data:', croppedImageData.value);
    alert('Image saved successfully! Check console for base64 data.');

    // You can now submit this data to your server
    // Example: Send via AJAX or submit the form
}

// Reset when modal is closed
// document.getElementById('profileModal').addEventListener('hidden.bs.modal', function () {
//     resetUpload();
// });

function resetModalForDragDropCrop(modalId) {
    document.getElementById(modalId).addEventListener('hidden.bs.modal', function () {
        resetUpload();
    });
}
