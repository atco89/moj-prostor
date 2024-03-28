<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;


class PasswordRecoveryNotification extends ResetPassword
{

    /**
     * @param $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(subject: trans(key: 'email.Password Recovery', replace: [ 'name' => config(key: 'app.name') ]))
            ->greeting(greeting: trans(key: 'email.Dear Sir/Madam,'))
            ->line(line: trans(key: 'email.By clicking the following button, you can change your password.'))
            ->action(text: trans(key: 'email.Change Password'), url: $this->resetUrl(notifiable: $notifiable))
            ->line(line: trans(key: 'email.If you did not create an account, no further action is required!'))
            ->salutation(salutation: trans(key: 'email.Salutation', replace: [ 'name' => config(key: 'app.name') ]));
    }
}
