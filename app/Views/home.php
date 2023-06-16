<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>

<main>
  <nav class="navbar navbar-dark bg-dark" aria-label="Dark offcanvas navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?php echo url_to('home'); ?>"><?php echo $moduleName; ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">Menu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="<?php echo url_to('home')?>">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo url_to('loginDestroy'); ?>">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <section class="container">
    <?php if (!$invoices) : ?>
      <div class="text-center">
        <h1>Sem Faturas duplicadas para este mês</h1>
      </div>
    <?php else : ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Nome Cliente</th>
              <th scope="col">Link</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($invoices as $invoice) { ?>
              <tr>
                <td><?php echo $invoice['firstname'] ? "{$invoice['firstname']} {$invoice['lastname']}" : $invoice['companyname']; ?></td>
                <td><?php echo "<a
                                  class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' 
                                  target=_blank href=https://central.joinvix.com.br/jvxmanager/clientsinvoices.php?userid={$invoice['cli_id']}&orderby=date>Link Acesso
                                </a>" ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php echo $this->include('Pagers/pagination'); ?>
    <?php endif; ?>
  </section>
</main>
<?php echo $this->endSection(); ?>