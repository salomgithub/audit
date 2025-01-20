document.addEventListener('DOMContentLoaded', function () {
    const captureButton = document.getElementById('take-photo-button');
    const cameraPreview = document.getElementById('camera-preview');
    const capturedPhoto = document.getElementById('captured-photo');

    captureButton.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
            cameraPreview.style.display = 'block';

            const options = { mimeType: 'video/webm' };
            const player = videojs('camera-preview', { controls: true, width: 640, height: 480, fluid: false });
            player.record(options);

            player.on('finishRecord', function () {
                const blob = player.recordedData;
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    const base64data = reader.result;
                    capturedPhoto.value = base64data;
                    cameraPreview.style.display = 'none';
                };
            });
        } catch (error) {
            console.error('Kameraga kirishda xatolik:', error);
        }
    });
});
