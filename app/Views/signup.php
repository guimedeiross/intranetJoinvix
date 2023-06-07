<?php echo $this->extend('master'); ?>

<?php echo $this->section('content'); ?>
<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/signup.css" rel="stylesheet">
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary">

<main class="form-signin w-100 m-auto">
  <form method="post" action="<?php url_to('signUp') ?>">
    <h1 class="h3 mb-3 fw-normal">Cadastre-se</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="EnderecoEmail" name="EnderecoEmail">
      <label for="EnderecoEmail">Endereço de email</label>
      <span class="text text-danger"><?php echo session()->getFlashdata('errors')['EnderecoEmail'] ?? '' ?></span>
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
    <button class="mt-2 btn btn-primary w-100 py-2" type="submit" name="btnSignUp" id="btnSignUp">Sign up</button>
  </form>
</main>
<?php echo $this->endSection(); ?>
