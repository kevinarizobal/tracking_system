<?php //require("inc/connect.php");?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
  <div class="container-fluid text-dark p-2 d-flex align-items-center justify-content-between">
    <a class="navbar-brand text-dark d-flex align-items-center" href="#">
      <img src="image/2.png" class="img-fluid shadow-1" style="max-height: 50px;" alt="Logo">
      <h3 class="ms-2 mb-0 text-white" style="font-size: 1.5rem;">NEMSU CANTILAN SUPTRACK</h3>
    </a>
    <form class="d-flex">
       <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </form>
  </div>
</nav>

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
                        <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#transactionLinks">
                            <span><i class="bi bi-archive"></i>&nbsp;Office File</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="transactionLinks">
                            <ul class="nav nav-pills flex-column rounded border border-light">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="#"><i class="bi bi-file-earmark-bar-graph"></i>&nbsp;Inventory | ICS</a> 
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="#"><i class="bi bi-file-earmark-post"></i>&nbsp;Property | PAR</a> 
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#"><i class="bi bi-qr-code-scan"></i>&nbsp;QR Code Stamp</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#"><i class="bi bi-journal"></i>&nbsp;Activity Log</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#"><i class="bi bi-person-add"></i>&nbsp;Manage User</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</div>