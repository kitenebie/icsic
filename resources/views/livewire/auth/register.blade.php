<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {

}; ?>

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<style>
    #faceContainer {
        position: relative;
        display: inline-block;
        margin: 20px 0;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 8px;
    }
    #faceVideo {
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    #faceOverlay {
        position: absolute;
        top: 10px;
        left: 10px;
    }
    #faceStatus {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
    }
    #faceInstructions {
        display: none;
        margin-top: 10px;
    }
    #faceInstructions ul {
        list-style: none;
        padding: 0;
    }
    #faceInstructions li {
        margin: 5px 0;
    }
    #profileImagePreview {
        display: none;
        margin-top: 10px;
    }
    #profileImagePreview img {
        max-width: 100px;
        max-height: 100px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Face Detection Section -->
    <div id="faceContainer">
        <h3 class="text-lg font-semibold mb-2">Profile Picture Capture</h3>
        <div id="faceVideoContainer">
            <video id="faceVideo" width="320" height="240" autoplay muted playsinline></video>
            <canvas id="faceOverlay"></canvas>
        </div>
        <button type="button" id="startFaceButton" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Start Camera</button>
        <div id="faceStatus">Click "Start Camera" to begin face verification.</div>
        <div id="faceInstructions">
            <p class="font-medium">Follow these steps:</p>
            <ul>
                <li id="faceStep1">Step 1: Blink your eyes</li>
                <li id="faceStep2">Step 2: Smile</li>
                <li id="faceStep3">Step 3: Keep only one face in view</li>
            </ul>
        </div>
        <div id="profileImagePreview">
            <p class="font-medium">Profile Picture Captured:</p>
            <img id="capturedImage" src="" alt="Captured Profile Picture">
        </div>

        <!-- Fallback: Manual Profile Picture Upload -->
        <div id="manualUploadSection" style="display: none; margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
            <p class="font-medium text-gray-700">Alternative: Upload Profile Picture</p>
            <input
                type="file"
                name="manual_profile_image"
                id="manualProfileImage"
                accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
            <p class="text-sm text-gray-600 mt-1">If camera is not available, you can upload a profile picture manually.</p>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
        <!-- First Name -->
        <flux:input
            name="FirstName"
            :label="__('First Name')"
            type="text"
            required
            autofocus
            autocomplete="FirstName"
            :placeholder="__('First name')"
        />
        <!-- Last Name -->
        <flux:input
            name="LastName"
            :label="__('Last Name')"
            type="text"
            required
            autocomplete="LastName"
            :placeholder="__('Last name')"
        />
        <!-- Last Name -->
        <flux:input
            name="MiddleName"
            :label="__('Middle Name')"
            type="text"
            autocomplete="MiddleName"
            :placeholder="__('Middle name')"
        />
        <!-- Ext Name -->
        <flux:input
            name="extension_name"
            :label="__('Ext Name')"
            type="text"
            autocomplete="extension_name"
            :placeholder="__('Ext name')"
        />
        <!-- conact -->
        <flux:input
            name="contact"
            :label="__('Contact Number')"
            type="number"
            autocomplete="contact"
            :placeholder="__('Contact Number')"
        />
        <!-- Email Address -->
        <flux:input
            name="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Front ID -->
        <div>
            <label for="front_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Front ID</label>
            <input
                type="file"
                name="front_id"
                id="front_id"
                accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
        </div>

        <!-- Back ID -->
        <div>
            <label for="back_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Back ID</label>
            <input
                type="file"
                name="back_id"
                id="back_id"
                accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
        </div>

        <!-- Hidden Profile Image Input -->
        <input type="hidden" name="profile_image_data" id="profileImageData">

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>

