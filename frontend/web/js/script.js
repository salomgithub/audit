document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const startButton = document.getElementById('startButton');
    const captureButton = document.getElementById('captureButton');
    const stopButton = document.getElementById('stopButton');
    const submitButton = document.getElementById('submit');
    const captureForm = document.getElementById('captureForm');
    const imageInput = document.getElementById('imagefileform-imagefile');

    let mediaStream;

    async function startCamera() {
        try {
            mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = mediaStream;
            startButton.disabled = true;
            captureButton.disabled = false;
            stopButton.disabled = false;
        } catch (error) {
            console.error('Error accessing the camera:', error);
        }
    }

    function captureImage() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            imageInput.value = url;
            submitButton.disabled = false;
        }, 'image/png');
    }

    function stopCamera() {
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
        }
        video.srcObject = null;
        startButton.disabled = false;
        captureButton.disabled = true;
        stopButton.disabled = true;
    }

    startButton.addEventListener('click', startCamera);
    captureButton.addEventListener('click', captureImage);
    stopButton.addEventListener('click', stopCamera);
});
