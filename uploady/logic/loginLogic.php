<?php

$auth = new Uploady\Auth($db, $utils);
$user = new Uploady\User($db, $utils);

/** Check if user is already log in */

if (isset($_SESSION['loggedin'])) {
    $utils->redirect($utils->siteUrl("/index.php"));
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $utils->sanitize($_POST['username']);
    $password = $utils->sanitize($_POST['password']);

    $loginstatus = $auth->newLogin($username, $password);

    if ($loginstatus == 200) {
        if (isset($_POST['recaptcha_response'])) {
            $recaptcha = new \ReCaptcha\ReCaptcha($settings->getSettingValue('recaptcha_secret_key'));

            $resp = $recaptcha->setChallengeTimeout(60)
                ->setExpectedAction("login_form")
                ->setScoreThreshold(0.5)
                ->verify($_POST['recaptcha_response'], $_SERVER['REMOTE_ADDR']);

            if ($resp->isSuccess()) {
                $_SESSION['isHuman'] = true;
            } else {
                $_SESSION['isHuman'] = false;
                $error = $lang["recaptcha_failed"];
            }
        }

        if (!isset($error)) {
            session_regenerate_id();

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_role'] = $role->getUserRole($username);

            if ($user->isTwoFAEnabled($username) == true) {
                $utils->redirect($utils->siteUrl("/auth.php"));
            } else {
                $_SESSION['OTP'] = true;
                $utils->redirect($utils->siteUrl("/index.php"));
            }
        }
    } elseif ($loginstatus == 401) {
        $error = $lang["incorrect_creds"];
    } elseif ($loginstatus == 403) {
        $error = $lang['account_locked'];
    } else {
        $error = $lang['unxpected_error'];
    }
}

$page = "loginPage";
