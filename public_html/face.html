<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Detection with Landmarks</title>
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }
        #container {
            position: relative;
            display: inline-block;
        }
        #video {
            border: 1px solid #ccc;
        }
        #overlay {
            position: absolute;
            top: 0;
            left: 0;
        }
        #status {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Face Verification with Liveness Detection</h1>
    <div id="container">
        <video id="video" width="640" height="480" autoplay muted playsinline></video>
        <canvas id="overlay"></canvas>
    </div>
    <button id="startButton">Start Camera</button>
    <div id="status">Click "Start Camera" to begin.</div>
    <div id="instructions" style="display:none;">
        <p>Follow these steps:</p>
        <ul>
            <li id="step1">Step 1: Blink your eyes</li>
            <li id="step2">Step 2: Smile</li>
            <li id="step3">Step 3: Keep only one face in view</li>
        </ul>
    </div>
    <div id="photoContainer" style="display:none;">
        <h2>Photo Saved!</h2>
        <p id="photoMessage"></p>
    </div>

    <script>
        const video = document.getElementById('video');
        const overlay = document.getElementById('overlay');
        const status = document.getElementById('status');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const photoContainer = document.getElementById('photoContainer');
        const startButton = document.getElementById('startButton');
        const instructions = document.getElementById('instructions');

        let blinkDetected = false;
        let smileDetected = false;
        let singleFaceDetected = false;
        let validationCount = 0;
        let photoCaptured = false;
        let capturedDataURL = null;
        let photosDirHandle = null;

        startButton.addEventListener('click', () => {
            startButton.disabled = true;
        });

        // Euclidean distance
        function euclideanDistance(p1, p2) {
            return Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));
        }

        // Eye aspect ratio calculation for blink detection
        function getEyeAspectRatio(eye) {
            const A = euclideanDistance(eye[1], eye[5]);
            const B = euclideanDistance(eye[2], eye[4]);
            const C = euclideanDistance(eye[0], eye[3]);
            return (A + B) / (2.0 * C);
        }

        async function requestPhotosDirectory() {
            try {
                if ('showDirectoryPicker' in window) {
                    photosDirHandle = await window.showDirectoryPicker({
                        mode: 'readwrite',
                        startIn: 'pictures'
                    });
                    return true;
                } else {
                    alert('Your browser does not support the File System Access API. Please use a modern browser like Chrome or Edge.');
                    return false;
                }
            } catch (error) {
                console.error('Error accessing directory:', error);
                return false;
            }
        }

        async function startDetection() {
            try {
                // Request Photos directory access
                const dirGranted = await requestPhotosDirectory();
                if (!dirGranted) {
                    status.textContent = 'Directory access denied. Camera will open for detection only.';
                }

                // Load models from CDN
                await faceapi.nets.tinyFaceDetector.loadFromUri('https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/');
                await faceapi.nets.faceLandmark68Net.loadFromUri('https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/');
                await faceapi.nets.faceExpressionNet.loadFromUri('https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/');

                status.textContent = 'Models loaded. Accessing camera...';

                // Access webcam
                const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
                video.srcObject = stream;

                video.addEventListener('loadedmetadata', () => {
                    status.textContent = 'Starting validation...';
                    instructions.style.display = 'block';
                    detectFaces();
                });
            } catch (error) {
                if (error.name === 'NotAllowedError') {
                    status.textContent = 'Camera permission denied. Please allow camera access in your browser settings and click "Start Camera" again.';
                } else {
                    status.textContent = 'Error: ' + error.message;
                }
                console.error(error);
                startButton.disabled = false;
            }
        }

        async function detectFaces() {
            const canvas = overlay;
            const displaySize = { width: video.videoWidth, height: video.videoHeight };
            faceapi.matchDimensions(canvas, displaySize);

            setInterval(async () => {
                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceExpressions();

                const resizedDetections = faceapi.resizeResults(detections, displaySize);

                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

                if (detections.length === 1) {
                    const detection = detections[0];
                    const landmarks = detection.landmarks;
                    const expressions = detection.expressions;

                    // Check single face
                    singleFaceDetected = true;
                    step3.innerHTML = 'Step 3: Keep only one face in view ✓';

                    // Check eye blink
                    const leftEye = landmarks.getLeftEye();
                    const rightEye = landmarks.getRightEye();
                    const leftEAR = getEyeAspectRatio(leftEye);
                    const rightEAR = getEyeAspectRatio(rightEye);
                    const ear = (leftEAR + rightEAR) / 2.0;

                    if (ear < 0.25) { // Threshold for closed eyes
                        blinkDetected = true;
                        step1.innerHTML = 'Step 1: Blink your eyes ✓';
                    }

                    // Check smile
                    if (expressions.happy > 0.7) {
                        smileDetected = true;
                        step2.innerHTML = 'Step 2: Smile ✓';
                    }

                    // Draw detections and landmarks
                    faceapi.draw.drawDetections(canvas, resizedDetections);
                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                    // Check if all validations passed
                    if (blinkDetected && smileDetected && singleFaceDetected && !photoCaptured && photosDirHandle) {
                        validationCount++;
                        if (validationCount >= 5) { // Require 5 consecutive frames
                            capturePhoto();
                            photoCaptured = true;
                        }
                    } else {
                        validationCount = 0;
                    }
                } else {
                    // Reset validations
                    blinkDetected = false;
                    smileDetected = false;
                    singleFaceDetected = false;
                    validationCount = 0;
                    step1.innerHTML = 'Step 1: Blink your eyes';
                    step2.innerHTML = 'Step 2: Smile';
                    step3.innerHTML = 'Step 3: Keep only one face in view';
                }
            }, 100);
        }

        async function capturePhoto() {
            if (!photosDirHandle) {
                // Directory access not granted, show message without saving
                photoContainer.style.display = 'block';
                document.getElementById('photoMessage').textContent = 'Photo not saved - directory access was denied.';
                status.textContent = 'Validation complete! Photo not saved.';
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);

            // Convert canvas to blob
            canvas.toBlob(async (blob) => {
                const filename = 'face-verification-' + new Date().toISOString().slice(0, 19).replace(/:/g, '-') + '.png';

                try {
                    // Create file handle in Photos directory
                    const fileHandle = await photosDirHandle.getFileHandle(filename, { create: true });
                    const writable = await fileHandle.createWritable();
                    await writable.write(blob);
                    await writable.close();

                    // Show success message
                    photoContainer.style.display = 'block';
                    document.getElementById('photoMessage').textContent = `Photo saved to Photos directory as ${filename}`;
                    status.textContent = 'Validation complete! Photo saved.';
                } catch (error) {
                    console.error('Error saving photo:', error);
                    status.textContent = 'Error saving photo: ' + error.message;
                }
            }, 'image/png');
        }

        startDetection();
    </script>
</body>
</html>