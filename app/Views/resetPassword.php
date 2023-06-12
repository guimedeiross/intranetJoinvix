<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>
  <link href="<?php echo base_url(); ?>assets/css/resetPassword.css" rel="stylesheet">
  <main class="form-signin w-100 m-auto">
    <form method="post" action="<?php url_to('resetPassword', $token); ?>">
      <?php echo csrf_field(); ?>
      <h1 class="h3 mb-3 fw-normal">Informe sua nova Senha</h1>

      <span class="text text-danger"><?php echo session()->getFlashdata('errors')['password'] ?? ''; ?></span>

      <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password">
        <label for="password">Nova Senha</label>
      </div>
      <button class="mt-2 btn btn-primary w-100 py-2" type="submit" name="btnReset" id="btnReset">Alterar Senha</button>
    </form>
  </main>

<?php echo $this->endSection(); ?>
