<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>

<?php echo $this->include('partials/nav'); ?>

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