<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>

<link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet">
    
<main class="form-signin w-100 m-auto">
  <form>
    <?php echo csrf_field(); ?>
    <h1 class="h3 mb-3 fw-normal">Faça Login</h1>
    <span class="text text-success"><?php echo session()->getFlashdata('insertSuccess') ?? ''; ?></span>
    <div class="form-floating">
      <input type="email" class="form-control" id="EnderecoEmail" name="EnderecoEmail">
      <label for="EnderecoEmail">Endereço de Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="password" name="password">
      <label for="password">Senha</label>
    </div>
    <button class="mt-2 btn btn-primary w-100 py-2" type="submit" name="btnLogin" id="btnLogin">Login</button>
    <button class="mt-2 btn btn-success w-100 py-2" name="btnSignUp" id="btnSignUp">Cadastre-se</button>
    <a href="<?php echo url_to('viewRecoverPassword') ?>" class="text-start my-3" id="recoverPassword">Esqueceu a senha?</a>
  </form>
</main>
<script src="<?php echo base_url(); ?>assets/js/login.js"></script>
<?php echo $this->endSection(); ?>
