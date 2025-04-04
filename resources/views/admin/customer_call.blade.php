@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center flex-grow-1">
            <h4 class="fw-bold">PRATHYA FOODS PVT LTD</h4>
            <h5><u>VAIKOM</u></h5>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    @if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-center my-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="visit_status" checked>
            <label class="form-check-label" for="visit_status" id="status_label">IN</label>
        </div>
    </div>

    <form action="{{ route('customer_visits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="visit_status" id="hidden_status" value="IN">

        <div class="mb-3">
            <label for="gst_number" class="form-label">GST NUMBER</label>
            <input type="text" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" name="gst_number" value="{{ old('gst_number') }}" required>
            @error('gst_number')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pincode" class="form-label">PINCODE</label>
            <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" value="{{ old('pincode') }}" required>
            @error('pincode')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 text-center">
            <label class="form-label">Capture Image</label>
            <video id="camera" class="d-none mx-auto" width="300" height="200" autoplay></video>
            <canvas id="canvas" class="d-none"></canvas>
            <img id="captured_image" class="d-none img-thumbnail mx-auto" width="300">

            <button type="button" id="captureBtn" class="btn btn-primary mt-2">Capture</button>
            <input type="hidden" id="image_data" name="image_data">

            @error('image_data')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <div class="text-center">
            <button type="submit" class="btn btn-success w-100">Submit Entry</button>
        </div>
    </form>
</div>

<script>
    // Handle IN/OUT Toggle
    document.getElementById("visit_status").addEventListener("change", function() {
        let statusLabel = document.getElementById("status_label");
        let hiddenStatus = document.getElementById("hidden_status");

        if (this.checked) {
            statusLabel.textContent = "IN";
            hiddenStatus.value = "IN";
        } else {
            statusLabel.textContent = "OUT";
            hiddenStatus.value = "OUT";
        }
    });

    // Get Geolocation
    document.addEventListener("DOMContentLoaded", function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });

    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const imageInput = document.getElementById('image_data');
    const capturedImage = document.getElementById('captured_image');

    let cameraStream = null;
    let isCameraOn = false;

    captureBtn.addEventListener('click', async function() {
        if (captureBtn.textContent === "Capture") {
            await startCamera();
            captureBtn.textContent = "Take Photo";
            return;
        }

        if (captureBtn.textContent === "Take Photo") {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/png');
            imageInput.value = imageData;

            capturedImage.src = imageData;
            capturedImage.classList.remove("d-none");
            video.classList.add("d-none");

            stopCamera();

            captureBtn.textContent = "Retake";
            return;
        }

        if (captureBtn.textContent === "Retake") {
            capturedImage.classList.add("d-none");
            await startCamera();
            captureBtn.textContent = "Take Photo";
        }
    });

    async function startCamera() {
        try {
            if (!isCameraOn) {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                video.srcObject = cameraStream;
                video.classList.remove("d-none");
                isCameraOn = true;
            }
        } catch (err) {
            console.error("Camera access denied:", err);
            alert("Unable to access camera.");
        }
    }

    function stopCamera() {
        if (cameraStream) {
            let tracks = cameraStream.getTracks();
            tracks.forEach(track => track.stop());
            isCameraOn = false;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let successToast = document.getElementById('successToast');
        if (successToast) {
            let toast = new bootstrap.Toast(successToast);
            toast.show();

            setTimeout(() => {
                toast.hide();
            }, 3000);
        }
    });
</script>
@endsection