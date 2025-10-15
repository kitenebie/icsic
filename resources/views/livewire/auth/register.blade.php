<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {}; ?>

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

    #profileImagePreview {
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #faceVideoContainer {
        position: relative;
        display: inline-block;
    }

    /* #profileImagePreview {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.95);
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(2px);
        z-index: 10;
    } */

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

    .permission-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .permission-modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 400px;
        text-align: center;
    }

    .permission-modal button {
        margin: 5px;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Camera Access Alert Modal -->
    <div id="cameraAlertModal" class="permission-modal" style="display: none;">
        <div class="permission-modal-content">
            <h3>📷 Camera Access Required</h3>
            <p><strong>This website wants to access your camera</strong></p>
            <p>We need camera access to:</p>
            <ul style="text-align: left; margin: 10px 0;">
                <li>📸 Capture your profile picture</li>
                <li👤 Perform face detection for verification</li>
                <li>🎯 Ensure photo quality and proper positioning</li>
            </ul>
            <p style="font-size: 14px; color: #666; margin: 10px 0;">
                Your privacy is important. The camera will only be used during registration and no images are stored without your consent.
            </p>
            <div>
                <button id="proceedToCameraBtn" style="background: #4CAF50; color: white;">Continue to Camera</button>
                <button id="cancelCameraBtn" style="background: #f44336; color: white;">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Permission Modal -->
    <div id="permissionModal" class="permission-modal" style="display: none;">
        <div class="permission-modal-content">
            <h3>Camera Access Required</h3>
            <p id="permissionMessage">To capture your profile picture, we need access to your camera. Please allow camera access when prompted by your browser.</p>
            <div>
                <button id="allowCameraBtn" style="background: #4CAF50; color: white;">Allow Camera Access</button>
                <button id="skipCameraBtn" style="background: #f44336; color: white;">Skip Camera</button>
                <button id="tryAgainBtn" style="background: #2196F3; color: white; display: none;">Try Again</button>
            </div>
        </div>
    </div>

    <!-- Face Detection Section -->
    <div id="faceContainer">
        <h3 class="text-lg font-semibold mb-2">Profile Picture Capture</h3>

        <div id="faceVideoContainer">
            <video id="faceVideo" width="320" height="240" autoplay muted playsinline></video>
            <canvas id="faceOverlay"></canvas>
            <!-- Profile Picture Preview Overlay -->
            <div id="profileImagePreview">
                <p class="text-xs font-medium text-gray-700 mb-1">Profile Picture:</p>
                <img id="capturedImage" style="width: 320px !important; height: 240px !important;" width="320" height="240" src="" alt="Captured Profile Picture">
            </div>
        </div>

        <div id="faceStatus">💡 Click "Start Face Detection" to begin, or "Test Camera" to check camera access first.</div>
        <div id="faceInstructions">
            <p class="font-medium">Follow these steps in order:</p>
            <ul>
                <li id="faceStep1">Step 1: Keep only one face in view</li>
                <li id="faceStep2">Step 2: Smile (required before blinking)</li>
                <li id="faceStep3">Step 3: Blink your eyes (after smiling)</li>
            </ul>
        </div>

        <div class="flex gap-2 flex-wrap">
            <button type="button" id="startFaceButton"
                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Start Face
                Detection</button>
            {{-- <button type="button" id="testCameraBtn"
                class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm">🧪 Test Camera</button>
            <button type="button" id="toggleDebugBtn"
                class="mt-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">🔍 Debug</button>
            <button type="button" id="manualBlinkBtn"
                class="mt-2 px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm"
                style="display: none;">👁️ Manual Blink</button> --}}
        </div>


    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <form class="flex flex-col gap-6" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
    @csrf

    <!-- Draft Restore Section -->
    <div id="draftSection" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-800">Draft Found</p>
                    <p class="text-xs text-blue-600">You have unsaved form data from a previous session</p>
                </div>
            </div>
            <button type="button" id="restoreDraftBtn"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                Restore Draft
            </button>
        </div>
    </div>
        <!-- First Name -->
        <flux:input name="FirstName" :label="__('First Name')" type="text" required autofocus
            autocomplete="FirstName" :placeholder="__('First name')" />
        <!-- Last Name -->
        <flux:input name="LastName" :label="__('Last Name')" type="text" required autocomplete="LastName"
            :placeholder="__('Last name')" />
        <!-- Last Name -->
        <flux:input name="MiddleName" :label="__('Middle Name')" type="text" autocomplete="MiddleName"
            :placeholder="__('Middle name')" />
        <!-- Ext Name -->
        <flux:input name="extension_name" :label="__('Ext Name')" type="text" autocomplete="extension_name"
            :placeholder="__('Ext name')" />
        <!-- conact -->
        <flux:input name="contact" :label="__('Contact Number')" type="number" autocomplete="contact"
            :placeholder="__('Contact Number')" />
        <!-- Email Address -->
        <flux:input name="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Front ID -->
        <div>
            <label for="front_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Front ID</label>
            <input type="file" name="front_id" id="front_id" accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        </div>

        <!-- Back ID -->
        <div>
            <label for="back_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Back ID</label>
            <input type="file" name="back_id" id="back_id" accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        </div>

        <!-- Hidden Profile Image Input -->
        <input type="hidden" name="profile_image_data" id="profileImageData">

        <!-- Captcha Verification -->

        <div id="recaptcha-container" class="g-recaptcha" data-sitekey="6LeGqeorAAAAAPOFnXaHN-OX_b9EAUJgZ5YsBOfY"></div>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

        <!-- Captcha Alert Messages -->
        <div id="captcha-success" class="hidden p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Captcha verified successfully!</span>
        </div>

        <div id="captcha-error" class="hidden p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Please complete the captcha verification.</span>
        </div>

        <div class="flex items-center justify-end">
            <flux:button id="register-button" type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>

    <!-- Help Links -->
    <div class="text-center">
        <flux:link :href="route('faq')" class="text-sm text-blue-600 hover:text-blue-800" wire:navigate>
            {{ __('Need help? View FAQ') }}
        </flux:link>
    </div>
</div>

<script>
    // Enhanced camera permission and access management
    console.log('🚀 Enhanced face detection script loaded at:', new Date().toISOString());

    // Global variables
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
    const permissionModal = document.getElementById('permissionModal');
    const permissionMessage = document.getElementById('permissionMessage');

    // Debug display elements
    const debugDisplay = document.getElementById('debugDisplay');
    const earDisplay = document.getElementById('earDisplay');
    const calibrationDisplay = document.getElementById('calibrationDisplay');
    const blinkStatusDisplay = document.getElementById('blinkStatusDisplay');

    let blinkDetected = false;
    let smileDetected = false;
    let singleFaceDetected = false;
    let validationCount = 0;
    let photoCaptured = false;
    let stream = null;
    let currentPermissionState = 'unknown';

    // Enhanced blink detection variables
    let blinkHistory = [];
    let lastBlinkTime = 0;
    let blinkCalibrationFrames = 0;
    let baselineEAR = null;
    let earThreshold = 0.25;
    let consecutiveBlinkFrames = 0;
    let requiredConsecutiveFrames = 1; // Make it easier to detect

    // Speech synthesis for instructions
    function speak(text) {
        if ('speechSynthesis' in window) {
            // Cancel any ongoing speech
            speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.rate = 0.8; // Slightly slower for clarity
            utterance.pitch = 1;
            utterance.volume = 0.8;

            speechSynthesis.speak(utterance);
        } else {
            console.log('Speech synthesis not supported in this browser');
        }
    }

    // Enhanced camera permission manager
    class CameraPermissionManager {
        static async checkPermissionStatus() {
            try {
                if (!navigator.permissions) {
                    return 'unavailable';
                }
                
                const result = await navigator.permissions.query({ name: 'camera' });
                console.log('Camera permission status:', result.state);
                return result.state; // 'granted', 'denied', or 'prompt'
            } catch (error) {
                console.log('Permission API not available, will check via getUserMedia');
                return 'unavailable';
            }
        }

        static showPermissionModal(message, showTryAgain = false) {
            permissionMessage.textContent = message;
            document.getElementById('tryAgainBtn').style.display = showTryAgain ? 'inline-block' : 'none';
            permissionModal.style.display = 'flex';
        }

        static hidePermissionModal() {
            permissionModal.style.display = 'none';
        }

        static async requestCameraAccess(constraints = null) {
            const defaultConstraints = {
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user'
                }
            };

            try {
                console.log('Requesting camera access...');
                const stream = await navigator.mediaDevices.getUserMedia(constraints || defaultConstraints);
                console.log('✅ Camera access granted');
                currentPermissionState = 'granted';
                return stream;
            } catch (error) {
                console.error('❌ Camera access failed:', error);
                currentPermissionState = 'denied';
                this.handleCameraError(error);
                throw error;
            }
        }

        static handleCameraError(error) {
            let title = 'Camera Access Issue';
            let message = '';
            let showTryAgain = false;

            switch (error.name) {
                case 'NotAllowedError':
                    title = 'Camera Permission Denied';
                    message = 'Camera access was denied. To use the camera feature:\n\n' +
                             '1. Click the camera icon in your browser\'s address bar\n' +
                             '2. Select "Allow" for camera access\n' +
                             '3. Refresh the page and try again\n\n' +
                             'Or you can skip camera and upload a photo instead.';
                    showTryAgain = true;
                    break;

                case 'NotFoundError':
                    title = 'No Camera Found';
                    message = 'No camera device was found on your device. Please connect a camera and try again, or upload a photo instead.';
                    break;

                case 'NotReadableError':
                    title = 'Camera In Use';
                    message = 'Your camera is currently being used by another application. Please close other apps using the camera and try again.';
                    showTryAgain = true;
                    break;

                case 'OverconstrainedError':
                    title = 'Camera Quality Issue';
                    message = 'Your camera doesn\'t support the requested video quality. We\'ll try with lower settings.';
                    showTryAgain = true;
                    break;

                case 'SecurityError':
                    title = 'Security Restriction';
                    message = 'Camera access is blocked due to security settings. Please check your browser security settings.';
                    break;

                default:
                    title = 'Camera Error';
                    message = `An unexpected error occurred: ${error.message || 'Unknown error'}. Please try again or upload a photo instead.`;
                    showTryAgain = true;
            }

            this.showPermissionModal(`${title}\n\n${message}`, showTryAgain);
            
            // Update status in the main interface
            faceStatus.textContent = `❌ ${title}: ${error.message || 'Please see the popup for details'}`;
            faceStatus.style.color = 'red';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', async function() {
        console.log('DOM loaded, initializing enhanced face detection');

        // Check browser compatibility
        if (!checkBrowserCompatibility()) return;

        // Check HTTPS requirement
        if (!checkHTTPSRequirement()) return;

        // Check initial permission status
        const permissionStatus = await CameraPermissionManager.checkPermissionStatus();
        console.log('Initial permission status:', permissionStatus);

        updateDebugInfo();

        // Check if face-api.js loads properly
        checkFaceApiLoading();

        // Auto-show manual upload after 10 seconds if no action taken
        setTimeout(() => {
            if (!stream && !photoCaptured) {
                console.log('⏰ Auto-showing manual upload option after timeout');
                showManualUpload();
                faceStatus.textContent = '💡 Taking too long? Try the manual upload option below.';
                faceStatus.style.color = '#666';
            }
        }, 10000);
    });

    function checkBrowserCompatibility() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            faceStatus.textContent = '❌ Your browser does not support camera access. Please use a modern browser like Chrome, Firefox, or Edge.';
            faceStatus.style.color = 'red';
            startFaceButton.disabled = true;
            showManualUpload();
            return false;
        }
        return true;
    }

    function checkHTTPSRequirement() {
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            faceStatus.textContent = '⚠️ Camera access requires HTTPS. Please use HTTPS or localhost.';
            faceStatus.style.color = 'red';
            startFaceButton.disabled = true;
            showManualUpload();
            return false;
        }
        return true;
    }

    function checkFaceApiLoading() {
        setTimeout(function() {
            try {
                if (typeof faceapi !== 'undefined') {
                    console.log('✅ face-api.js loaded successfully');
                } else {
                    console.error('❌ face-api.js failed to load');
                    faceStatus.textContent = '❌ Face detection library failed to load. Internet connection issue.';
                    faceStatus.style.color = 'red';
                    showManualUpload();
                }
            } catch (error) {
                console.error('❌ Error checking face-api.js:', error);
            }
            updateDebugInfo();
        }, 2000);
    }

    function showManualUpload() {
        document.getElementById('manualUploadSection').style.display = 'block';
    }

    // Show camera alert modal first
    function showCameraAlertModal(callback) {
        document.getElementById('cameraAlertModal').style.display = 'flex';

        // Handle proceed button
        document.getElementById('proceedToCameraBtn').onclick = function() {
            document.getElementById('cameraAlertModal').style.display = 'none';
            callback();
        };

        // Handle cancel button
        document.getElementById('cancelCameraBtn').onclick = function() {
            document.getElementById('cameraAlertModal').style.display = 'none';
            faceStatus.textContent = '❌ Camera access cancelled by user.';
            faceStatus.style.color = 'orange';
        };
    }

    // Start face detection with enhanced permission handling
    startFaceButton.addEventListener('click', async () => {
        console.log('🚀 Start face detection button clicked');
        console.log('📋 Current browser info:', navigator.userAgent);
        console.log('🔒 Current protocol:', location.protocol);
        console.log('🌐 Current hostname:', location.hostname);

        // Check basic requirements first
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            console.error('❌ getUserMedia not supported');
            faceStatus.textContent = '❌ Your browser does not support camera access. Please use a modern browser like Chrome, Firefox, or Edge.';
            faceStatus.style.color = 'red';
            return;
        }

        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            console.error('❌ HTTPS required for camera access');
            faceStatus.textContent = '❌ Camera access requires HTTPS. Please use HTTPS or localhost.';
            faceStatus.style.color = 'red';
            return;
        }

        showCameraAlertModal(async () => {
            startFaceButton.disabled = true;
            faceStatus.textContent = '🔄 Starting face detection...';
            faceStatus.style.color = '#666';

            try {
                console.log('🔄 Calling startFaceDetection...');
                await startFaceDetection();
                console.log('✅ startFaceDetection completed');
            } catch (error) {
                console.error('❌ Error starting face detection:', error);
                faceStatus.textContent = '❌ Error: ' + error.message;
                faceStatus.style.color = 'red';
                startFaceButton.disabled = false;
            }
        });
    });

    // Test camera button
    document.getElementById('testCameraBtn').addEventListener('click', async () => {
        console.log('🧪 Testing basic camera access...');
        faceStatus.textContent = '🧪 Testing camera access...';
        faceStatus.style.color = '#666';

        try {
            // Simple camera test without face detection
            const testStream = await navigator.mediaDevices.getUserMedia({
                video: { width: 320, height: 240 }
            });

            console.log('✅ Basic camera test successful');
            faceStatus.textContent = '✅ Camera access works! You can now use face detection.';
            faceStatus.style.color = 'green';

            // Stop the test stream immediately
            testStream.getTracks().forEach(track => track.stop());

        } catch (error) {
            console.error('❌ Basic camera test failed:', error);
            faceStatus.textContent = '❌ Camera test failed: ' + error.message;
            faceStatus.style.color = 'red';

            // Show specific error messages
            if (error.name === 'NotAllowedError') {
                faceStatus.textContent += ' (Permission denied - please allow camera access)';
            } else if (error.name === 'NotFoundError') {
                faceStatus.textContent += ' (No camera found)';
            } else if (error.name === 'NotReadableError') {
                faceStatus.textContent += ' (Camera in use by another app)';
            }
        }
    });

    // Toggle debug display
    document.getElementById('toggleDebugBtn').addEventListener('click', () => {
        const debugDisplay = document.getElementById('debugDisplay');
        if (debugDisplay.style.display === 'none' || debugDisplay.style.display === '') {
            debugDisplay.style.display = 'block';
            document.getElementById('toggleDebugBtn').textContent = '🔍 Hide Debug';
        } else {
            debugDisplay.style.display = 'none';
            document.getElementById('toggleDebugBtn').textContent = '🔍 Show Debug';
        }
    });

    // Manual blink button (fallback)
    document.getElementById('manualBlinkBtn').addEventListener('click', () => {
        if (blinkCalibrationFrames >= 30 && !blinkDetected) {
            console.log('🎯 Manual blink triggered');
            blinkDetected = true;
            faceStep1.innerHTML = 'Step 1: Blink your eyes ✅ (Manual)';
            speak('Blink confirmed manually');
            document.getElementById('manualBlinkBtn').style.display = 'none';
            updateDebugDisplay(null, false);
        }
    });

    // Permission modal event listeners
    document.getElementById('allowCameraBtn').addEventListener('click', async () => {
        CameraPermissionManager.hidePermissionModal();

        // Show camera alert before requesting permission
        showCameraAlertModal(async () => {
            try {
                const stream = await CameraPermissionManager.requestCameraAccess();
                // If successful, continue with face detection
                if (stream) {
                    continueWithFaceDetection(stream);
                }
            } catch (error) {
                // Error already handled in CameraPermissionManager
            }
        });
    });


    document.getElementById('tryAgainBtn').addEventListener('click', async () => {
        CameraPermissionManager.hidePermissionModal();
        
        // Try with lower constraints if previous attempt failed
        const fallbackConstraints = {
            video: {
                width: { ideal: 320 },
                height: { ideal: 240 },
                facingMode: 'user'
            }
        };

        try {
            const stream = await CameraPermissionManager.requestCameraAccess(fallbackConstraints);
            if (stream) {
                continueWithFaceDetection(stream);
            }
        } catch (error) {
            // If still fails, show manual upload
            showManualUpload();
        }
    });

    function hideAllCameraButtons() {
        document.getElementById('startFaceButton').style.display = 'none';
    }

    async function startFaceDetection() {
        try {
            console.log('🚀 Starting face detection initialization');

            // Check if face-api.js is loaded
            if (typeof faceapi === 'undefined') {
                throw new Error('face-api.js library not loaded. Please check your internet connection.');
            }

            // Check permission status first
            const permissionStatus = await CameraPermissionManager.checkPermissionStatus();
            console.log('📋 Permission status:', permissionStatus);

            if (permissionStatus === 'denied') {
                CameraPermissionManager.showPermissionModal(
                    'Camera access was previously denied. Please allow camera access in your browser settings and refresh the page.',
                    true
                );
                return;
            }

            faceStatus.textContent = '📚 Loading face detection models...';
            console.log('📥 Loading face-api models...');

            // Load models with progress updates
            try {
                await faceapi.nets.tinyFaceDetector.loadFromUri(
                    'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/');
                console.log('✅ TinyFaceDetector loaded');
                faceStatus.textContent = '📚 Loading models... 33%';

                await faceapi.nets.faceLandmark68Net.loadFromUri(
                    'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/');
                console.log('✅ FaceLandmark68Net loaded');
                faceStatus.textContent = '📚 Loading models... 66%';

                await faceapi.nets.faceExpressionNet.loadFromUri(
                    'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js/weights/');
                console.log('✅ FaceExpressionNet loaded');
                faceStatus.textContent = '📚 Models loaded successfully!';

            } catch (modelError) {
                console.error('❌ Error loading models:', modelError);
                throw new Error('Failed to load face detection models. Please check your internet connection.');
            }

            console.log('✅ All models loaded successfully');
            faceStatus.textContent = '📹 Requesting camera access...';

            // Request camera access
            console.log('📷 Requesting camera access...');
            stream = await CameraPermissionManager.requestCameraAccess();
            console.log('✅ Camera access granted');

            continueWithFaceDetection(stream);

        } catch (error) {
            console.error('❌ Error in startFaceDetection:', error);
            faceStatus.textContent = '❌ Error: ' + error.message;
            faceStatus.style.color = 'red';
            startFaceButton.disabled = false;

            // Show manual upload option on error
            setTimeout(() => {
                showManualUpload();
            }, 2000);
        }
    }

    async function continueWithFaceDetection(cameraStream) {
        try {
            stream = cameraStream;
            console.log('✅ Camera access granted, setting up video stream');
            faceVideo.srcObject = stream;

            // Wait for video to be ready
            await new Promise((resolve) => {
                faceVideo.addEventListener('loadedmetadata', () => {
                    console.log('📺 Video metadata loaded, dimensions:', faceVideo.videoWidth, 'x', faceVideo.videoHeight);
                    resolve();
                });
            });

            faceStatus.textContent = '🎯 Camera ready. Keep your face in view, smile first, then blink to complete validation!';
            faceStatus.style.color = 'blue';
            faceInstructions.style.display = 'block';

            // Speak initial instruction - Step 1
            speak('Step 1: Keep only one face in view');

            // Start face detection
            detectFaces();

        } catch (error) {
            console.error('❌ Error in continueWithFaceDetection:', error);
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            startFaceButton.disabled = false;
        }
    }

    // Euclidean distance calculation
    function euclideanDistance(p1, p2) {
        return Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));
    }

    // Enhanced eye aspect ratio calculation for blink detection
    function getEyeAspectRatio(eye) {
        if (!eye || eye.length < 6) {
            return 1.0; // Return open eye ratio if landmarks are invalid
        }

        try {
            const A = euclideanDistance(eye[1], eye[5]);
            const B = euclideanDistance(eye[2], eye[4]);
            const C = euclideanDistance(eye[0], eye[3]);

            if (C === 0) return 1.0; // Prevent division by zero

            const ear = (A + B) / (2.0 * C);

            // Validate EAR is within reasonable bounds
            if (ear < 0 || ear > 1 || isNaN(ear)) {
                return 1.0;
            }

            return ear;
        } catch (error) {
            console.warn('Error calculating EAR:', error);
            return 1.0;
        }
    }

    // Enhanced blink detection with calibration and temporal consistency
    function detectBlink(leftEye, rightEye) {
        const leftEAR = getEyeAspectRatio(leftEye);
        const rightEAR = getEyeAspectRatio(rightEye);
        const avgEAR = (leftEAR + rightEAR) / 2.0;

        // Log EAR values for debugging
        console.log(`👁️ EAR Values - Left: ${leftEAR.toFixed(3)}, Right: ${rightEAR.toFixed(3)}, Avg: ${avgEAR.toFixed(3)}`);

        // Calibration phase - collect baseline EAR for first 30 frames
        if (blinkCalibrationFrames < 30) {
            blinkHistory.push(avgEAR);
            blinkCalibrationFrames++;

            console.log(`📊 Calibration Frame ${blinkCalibrationFrames}/30 - EAR: ${avgEAR.toFixed(3)}`);

            if (blinkCalibrationFrames === 30) {
                // Calculate baseline EAR (average of collected frames)
                baselineEAR = blinkHistory.reduce((sum, ear) => sum + ear, 0) / blinkHistory.length;

                // Set dynamic threshold based on baseline (25% below baseline for maximum sensitivity)
                earThreshold = Math.max(0.08, baselineEAR * 0.75);

                console.log(`🔍 Blink calibration complete. Baseline EAR: ${baselineEAR.toFixed(3)}, Threshold: ${earThreshold.toFixed(3)}`);
                console.log(`📊 EAR History: [${blinkHistory.map(ear => ear.toFixed(3)).join(', ')}]`);

                // Update status to show calibration is complete
                faceStatus.textContent = `🎯 Blink detection calibrated! Baseline: ${baselineEAR.toFixed(3)}, Threshold: ${earThreshold.toFixed(3)}. Now blink your eyes!`;
                faceStatus.style.color = 'green';

                // Add visual indicator that blink detection is ready
                faceStep1.innerHTML = 'Step 1: Blink your eyes (Ready!)';
                faceStep1.style.color = 'blue';

                // Show manual blink button as fallback
                document.getElementById('manualBlinkBtn').style.display = 'inline-block';
            } else if (blinkCalibrationFrames % 10 === 0) {
                // Show calibration progress
                const progress = Math.round((blinkCalibrationFrames / 30) * 100);
                faceStatus.textContent = `🔄 Calibrating blink detection... ${progress}% (Current EAR: ${avgEAR.toFixed(3)})`;
            }
            updateDebugDisplay(avgEAR, false);
            return false;
        }

        // Check for blink using dynamic threshold
        const isBlinking = avgEAR < earThreshold;

        console.log(`🎯 Blink Check - EAR: ${avgEAR.toFixed(3)}, Threshold: ${earThreshold.toFixed(3)}, Is Blinking: ${isBlinking}, Consecutive: ${consecutiveBlinkFrames}`);

        if (isBlinking) {
            consecutiveBlinkFrames++;

            console.log(`⚡ Blink detected! Consecutive frames: ${consecutiveBlinkFrames}/${requiredConsecutiveFrames}`);

            // Require multiple consecutive frames to confirm blink
            if (consecutiveBlinkFrames >= requiredConsecutiveFrames) {
                // Check timing to prevent rapid repeated detections
                const currentTime = Date.now();
                if (currentTime - lastBlinkTime > 1000) { // Minimum 1 second between blinks
                    console.log(`✅ BLINK CONFIRMED! Time since last blink: ${(currentTime - lastBlinkTime)}ms`);
                    lastBlinkTime = currentTime;
                    consecutiveBlinkFrames = 0;
                    updateDebugDisplay(avgEAR, false); // Reset to normal after confirmation
                    return true;
                } else {
                    console.log(`⏳ Blink too soon (${currentTime - lastBlinkTime}ms < 1000ms), ignoring`);
                }
            }
        } else {
            if (consecutiveBlinkFrames > 0) {
                console.log(`❌ Blink sequence broken, resetting counter`);
            }
            consecutiveBlinkFrames = 0;
        }

        updateDebugDisplay(avgEAR, isBlinking);
        return false;
    }

    // Reset blink detection state
    function resetBlinkDetection() {
        blinkHistory = [];
        blinkCalibrationFrames = 0;
        baselineEAR = null;
        earThreshold = 0.25;
        consecutiveBlinkFrames = 0;
        lastBlinkTime = 0;
        updateDebugDisplay();
    }

    // Update debug display with current values
    function updateDebugDisplay(currentEAR = null, isBlinking = false) {
        if (!debugDisplay) return;

        // Show debug display during face detection
        debugDisplay.style.display = 'block';

        // Update EAR and threshold display
        const earText = currentEAR !== null ? currentEAR.toFixed(3) : '--';
        const thresholdText = '0.250'; // Fixed threshold
        const statusText = isBlinking ? 'BLINKING!' : 'Normal';
        const statusColor = isBlinking ? 'red' : 'green';

        earDisplay.innerHTML = `EAR: <span style="color: blue;">${earText}</span> | Threshold: <span style="color: orange;">${thresholdText}</span> | Status: <span style="color: ${statusColor};">${statusText}</span>`;

        // Update blink status
        let blinkStatusText = 'Ready';
        if (blinkDetected) {
            blinkStatusText = '✅ Blink detected!';
        } else {
            blinkStatusText = '👁️ Waiting for blink...';
        }
        blinkStatusDisplay.innerHTML = `Blink Status: ${blinkStatusText}`;
        calibrationDisplay.innerHTML = `Using fixed threshold: 0.25`;
    }

    async function detectFaces() {
        const canvas = faceOverlay;
        const displaySize = {
            width: faceVideo.videoWidth,
            height: faceVideo.videoHeight
        };
        faceapi.matchDimensions(canvas, displaySize);

        const detectionInterval = setInterval(async () => {
            try {
                const detections = await faceapi.detectAllFaces(faceVideo, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceExpressions();

                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

                // Remove overlay drawing - no visual overlay needed
                // faceapi.draw.drawDetections(canvas, resizedDetections);
                // faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

                if (detections.length === 1) {
                    const detection = detections[0];
                    const landmarks = detection.landmarks;
                    const expressions = detection.expressions;

                    // Check single face
                    if (!singleFaceDetected) {
                        singleFaceDetected = true;
                        faceStep1.innerHTML = 'Step 1: Keep only one face in view ✅';
                        speak('Step 1 completed. Now smile first, then blink your eyes to complete validation');
                    }

                    // Check eye blink (only after smile is detected)
                    const leftEye = landmarks.getLeftEye();
                    const rightEye = landmarks.getRightEye();
                    const leftEAR = getEyeAspectRatio(leftEye);
                    const rightEAR = getEyeAspectRatio(rightEye);
                    const ear = (leftEAR + rightEAR) / 2.0;

                    if (ear < 0.25) {
                        if (smileDetected) {
                            if (!blinkDetected) {
                                blinkDetected = true;
                                faceStep3.innerHTML = 'Step 3: Blink your eyes ✅';
                                speak('Blink detected. All validations complete');
                                console.log('👁️ Blink detected with EAR:', ear.toFixed(3));
                            }
                        } else {
                            // User tried to blink before smiling
                            if (!blinkDetected) {
                                faceStatus.textContent = '😊 Please smile first before blinking your eyes!';
                                speak('Please smile first');
                                console.log('👁️ Blink attempted before smile - rejected');
                            }
                        }
                    }

                    // Check smile
                    if (expressions.happy > 0.7) {
                        if (!smileDetected) {
                            smileDetected = true;
                            if (blinkDetected) {
                                faceStep2.innerHTML = 'Step 2: Smile ✅';
                                speak('Smile detected. All validations complete');
                            } else {
                                faceStep2.innerHTML = 'Step 2: Smile ✅ (waiting for blink)';
                            }
                        }
                    }

                    // Face detected successfully - no visual overlay needed

                    // Check if all validations passed
                    if (blinkDetected && smileDetected && singleFaceDetected && !photoCaptured) {
                        validationCount++;
                        if (validationCount === 1) {
                            speak('Validation in progress');
                        }
                        faceStatus.textContent = `🎯 Validating... ${validationCount}/5`;
                        if (validationCount >= 5) {
                            clearInterval(detectionInterval);
                            faceStatus.textContent = '✅ Validation completed! All steps successful.';
                            faceStatus.style.color = 'green';
                            speak('All steps completed successfully. Capturing your profile photo now');
                            setTimeout(() => {
                                capturePhoto();
                            }, 1000); // Brief pause to show completion message
                            photoCaptured = true;
                        }
                    } else {
                        validationCount = 0;
                        // Reset status if validation is broken
                        if (blinkDetected || smileDetected || singleFaceDetected) {
                            faceStatus.textContent = '⏳ Validation in progress...';
                            faceStatus.style.color = '#666';
                        }
                    }
                } else if (detections.length === 0) {
                    faceStatus.textContent = '👤 No face detected. Please position your face in the camera view.';
                    if (!singleFaceDetected) {
                        speak('No face detected. Please position your face in the camera view');
                    }
                    resetValidations();
                } else {
                    faceStatus.textContent = `👥 Multiple faces detected (${detections.length}). Please ensure only one person is in view.`;
                    speak('Multiple faces detected. Please ensure only one person is in view');
                    resetValidations();
                }
            } catch (error) {
                console.error('Error in face detection:', error);
                clearInterval(detectionInterval);
                faceStatus.textContent = '❌ Face detection error. Please try again.';
                faceStatus.style.color = 'red';
                startFaceButton.disabled = false;
            }
        }, 100);
    }

    function resetValidations() {
        blinkDetected = false;
        smileDetected = false;
        singleFaceDetected = false;
        validationCount = 0;
        faceStep1.innerHTML = 'Step 1: Keep only one face in view';
        faceStep2.innerHTML = 'Step 2: Smile';
        faceStep3.innerHTML = 'Step 3: Blink your eyes';

        // Reset enhanced blink detection
        resetBlinkDetection();
    }

    async function capturePhoto() {
        try {
            console.log('📷 Capturing photo');

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
            const dataURL = canvas.toDataURL('image/png');
            console.log('✅ Photo captured, data URL length:', dataURL.length);

            profileImageData.value = dataURL;
            capturedImage.src = dataURL;
            profileImagePreview.style.display = 'block';

            // Hide the video element after capturing
            faceVideo.style.display = 'none';

            faceStatus.textContent = '🎉 Profile picture captured successfully!';
            faceStatus.style.color = 'green';
            speak('Profile picture captured successfully');
            hideAllCameraButtons();

            stopCamera();

        } catch (error) {
            console.error('❌ Error capturing photo:', error);
            faceStatus.textContent = '❌ Failed to capture photo: ' + error.message;
            faceStatus.style.color = 'red';
            startFaceButton.disabled = false;
        }
    }

    function stopCamera() {
        console.log('📹 Stopping camera');
        if (stream) {
            stream.getTracks().forEach(track => {
                track.stop();
                console.log('Camera track stopped');
            });
            stream = null;
        }
        faceVideo.srcObject = null;
    }



    // Enhanced debug panel functionality
    async function updateDebugInfo() {
        try {
            // Browser info
            const browserInfo = navigator.userAgent;
            document.getElementById('browserInfo').textContent = browserInfo.substring(0, 50) + '...';

            // HTTPS info
            const httpsInfo = location.protocol === 'https:' ? '✅ Yes' :
                location.hostname === 'localhost' || location.hostname === '127.0.0.1' ? '✅ Localhost (OK)' :
                '❌ No (Camera requires HTTPS)';
            document.getElementById('httpsInfo').textContent = httpsInfo;

            // Camera API info
            const cameraApiInfo = navigator.mediaDevices && navigator.mediaDevices.getUserMedia ?
                '✅ Available' : '❌ Not available';
            document.getElementById('cameraApiInfo').textContent = cameraApiInfo;

            // Face API info
            const faceApiInfo = typeof faceapi !== 'undefined' ? '✅ Loaded' : '❌ Not loaded';
            document.getElementById('faceApiInfo').textContent = faceApiInfo;

            // Video element info
            const videoElementInfo = faceVideo ? '✅ Found' : '❌ Not found';
            document.getElementById('videoElementInfo').textContent = videoElementInfo;

            // Permission status
            let permissionInfo = 'Checking...';
            try {
                const permissionStatus = await CameraPermissionManager.checkPermissionStatus();
                switch (permissionStatus) {
                    case 'granted':
                        permissionInfo = '✅ Granted';
                        break;
                    case 'denied':
                        permissionInfo = '❌ Denied';
                        break;
                    case 'prompt':
                        permissionInfo = '❓ Will prompt';
                        break;
                    default:
                        permissionInfo = '❓ Unknown';
                }
            } catch (error) {
                permissionInfo = '❓ Cannot check';
            }
            document.getElementById('permissionStatus').textContent = permissionInfo;

        } catch (error) {
            console.error('Error updating debug info:', error);
        }
    }

    // Refresh debug info button
    document.getElementById('refreshDebug').addEventListener('click', updateDebugInfo);

    // Handle page visibility change (user switches tabs)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && stream) {
            console.log('📱 Page hidden, pausing camera');
            // Optionally pause face detection when page is hidden
        } else if (!document.hidden && stream) {
            console.log('📱 Page visible, resuming camera');
            // Resume face detection when page becomes visible
        }
    });

    // Enhanced error handling for JavaScript errors
    window.addEventListener('error', function(e) {
        console.error('🚨 JavaScript Error:', e.error);
        console.error('📍 Error location:', e.filename, 'line:', e.lineno);
        
        // If it's a critical error related to face detection, show manual upload
        if (e.error && (e.error.message.includes('faceapi') || e.error.message.includes('camera'))) {
            showManualUpload();
            faceStatus.textContent = '❌ Technical error occurred. Please use manual upload.';
            faceStatus.style.color = 'red';
        }
    });

    // Enhanced error handling for unhandled promise rejections
    window.addEventListener('unhandledrejection', function(e) {
        console.error('🚨 Unhandled Promise Rejection:', e.reason);
        
        // Handle specific camera-related promise rejections
        if (e.reason && typeof e.reason === 'object') {
            if (e.reason.name && ['NotAllowedError', 'NotFoundError', 'NotReadableError'].includes(e.reason.name)) {
                CameraPermissionManager.handleCameraError(e.reason);
                e.preventDefault(); // Prevent the default unhandled rejection behavior
            }
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        console.log('🔄 Page unloading, cleaning up camera resources');
        stopCamera();
    });

    // Handle browser back/forward navigation
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            console.log('📄 Page restored from cache');
            updateDebugInfo();
        }
    });

    // Auto-hide modals if user clicks outside
    document.getElementById('cameraAlertModal').addEventListener('click', function(e) {
        if (e.target === document.getElementById('cameraAlertModal')) {
            // Don't auto-hide for camera alerts - user should make a conscious choice
            console.log('🖱️ User clicked outside camera alert modal - requires explicit choice');
        }
    });

    permissionModal.addEventListener('click', function(e) {
        if (e.target === permissionModal) {
            // Don't auto-hide for camera permissions - user should make a conscious choice
            console.log('🖱️ User clicked outside modal - camera permissions require explicit choice');
        }
    });

    // Keyboard accessibility for both modals
    document.addEventListener('keydown', function(e) {
        // Handle camera alert modal
        if (document.getElementById('cameraAlertModal').style.display === 'flex') {
            if (e.key === 'Escape') {
                // ESC key acts like "Cancel"
                document.getElementById('cancelCameraBtn').click();
            } else if (e.key === 'Enter') {
                // Enter key acts like "Continue to Camera"
                document.getElementById('proceedToCameraBtn').click();
            }
        }
        // Handle permission modal
        else if (permissionModal.style.display === 'flex') {
            if (e.key === 'Escape') {
                // ESC key acts like "Skip Camera"
                document.getElementById('skipCameraBtn').click();
            } else if (e.key === 'Enter') {
                // Enter key acts like "Allow Camera"
                document.getElementById('allowCameraBtn').click();
            }
        }
    });

    // Progressive enhancement - check for advanced camera features
    async function checkAdvancedCameraFeatures() {
        try {
            if (navigator.mediaDevices && navigator.mediaDevices.getSupportedConstraints) {
                const supportedConstraints = navigator.mediaDevices.getSupportedConstraints();
                console.log('📋 Supported camera constraints:', supportedConstraints);
                
                // Check for specific features we might want to use
                const advancedFeatures = {
                    facingMode: supportedConstraints.facingMode || false,
                    width: supportedConstraints.width || false,
                    height: supportedConstraints.height || false,
                    frameRate: supportedConstraints.frameRate || false,
                    aspectRatio: supportedConstraints.aspectRatio || false
                };
                
                console.log('🔧 Advanced camera features available:', advancedFeatures);
                return advancedFeatures;
            }
        } catch (error) {
            console.log('ℹ️ Could not check advanced camera features:', error);
        }
        return null;
    }

    // Initialize advanced features check
    checkAdvancedCameraFeatures();

    // Final initialization message
    console.log('🎬 Enhanced camera permission system initialized successfully');
    console.log('📱 System ready for camera access and face detection');

    // ===== DRAFT FUNCTIONALITY =====
    const DRAFT_KEY = 'registrationDraft';
    const form = document.getElementById('registrationForm');
    const draftSection = document.getElementById('draftSection');
    const restoreDraftBtn = document.getElementById('restoreDraftBtn');

    // Function to save form data to localStorage
    function saveDraft() {
        const formData = new FormData(form);
        const data = {};

        // Convert FormData to object
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                // Skip file inputs for draft (can't store files in localStorage)
                continue;
            }
            data[key] = value;
        }

        // Add profile image data if available
        if (profileImageData && profileImageData.value) {
            data['profile_image_data'] = profileImageData.value;
        }

        // Only save if there's actual data
        if (Object.keys(data).length > 1) { // More than just _token
            localStorage.setItem(DRAFT_KEY, JSON.stringify(data));
            console.log('💾 Draft saved:', data);
        }
    }

    // Function to load draft from localStorage
    function loadDraft() {
        const saved = localStorage.getItem(DRAFT_KEY);
        if (saved) {
            try {
                const data = JSON.parse(saved);
                console.log('📂 Draft loaded:', data);

                // Populate form fields
                Object.keys(data).forEach(key => {
                    const element = document.querySelector(`[name="${key}"]`);
                    if (element && key !== '_token' && key !== 'profile_image_data') {
                        element.value = data[key];
                    }
                });

                // Restore profile image if available
                if (data.profile_image_data) {
                    profileImageData.value = data.profile_image_data;
                    capturedImage.src = data.profile_image_data;
                    profileImagePreview.style.display = 'block';
                    faceStatus.textContent = '✅ Profile picture restored from draft!';
                    faceStatus.style.color = 'green';
                }

                return true;
            } catch (error) {
                console.error('❌ Error loading draft:', error);
                return false;
            }
        }
        return false;
    }

    // Function to clear draft
    function clearDraft() {
        localStorage.removeItem(DRAFT_KEY);
        console.log('🗑️ Draft cleared');
    }

    // Check for existing draft on page load
    document.addEventListener('DOMContentLoaded', function() {
        const saved = localStorage.getItem(DRAFT_KEY);
        if (saved) {
            try {
                const data = JSON.parse(saved);
                if (Object.keys(data).length > 1) { // Has actual data
                    draftSection.classList.remove('hidden');
                    console.log('📋 Draft found, showing restore button');
                }
            } catch (error) {
                console.error('❌ Error checking draft:', error);
            }
        }
    });

    // Handle restore draft button click
    restoreDraftBtn.addEventListener('click', function() {
        if (loadDraft()) {
            draftSection.classList.add('hidden');
            clearDraft(); // Clear after successful restore
            console.log('✅ Draft restored successfully');
        } else {
            alert('❌ Failed to restore draft. The saved data may be corrupted.');
        }
    });

    // Auto-save draft on form changes
    let saveTimeout;
    function scheduleSave() {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveDraft, 1000); // Save after 1 second of inactivity
    }

    // Listen for input changes
    document.addEventListener('input', function(e) {
        if (e.target.closest('#registrationForm')) {
            scheduleSave();
        }
    });

    // Listen for file changes
    document.addEventListener('change', function(e) {
        if (e.target.closest('#registrationForm')) {
            scheduleSave();
        }
    });

    // Save draft when profile image is captured
    const originalCapturePhoto = window.capturePhoto;
    window.capturePhoto = function() {
        if (originalCapturePhoto) {
            originalCapturePhoto();
        }
        // Save draft after photo capture
        setTimeout(saveDraft, 500);
    };

    console.log('📝 Draft functionality initialized');

    // ===== CAPTCHA VERIFICATION =====
    // Global callback functions for reCAPTCHA
    function onRegisterCaptchaSuccess() {
        document.getElementById('captcha-success').classList.remove('hidden');
        document.getElementById('captcha-error').classList.add('hidden');
        document.getElementById('register-button').disabled = false;
    }

    function onRegisterCaptchaExpired() {
        document.getElementById('captcha-success').classList.add('hidden');
        document.getElementById('captcha-error').classList.remove('hidden');
        document.getElementById('captcha-error').querySelector('span').textContent = 'Captcha has expired. Please verify again.';
        document.getElementById('register-button').disabled = true;
    }

    // Form submission handler for captcha verification
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registrationForm');
        const registerButton = document.getElementById('register-button');

        if (registerForm && registerButton) {
            registerForm.addEventListener('submit', function(e) {
                const recaptchaResponse = grecaptcha.getResponse();

                if (!recaptchaResponse) {
                    e.preventDefault();
                    document.getElementById('captcha-success').classList.add('hidden');
                    document.getElementById('captcha-error').classList.remove('hidden');
                    document.getElementById('captcha-error').querySelector('span').textContent = 'Please complete the captcha verification.';
                    return false;
                }

                // Disable button during submission
                registerButton.disabled = true;
                registerButton.textContent = 'Creating account...';
            });
        }
    });

    // Debug function to check if reCAPTCHA loaded
    function checkRecaptchaLoaded() {
        if (typeof grecaptcha === 'undefined') {
            console.error('reCAPTCHA not loaded');
            // Show error message to user
            const captchaError = document.getElementById('captcha-error');
            if (captchaError) {
                captchaError.classList.remove('hidden');
                captchaError.querySelector('span').textContent = 'Captcha failed to load. Please refresh the page.';
            }
        } else {
            console.log('reCAPTCHA loaded successfully');
        }
    }

    // Check reCAPTCHA after page load
    window.addEventListener('load', function() {
        setTimeout(checkRecaptchaLoaded, 2000);
    });
