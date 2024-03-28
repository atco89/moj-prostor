<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;


class AccountVerificationNotification extends VerifyEmail
{

    /**
     * @param $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(subject: trans(key: 'email.Account Activation', replace: [ 'name' => config(key: 'app.name') ]))
            ->greeting(greeting: trans(key: 'email.Dear Sir/Madam,'))
            ->line(line: trans(key: 'email.You have successfully created an account. Please click the button below to activate your account.'))
            ->action(text: trans(key: 'email.Activate Account'), url: $this->verificationUrl(notifiable: $notifiable))
            ->line(line: trans(key: 'email.If you did not create an account, no further action is required!'))
            ->salutation(salutation: trans(key: 'email.Salutation', replace: [ 'name' => config(key: 'app.name') ]));
    }
}
