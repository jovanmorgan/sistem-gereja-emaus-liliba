  <section class="section">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body text-center">
                      <div class="card-header pb-0">
                          <h3 class="text-center">Table <?php echo $page_title ?></h3>
                      </div>
                      <div class="garis"></div>
                      <style>
                      .garis {
                          width: 50%;
                          height: 1.5px;
                          background-color: grey;
                          margin: 0 auto;
                          margin-bottom: 30px;
                      }
                      </style>
                      <!-- Search Form -->
                      <form method="GET" action="">
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="Cari rayon..."
                                  name="search" style="height: 45px;"
                                  value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                              <button class="btn btn-outline-secondary" type="submit">Cari</button>
                          </div>
                      </form>

                      <?php if ($page_title !== 'Permintaan Update') { ?>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary text-white mt-4" data-bs-toggle="modal"
                          data-bs-target="#tambahDataModal">
                          Tambah Data
                      </button>
                      <?php } ?>
                  </div>
              </div>
          </div>
      </div>
  </section>