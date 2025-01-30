<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="x-icon" href="image/2.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>NEMSU Cantilan Supply Tracking System</title>
</head>
<style>
    *{
        font-family: 'Poppins', sans-serif;
    }
    .h-font{
        font-family: 'Merienda', cursive;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    .availability-form{
        margin-top: -50px;
        z-index: 2;
        position: relative;
    }
    @media screen and (max-width: 575px){
        .availability-form{
            margin-top: 25px;
            padding: 0 35px;
        }
    }

    #dashboard-menu{
        position: fixed;
        height: 100%;
    }
    
    .card-body {
        max-height: 400px;  /* Adjust based on how much space you want for the table */
        overflow-y: auto;   /* Enables vertical scrolling when the table exceeds the height */
    }

    #qrTable {
        width: 100%;        /* Ensures the table spans the full width of the card-body */
        border-collapse: collapse;
    }

    #qrTable th, #qrTable td {
        text-align: left;
        padding: 8px;
    }

    #qrTable th {
        background-color: #f1f1f1;
    }

    .form-container {
        display: flex; /* Set flex container */
        max-width: 1200px;
        width: 100%;
        background-color: #fff;
        border: 1px solid #000;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .col-lg-6 {
        flex: 1; /* Ensure both columns take up equal space */
        display: flex;
        flex-direction: column;
    }

    .scanner-container {
        height: 100%; /* Take full height */
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid #ccc;
    }

    #preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-container .col-lg-6:first-child {
        padding-right: 15px;
    }

    .form-container .col-lg-6:last-child {
        padding-left: 15px;
    }

    /* Mobile-friendly styles */
    @media (max-width: 768px) {
        .form-container {
            flex-direction: column; /* Stack the form and scanner on smaller screens */
        }

        .scanner-container {
            margin-top: 20px;
        }

        .form-container .col-lg-6 {
            padding: 10px;
        }
    }

</style>
