<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>
  <link href="<?php echo base_url(); ?>assets/css/recoverPassword.css" rel="stylesheet">
  <main class="form-signin w-100 m-auto">
    <form method="post" action="<?php url_to('recoverPassword'); ?>">
      <?php echo csrf_field(); ?>
      <h1 class="h3 mb-3 fw-normal">Recuperar Senha</h1>
      <div class="form-floating">
        <input type="email" class="form-control" id="RecoverEnderecoEmail" name="RecoverEnderecoEmail">
        <label for="RecoverEnderecoEmail">Informe seu Email</label>
        <span class="text text-danger"><?php echo session()->getFlashdata('errors')['RecoverEnderecoEmail'] ?? '' ?></span>
        <span class="text text-danger"><?php echo session()->getFlashdata('errorDuplicateEmailRecover') ?? '' ?></span>
      </div>
      <button class="mt-2 btn btn-primary w-100 py-2" type="submit" name="btnRecover" id="btnRecover">Recuperar Senha</button>
      <button class="mt-2 btn btn-secondary w-100 py-2" name="btnCancel" id="btnCancel">Cancelar</button>
    </form>
  </main>
<script src="<?php echo base_url(); ?>assets/js/recoverPassword.js"></script>

<?php echo $this->endSection(); ?>
