<?php

class MailConfig
{
    public static function smtp(): array
    {
        $config = [
            'host' => getenv('MAIL_HOST') ?: '',
            'port' => (int) (getenv('MAIL_PORT') ?: 0),
            'username' => getenv('MAIL_USERNAME') ?: '',
            'password' => getenv('MAIL_PASSWORD') ?: '',
            'from_email' => getenv('MAIL_FROM_EMAIL') ?: '',
            'from_name' => getenv('MAIL_FROM_NAME') ?: 'HireFlow',
            'encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls',
        ];

        foreach (['host', 'port', 'username', 'password', 'from_email'] as $key) {
            if (empty($config[$key])) {
                throw new RuntimeException('Missing mail config: ' . $key);
            }
        }

        return $config;
    }
}
