<?php

namespace Duro85\AjaxAuth;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AjaxAuthNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $guard;
    public $mail_params;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @param  string  $guard
     * @param  array  $mail_params
     * @return void
     */
    public function __construct($token, $guard, Array $mail_params = [])
    {
        $this->token = $token;
        $this->guard = $guard;
        $this->mail_params = $mail_params;
        $this->mail_params['token'] = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // get password config 
        $config = config("auth.passwords.{$this->guard}");
        if (isset($config['view'])) {
            /*
             * custom view message
             */
            return (new MailMessage)->view($config['view'], $this->mail_params);
        } else {
            /**
             * standard laravel notification email with localizable test            
             */
            //you can specify a different route for each guard
            $link = isset($config['route']) ? route($config['route'], $this->token) : route('password.reset', $this->token);            
            return (new MailMessage)->view()
                            ->line('You are receiving this email because we received a password reset request for your account.')
                            ->action('Reset Password', $link)
                            ->line('If you did not request a password reset, no further action is required.');
        }
    }

}