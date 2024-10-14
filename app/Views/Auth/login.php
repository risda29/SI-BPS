<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <!-- Tampilkan error umum -->
                                <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger"><?= session('error') ?></div>
                                <?php endif; ?>

                                <form action="/auth/login" method="post" class="user">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control form-control-user <?= session('errors.username') ? 'is-invalid' : '' ?>"
                                            id="exampleInputUsername" aria-describedby="usernameHelp"
                                            placeholder="Masukkan Username..." name="username"
                                            value="<?= old('username') ?>">
                                        <?php if (session('errors.username')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.username') ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control form-control-user <?= session('errors.password') ? 'is-invalid' : '' ?>"
                                            id="exampleInputPassword" placeholder="Password" name="password">
                                        <?php if (session('errors.password')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>