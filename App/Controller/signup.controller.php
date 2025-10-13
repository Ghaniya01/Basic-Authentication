<?php

use App\Model\Register;

$error = null;

    try {


    $reg  = new Register();
    $user = $reg->register(
        $_POST['fullname'] ?? '',
        $_POST['email'] ?? '',
        $_POST['password'] ?? '',
    );

    session_regenerate_id(true);
    $_SESSION['user_id']       = $user->id;
    $_SESSION['role_id']       = $user->role->value;
    $_SESSION['last_activity'] = time();
    $_SESSION['user'] = $user; //find a way to not show password and other sensitive information

    redirect('dashboard');

    } catch (\InvalidArgumentException $e) {
        $error = $e->getMessage();          // validation or domain errors
    } catch (\Throwable $e) {
        dd($e);
    }
