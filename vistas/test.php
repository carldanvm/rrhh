<?php
include "includes/header.php";
?>

<div class="container">
    <div class="row full-page">
        <div class="col-12">
            <div class="d-flex flex-column align-items-center">
                <div style="position: relative; width: 500px; height: 500px; overflow: hidden;">
                    <video id="video" width="500" height="500" autoplay style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;"></video>
                    <canvas id="canvas" width="500" height="500" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></canvas>
                </div>
                <button id="capture" class="btn btn-primary mt-3">
                    Capturar cara
                </button>
                <div id="faceData" class="mt-3 bg-light w-100" style="max-width: 500px;">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/libs/face-api.min.js"></script>
<script src="js/face-recognition.js"></script>
<?php
include "includes/footer.php";
?>