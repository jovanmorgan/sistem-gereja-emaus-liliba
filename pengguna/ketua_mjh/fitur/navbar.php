   <?php include 'nama_halaman.php'; ?>
   <!-- Navbar -->
   <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
       id="navbarBlur" navbar-scroll="true">
       <div class="container-fluid py-1 px-3">
           <nav aria-label="breadcrumb">
               <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                   <li class="breadcrumb-item text-sm">
                       <a class="opacity-5 text-dark" href="javascript:;">Ketua mjh</a>
                   </li>
                   <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                       <?= $page_title ?>
                   </li>
               </ol>
               <h6 class="font-weight-bolder mb-0"><?= $page_title ?></h6>
           </nav>
           <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
               <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                   <form class="search-form d-flex align-items-center" method="POST" action="fitur/search.php">
                       <div class="input-group">
                           <span class="input-group-text text-body"><i class="fas fa-search"
                                   aria-hidden="true"></i></span>
                           <input type="text" class="form-control" placeholder="Cari Halaman!..." name="query" />
                       </div>
                   </form>
               </div>
               <ul class=" navbar-nav justify-content-end">
                   <li class="nav-item d-flex align-items-center">
                       <a href="profile" class="nav-link text-body font-weight-bold px-0">
                           <i class="fa fa-user me-sm-1"></i>
                       </a>
                   </li>
                   <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                       <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                           <div class="sidenav-toggler-inner">
                               <i class="sidenav-toggler-line"></i>
                               <i class="sidenav-toggler-line"></i>
                               <i class="sidenav-toggler-line"></i>
                           </div>
                       </a>
                   </li>

               </ul>
           </div>
       </div>
   </nav>
   <!-- End Navbar -->