</script>
<script>
    var onloadCallback = function() {
        grecaptcha.render('recaptcha-container', {
            'sitekey': '6LeGqeorAAAAAPOFnXaHN-OX_b9EAUJgZ5YsBOfY',
            'callback': function(response) {
                // Captcha verified successfully
                document.getElementById('captcha-success').classList.remove('hidden');
                document.getElementById('captcha-error').classList.add('hidden');
                document.getElementById('register-button').disabled = false;
            },
            'expired-callback': function() {
                // Captcha expired
                document.getElementById('captcha-success').classList.add('hidden');
                document.getElementById('captcha-error').classList.remove('hidden');
                document.getElementById('captcha-error').querySelector('span').textContent = 'Captcha has expired. Please verify again.';
                document.getElementById('register-button').disabled = true;
            }
        });
    };

    // Form submission handler
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const registerButton = document.getElementById('register-button');

        if (form && registerButton) {
            form.addEventListener('submit', function(e) {
                const recaptchaResponse = grecaptcha.getResponse();

                if (!recaptchaResponse) {
                    e.preventDefault();
                    document.getElementById('captcha-success').classList.add('hidden');
                    document.getElementById('captcha-error').classList.remove('hidden');
                    document.getElementById('captcha-error').querySelector('span').textContent = 'Please complete the captcha verification.';
                    return false;
                }

                // Disable button during submission
                registerButton.disabled = true;
                registerButton.textContent = 'Submitting...';
            });
        }
    });
</script>