<?php
include_once 'session.php';
include_once  APP_PATH . 'logic/loginLogic.php';
?>
<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="UTF-8" />
    <?php include_once 'components/header.php'; ?>
    <title>
        <?= $st['website_name'] ?> - <?= $lang['login_title']; ?>
    </title>
    <?php include_once 'components/css.php'; ?>
</head>

<body>

    <?php include_once 'components/navbar.php'; ?>

    <div id="wrapper">
        <div id="content-wrapper">
            <div class="container pb-5 pt-5">
                <div class="row justify-content-center text-center">
                    <div class="col-sm-12 col-md-8 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <b><?= $lang['login_title'] ?></b>
                            </div>
                            <div class="card-body container text-left">
                                <?php if (isset($error)) : ?>
                                    <?= $utils->alert($error, 'danger', 'times-circle'); ?>
                                <?php endif; ?>
                                <form method="POST" id="login_form">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="username" placeholder="<?= $lang['enter_username']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="<?= $lang['enter_password']; ?>">
                                    </div>
                                    <?php if ($settings->getSettingValue('recaptcha_status') == true) : ?>
                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                                    <?php endif; ?>
                                    <a class="d-block small m-3" href="forgot-password.php"><?= $lang['forget_password']; ?></a>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <?= $lang['login_button']; ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer mb-0">
                                <a href="<?= $utils->siteUrl('/signup.php'); ?>">
                                    <?= $lang['signup_cta_msg']; ?>
                                </a>
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

</html>