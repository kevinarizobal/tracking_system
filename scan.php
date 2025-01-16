<!DOCTYPE html>
<html lang="en">
<?php include('link/header.php'); ?>
<body>
<?php include('link/navbar.php'); ?>
    <div class="container form-container mt-3" style="margin-left: 20%; width: 90%;">
        <div class="row">
            <!-- Left Side (Form) -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="text-center mb-4">
                    <img src="image/2.png" alt="University Logo" class="img-fluid" style="max-width: 80px;">
                    <h1 class="h4 mt-2">North Eastern Mindanao State University Cantilan Campus</h1>
                    <h2 class="h6">Government Property</h2>
                </div>
                <form id="property-form">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="article" class="form-label">Article:</label>
                            <input type="text" id="article" name="article" class="form-control">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="property-no" class="form-label">Property No.:</label>
                            <input type="text" id="property-no" name="property-no" class="form-control">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="serial-no" class="form-label">Serial No.:</label>
                            <input type="text" id="serial-no" name="serial-no" class="form-control" readonly>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="serviceable" name="serviceable" class="form-check-input">
                                <label for="serviceable" class="form-check-label">Serviceable</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="unserviceable" name="unserviceable" class="form-check-input">
                                <label for="unserviceable" class="form-check-label">Unserviceable</label>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="unit" class="form-label">Unit/Quantity:</label>
                            <input type="text" id="unit" name="unit" class="form-control">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="cost" class="form-label">Acquisition Cost:</label>
                            <input type="text" id="cost" name="cost" class="form-control">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="date-acquired" class="form-label">Date Acquired:</label>
                            <input type="date" id="date-acquired" name="date-acquired" class="form-control">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="date-counted" class="form-label">Date Counted:</label>
                            <input type="date" id="date-counted" name="date-counted" class="form-control">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="coa-representative" class="form-label">COA:</label>
                            <input type="text" id="coa-representative" name="coa-representative" class="form-control">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="property-custodian" class="form-label">Property Cust.</label>
                            <input type="text" id="property-custodian" name="property-custodian" class="form-control">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Right Side (Scanner) -->
            <div class="col-lg-6 col-md-12">
                <div class="scanner-container">
                    <video id="preview" class="w-100"></video>
                </div>
                <div class="text-center">
                    <p id="qr-result" class="fw-bold">Scan a QR code to see the result here.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Instascan QR Code Scanner Library -->
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        const scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        scanner.addListener('scan', function (content) {
            document.getElementById('qr-result').innerText = `Scanned Result: ${content}`;
            
            // Fetch data from the server
            fetch('fetch_qr_data.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ serial_no: content })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('article').value = data.article;
                        document.getElementById('property-no').value = data.property_id;
                        document.getElementById('serial-no').value = data.serial_id;
                        document.getElementById('unit').value = data.unit;
                        document.getElementById('cost').value = data.cost;
                        document.getElementById('date-acquired').value = data.date_acquired;
                        document.getElementById('date-counted').value = data.date_counted;
                        document.getElementById('coa-representative').value = data.coa_rep;
                        document.getElementById('property-custodian').value = data.property_cus;
                        document.getElementById('serviceable').checked = data.service_status === 'Serviceable';
                        document.getElementById('unserviceable').checked = data.service_status === 'Unserviceable';
                    } else {
                        alert(data.message || 'No data found for this QR code.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error("No cameras found.");
            }
        }).catch(function (e) {
            console.error(e);
        });

        // Handle form submission
        document.getElementById('property-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting normally

            const formData = new FormData(this);
            
            // Convert the form data to an object
            const formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            
            // Send the data to the server
            fetch('update_qr.php', {
                method: 'POST',
                body: new URLSearchParams(formObject)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Record updated successfully');
                } else {
                    alert(data.message || 'Error updating the record');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
