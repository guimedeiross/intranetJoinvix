<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>

<link href="<?php echo base_url(); ?>assets/css/signup.css" rel="stylesheet">

<main class="form-signin w-100 m-auto">
  <form method="post" action="<?php url_to('signUp') ?>">
    <h1 class="h3 mb-3 fw-normal">Cadastre-se</h1>
    <?php echo csrf_field() ?>
    <span class="text text-danger"><?php echo session()->getFlashdata('errorInsertEmail') ?? '' ?></span>
    <div class="form-floating">
      <input type="email" class="form-control" id="EnderecoEmail" name="EnderecoEmail">
      <label for="EnderecoEmail">Endereço de email</label>
      <span class="text text-danger"><?php echo session()->getFlashdata('errors')['EnderecoEmail'] ?? '' ?></span>
      <span class="text text-danger"><?php echo session()->getFlashdata('errorDuplicateEmail') ?? '' ?></span>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="password" name="password">
      <label for="password">Senha</label>
      <span class="text text-danger"><?php echo session()->getFlashdata('errors')['password'] ?? '' ?></span>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
      <label for="confirmPassword">Confirme a senha</label>
      <span class="text text-danger"><?php echo session()->getFlashdata('errors')['confirmPassword'] ?? '' ?></span>
    </div>
    <button class="mt-2 btn btn-primary w-100 py-2" type="submit" name="btnSignUp" id="btnSignUp">Cadastrar</button>
    <button class="mt-2 btn btn-secondary w-100 py-2" name="btnCancel" id="btnCancel">Cancelar</button>
  </form>
</main>
<script src="<?php echo base_url(); ?>assets/js/signup.js"></script>
<?php echo $this->endSection(); ?>
