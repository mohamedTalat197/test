<?php


use Illuminate\Support\Facades\App;

/**
 * @param $user
 * @param $transKey
 * @return int
 */
function forgetPasswordEmail($user)
{
    $lang=$user->lang;
    App::setLocale($lang);
    $subject=__('forget password');
    $email=$user->email;
    $data=[];
    $data['code']=$user->password_code;
    $data['language']=$lang;
    $name=$user->name;

    Mail::send('emails.forget_password_email', $data, function ($mail) use ($email,$name, $subject) {
        $mail->to($email, $name);
        $mail->subject($subject);
    });

    return 1;
}

/**
 * @param $user
 * @return int
 */
function verifyEmail($user)
{
    $lang=$user->lang;
    App::setLocale($lang);
    $subject=__('Verify Email');
    $email=$user->email;
    $data=[];
    $data['code']=$user->active_code;
    $data['language']=$lang;
    $name=$user->name;

    Mail::send('emails.verify_email', $data, function ($mail) use ($email,$name, $subject) {
        $mail->to($email, $name);
        $mail->subject($subject);
    });

    return 1;
}


