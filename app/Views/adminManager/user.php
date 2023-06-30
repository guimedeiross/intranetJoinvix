<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>

<?php echo $this->include('partials/nav'); ?>

<section class="container">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Nome Cliente</th>
          <th scope="col">Link</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (["ola", "gui", "testando", "array", "banana"] as $invoice) { ?>
          <tr>
            <td><?php echo $invoice ?></td>
            <td><?php echo "<a
                                  class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' 
                                  target=_blank href=#>Link {$invoice}
                                </a>" ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</section>
</main>
<?php echo $this->endSection(); ?>