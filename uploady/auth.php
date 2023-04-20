<?php
include_once 'session.php';
include_once  APP_PATH . 'logic/authLogic.php';
?>

<?php include_once 'components/header.php'; ?>
<title>
    <?= $st['website_name'] ?> - <?= $lang['two_factor_title']; ?>
</title>
<?php include_once 'components/css.php'; ?>
</head>

<body class="d-flex flex-column h-100">

    <?php include_once 'components/navbar.php'; ?>

    <div id="wrapper">
        <div id="content-wrapper">
            <div class="container pb-5 pt-5">
                <div class="row justify-content-center text-center">
                    <div class="col-sm-12 col-md-8 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <b><?= $lang['two_factor_title']; ?></b>
                            </div>
                            <div class="card-body container text-left">
                                <?php if (isset($error)) : ?>
                                    <?= $utils->alert($error, 'danger', 'times-circle'); ?>
                                <?php endif; ?>
                                <form method="POST" id="login_form">
                                    <div class="mb-3">
                                        <input type="text" maxlength="6" max="6" class="form-control" name="otp_code" placeholder="<?= $lang['please_enter_your_code']; ?>">
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remberme" name="remberme">
                                        <label class="custom-control-label" for="remberme"><?= $lang['trust_device']; ?></label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <?= $lang['login_button']; ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'components/footer.php'; ?>

    <?php include_once 'components/js.php'; ?>
    <?php if ($settings->getSettingValue('recaptcha_status') == true) : ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $settings->getSettingValue('recaptcha_site_key'); ?>"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo $settings->getSettingValue('recaptcha_site_key'); ?>', {
                    action: 'login_form'
                }).then(function(token) {
                    var recaptchaResponse = document.getElementById('recaptchaResponse');
                    recaptchaResponse.value = token;
                });
            });
        </script>
    <?php endif; ?>
</body>

</html>