<script>
    // Debug logging
    console.log('Face detection script loaded');

    const faceVideo = document.getElementById('faceVideo');
    const faceOverlay = document.getElementById('faceOverlay');
    const faceStatus = document.getElementById('faceStatus');
    const faceStep1 = document.getElementById('faceStep1');
    const faceStep2 = document.getElementById('faceStep2');
    const faceStep3 = document.getElementById('faceStep3');
    const startFaceButton = document.getElementById('startFaceButton');
    const faceInstructions = document.getElementById('faceInstructions');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const capturedImage = document.getElementById('capturedImage');
    const profileImageData = document.getElementById('profileImageData');

    let blinkDetected = false;
    let smileDetected = false;
    let singleFaceDetected = false;
    let validationCount = 0;
    let photoCaptured = false;
    let stream = null;

    // Check for HTTPS requirement
    function checkHTTPSRequirement() {
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            faceStatus.textContent = '⚠️ Camera access requires HTTPS. Please use HTTPS or localhost.';
            faceStatus.style.color = 'red';
            startFaceButton.disabled = true;
            return false;
        }
        return true;
    }

    // Check browser compatibility
    function checkBrowserCompatibility() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            faceStatus.textContent = '❌ Your browser does not support camera access. Please use a modern browser like Chrome, Firefox, or Edge.';
            faceStatus.style.color = 'red';
            startFaceButton.disabled = true;
            return false;
        }
        return true;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing face detection');
        checkBrowserCompatibility();
        checkHTTPSRequirement();
    });

    startFaceButton.addEventListener('click', async () => {
        console.log('Start camera button clicked');
        startFaceButton.disabled = true;
        faceStatus.textContent = 'Initializing...';
        faceStatus.style.color = '#666';

        try {
            await startFaceDetection();
        } catch (error) {
            console.error('Error starting face detection:', error);
            faceStatus.textContent = '❌ Failed to start camera: ' + error.message;
            faceStatus.style.color = 'red';
            startFaceButton.disabled = false;
        }
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

    async function startFaceDetection() {
        try {
            console.log('Starting face detection initialization');

            // Check if face-api.js is loaded
            if (typeof faceapi === 'undefined') {
                throw new Error('face-api.js library not loaded. Please check your internet connection.');
            }

            faceStatus.textContent = 'Loading face detection models...';
            console.log('Loading face-api models');

            // Load models from CDN with progress updates
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/'),
                faceapi.nets.faceLandmark68Net.loadFromUri('https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/'),
                faceapi.nets.faceExpressionNet.loadFromUri('https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/')
            ]);

            console.log('Models loaded successfully');
            faceStatus.textContent = 'Models loaded. Requesting camera permission...';

            // Request camera access with specific constraints
            const constraints = {
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user' // Use front camera
                }
            };

            console.log('Requesting camera access with constraints:', constraints);
            stream = await navigator.mediaDevices.getUserMedia(constraints);

            console.log('Camera access granted, setting up video stream');
            faceVideo.srcObject = stream;

            // Wait for video to be ready
            await new Promise((resolve) => {
                faceVideo.addEventListener('loadedmetadata', () => {
                    console.log('Video metadata loaded, dimensions:', faceVideo.videoWidth, 'x', faceVideo.videoHeight);
                    resolve();
                });
            });

            faceStatus.textContent = 'Camera ready. Starting face detection...';
            faceInstructions.style.display = 'block';

            // Start face detection
            detectFaces();

        } catch (error) {
            console.error('Error in startFaceDetection:', error);

            let errorMessage = 'Unknown error occurred';

            if (error.name === 'NotAllowedError') {
                errorMessage = 'Camera permission denied. Please allow camera access in your browser and try again.';
            } else if (error.name === 'NotFoundError') {
                errorMessage = 'No camera found. Please connect a camera and try again.';
            } else if (error.name === 'NotReadableError') {
                errorMessage = 'Camera is already in use by another application.';
            } else if (error.name === 'OverconstrainedError') {
                errorMessage = 'Camera does not support the requested video quality.';
            } else if (error.name === 'SecurityError') {
                errorMessage = 'Camera access blocked due to security restrictions.';
            } else if (error.message) {
                errorMessage = error.message;
            }

            faceStatus.textContent = '❌ ' + errorMessage;
            faceStatus.style.color = 'red';
            startFaceButton.disabled = false;

            // Show fallback option
            document.getElementById('manualUploadSection').style.display = 'block';

            // Stop any existing stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }
    }

    async function detectFaces() {
        const canvas = faceOverlay;
        const displaySize = { width: faceVideo.videoWidth, height: faceVideo.videoHeight };
        faceapi.matchDimensions(canvas, displaySize);

        setInterval(async () => {
            const detections = await faceapi.detectAllFaces(faceVideo, new faceapi.TinyFaceDetectorOptions())
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
                faceStep3.innerHTML = 'Step 3: Keep only one face in view ✓';

                // Check eye blink
                const leftEye = landmarks.getLeftEye();
                const rightEye = landmarks.getRightEye();
                const leftEAR = getEyeAspectRatio(leftEye);
                const rightEAR = getEyeAspectRatio(rightEye);
                const ear = (leftEAR + rightEAR) / 2.0;

                if (ear < 0.25) { // Threshold for closed eyes
                    blinkDetected = true;
                    faceStep1.innerHTML = 'Step 1: Blink your eyes ✓';
                }

                // Check smile
                if (expressions.happy > 0.7) {
                    smileDetected = true;
                    faceStep2.innerHTML = 'Step 2: Smile ✓';
                }

                // Draw detections and landmarks
                faceapi.draw.drawDetections(canvas, resizedDetections);
                faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                // Check if all validations passed
                if (blinkDetected && smileDetected && singleFaceDetected && !photoCaptured) {
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
                faceStep1.innerHTML = 'Step 1: Blink your eyes';
                faceStep2.innerHTML = 'Step 2: Smile';
                faceStep3.innerHTML = 'Step 3: Keep only one face in view';
            }
        }, 100);
    }

    async function capturePhoto() {
        try {
            console.log('Capturing photo');

            if (!faceVideo.videoWidth || !faceVideo.videoHeight) {
                throw new Error('Video dimensions not available');
            }

            const canvas = document.createElement('canvas');
            canvas.width = faceVideo.videoWidth;
            canvas.height = faceVideo.videoHeight;
            const ctx = canvas.getContext('2d');

            if (!ctx) {
                throw new Error('Could not get canvas context');
            }

            ctx.drawImage(faceVideo, 0, 0);

            // Convert canvas to data URL
            const dataURL = canvas.toDataURL('image/png');
            console.log('Photo captured, data URL length:', dataURL.length);

            // Set the data URL to the hidden input
            profileImageData.value = dataURL;

            // Show preview
            capturedImage.src = dataURL;
            profileImagePreview.style.display = 'block';

            faceStatus.textContent = '✅ Profile picture captured successfully!';
            faceStatus.style.color = 'green';
            startFaceButton.style.display = 'none';

            // Stop the camera stream after successful capture
            stopCamera();

        } catch (error) {
            console.error('Error capturing photo:', error);
            faceStatus.textContent = '❌ Failed to capture photo: ' + error.message;
            faceStatus.style.color = 'red';
            startFaceButton.disabled = false;
        }
    }

    function stopCamera() {
        console.log('Stopping camera');
        if (stream) {
            stream.getTracks().forEach(track => {
                track.stop();
                console.log('Camera track stopped');
            });
            stream = null;
        }
        faceVideo.srcObject = null;
    }

    // Handle manual profile image upload
    document.getElementById('manualProfileImage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            console.log('Manual file selected:', file.name);

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                return;
            }

            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const dataURL = e.target.result;
                console.log('Manual file loaded, data URL length:', dataURL.length);

                // Set the data URL to the hidden input
                profileImageData.value = dataURL;

                // Show preview
                capturedImage.src = dataURL;
                profileImagePreview.style.display = 'block';

                faceStatus.textContent = '✅ Profile picture uploaded successfully!';
                faceStatus.style.color = 'green';
                startFaceButton.style.display = 'none';
                document.getElementById('manualUploadSection').style.display = 'none';
            };

            reader.onerror = function() {
                console.error('Error reading file');
                alert('Error reading the selected file.');
            };

            reader.readAsDataURL(file);
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        stopCamera();
    });
</script>
