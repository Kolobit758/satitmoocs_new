<nav class="navbar navbar-expand-lg navbar-light fixed-top rounded-5 rounded-top-0" 
     style="height: 100px; border:4px solid #d1d1d1ff ; background-color: #e6e6e6ff; z-index: 1030; box-shadow: 5px 5px 50px rgba(86, 88, 216, 0.88);">
    <div class="container-fluid">
        <img class="navbar-brand" src="../Uploads/profile_img/<?= $user_data['user_img'] ?>" id="user_img">
        
        <!-- burger button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- menu -->
        <div class="collapse navbar-collapse bg-light p-3 rounded-5" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                <li class="nav-item">
                    <a class="nav-link active " aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn btn-secondary" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<!-- logo section -->
<div id="top-nav" class="my-top-nav align-items-center pt-8" style=" z-index: 1; position: relative;">
    <div class="d-flex justify-content-center">
        <div class="logo-glass ms-sm-1  w-75">
            <img src="../assets/TSU_logo.png" alt="Logo" class="img-fluid logo">
        </div>
    </div>
</div>
