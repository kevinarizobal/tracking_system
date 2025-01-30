<?php 
// Check if the user is logged in and has a role
if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $role = $_SESSION['Role']; 
}
?>


<nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand text-dark d-flex align-items-center">
        <img src="image/2.png" class="img-fluid shadow-1" style="max-height: 50px;" alt="Logo">
        <h3 class="ms-2 mb-0 text-white" style="font-size: 1.5rem;">NEMSU CANTILAN SUPTRACK</h3>
    </a>
    <form class="d-flex">
        <?php
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        ?>
            <div class="dropdown">
                <button class="btn btn-outline-light shadow-none nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?=$_SESSION['Name'];?>
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php
            } 
        ?>
    </form>
  </div>
</nav>

<style>
    .dropdown-menu {
        margin-top: 0; /* Remove extra top margin */
        margin-left: -1rem; /* Adjust the position to the left if needed */
    }

    .dropdown-toggle {
        padding: 0.5rem 1rem; /* Medium padding for button */
        font-size: 1.125rem; /* Medium font size */
        border-radius: 0.375rem; /* Optional: rounded corners */
    }
</style>




<div class="col-lg-2 bg-primary border-top border-3 border-light" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light">ADMIN PANEL</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="filterDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php"><i class="bi bi-menu-button-wide-fill"></i>&nbsp;Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#forms">
                            <span><i class="bi bi-archive"></i>&nbsp;Office File</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="forms">
                            <ul class="nav nav-pills flex-column rounded border border-light">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="ics.php"><i class="bi bi-file-earmark-bar-graph"></i>&nbsp;Inventory | ICS</a> 
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="par.php"><i class="bi bi-file-earmark-post"></i>&nbsp;Property | PAR</a> 
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#qr">
                            <span><i class="bi bi-qr-code-scan"></i>&nbsp;QR Code</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="qr">
                            <ul class="nav nav-pills flex-column rounded border border-light">
                                <?php if (isset($role) && $role == 'Admin') : ?>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="qrcode.php"><i class="bi bi-postage"></i>&nbsp;Generate Stamps</a> 
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="scan.php"><i class="bi bi-upc-scan"></i>&nbsp;Scan Stamps</a> 
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <?php if (isset($role) && $role == 'Admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="log.php"><i class="bi bi-journal"></i>&nbsp;Activity Log</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($role) && $role == 'Admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="user.php"><i class="bi bi-person-add"></i>&nbsp;Manage User</a>
                        </li>
                    <?php endif; ?>
                    
                </ul>
            </div>

        </div>
    </nav>
</div>
