<?php 
// Check if the user is logged in and has a role
if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $role = $_SESSION['Role']; 
}
?>


<nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
  <div class="container-fluid text-dark p-2 d-flex align-items-center justify-content-between">
    <a class="navbar-brand text-dark d-flex align-items-center" href="#">
      <img src="image/2.png" class="img-fluid shadow-1" style="max-height: 50px;" alt="Logo">
      <h3 class="ms-2 mb-0 text-white" style="font-size: 1.5rem;">NEMSU CANTILAN SUPTRACK</h3>
    </a>
    <form class="d-flex">
        <?php
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $name = htmlspecialchars($_SESSION['Name'], ENT_QUOTES, 'UTF-8'); // Prevent XSS
                echo <<<HTML
                <button type="button" class="btn btn-outline-light shadow-none dropdown-toggle" 
                        id="navbarDropdownMenuLink" data-bs-toggle="dropdown" data-bs-display="static" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    $name
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
    HTML;
            } else {
                echo '<a href="login.php" class="btn btn-outline-light">Login</a>';
            }
        ?>
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
                                    <a class="nav-link text-white" href="ics.php"><i class="bi bi-file-earmark-bar-graph"></i>&nbsp;Inventory | ICS</a> 
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="par.php"><i class="bi bi-file-earmark-post"></i>&nbsp;Property | PAR</a> 
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#transactionLinks">
                            <span><i class="bi bi-qr-code-scan"></i>&nbsp;QR Code</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="transactionLinks">
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
