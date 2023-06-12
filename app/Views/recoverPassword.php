<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>
  <link href="<?php echo base_url(); ?>assets/css/recoverPassword.css" rel="stylesheet">
  <main class="form-signin w-100 m-auto">
    <form method="post" action="<?php url_to('recoverPassword'); ?>">
      <?php echo csrf_field(); ?>
      <h1 class="h3 mb-3 fw-normal">Recuperar Senha</h1>
      <?php if (session()->has('errors')) { ?>
          <span class="text text-danger"><?php echo session()->get('errors'); ?> </span>
      <?php } ?>
      <?php if (session()->has('forgot_sent')) { ?>
          <span class="text text-success"><?php echo session()->get('forgot_sent'); ?> </span>
      <?php } ?>
        <?php if (session()->has('forgot_not_sent')) { ?>
          <span class="text text-danger"><?php echo session()->get('forgot_not_sent'); ?> </span>
      <?php } ?>
      <?php if (session()->has('token_not_found')) { ?>
          <span class="text text-danger"><?php echo session()->get('token_not_found'); ?> </span>
      <?php } ?>
      <span class="text text-danger"><?php echo session()->getFlashdata('errors')['RecoverEnderecoEmail'] ?? ''; ?></span>
      <span class="text text-danger"><?php echo session()->getFlashdata('errorDuplicateEmailRecover') ?? ''; ?></span>
      
      <div class="form-floating">
        <input type="email" class="form-control" id="RecoverEnderecoEmail" name="RecoverEnderecoEmail">
        <label for="RecoverEnderecoEmail">Informe seu Email</label>
      </div>
      <button class="mt-2 btn btn-primary w-100 py-2" type="submit" name="btnRecover" id="btnRecover">Recuperar Senha</button>
      <button class="mt-2 btn btn-secondary w-100 py-2" name="btnCancel" id="btnCancel">Cancelar</button>
    </form>
  </main>
<script src="<?php echo base_url(); ?>assets/js/recoverPassword.js"></script>

<?php echo $this->endSection(); ?>
