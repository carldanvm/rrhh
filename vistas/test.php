<?php
include "includes/header.php";
?>
<div class="container">
    <div class="row full-page">
        <div class="col-12">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3">
                    <input type="file" id="imageUpload" class="form-control" accept="image/*">
                </div>
                <div class="mt-3">
                    <button id="capture" class="btn btn-primary">Analizar Cara</button>
                </div>
                <div id="faceData" class="mt-3 bg-light w-100" style="max-width: 500px; padding: 15px;">
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