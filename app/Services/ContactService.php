<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Validates and submits contact form enquiries.
 */
final class ContactService
{
    /**
     * @param array<string, string> $input
     * @return array{ok: bool, errors: array<string, string>, message?: string}
     */
    public function validate(array $input): array
    {
        $errors = [];

        $name = trim($input['name'] ?? '');
        $email = trim($input['email'] ?? '');
        $message = trim($input['message'] ?? '');
        $phone = trim($input['phone'] ?? '');
        $service = trim($input['service'] ?? '');
        $honeypot = trim($input['_honey'] ?? '');

        if ($honeypot !== '') {
            return ['ok' => false, 'errors' => ['form' => 'Invalid submission.']];
        }

        if ($name === '' || mb_strlen($name) < 2) {
            $errors['name'] = 'Please enter your full name.';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if ($message === '' || mb_strlen($message) < 10) {
            $errors['message'] = 'Please enter a message (at least 10 characters).';
        }

        if ($phone !== '' && !preg_match('/^[\d\s+\-()]{7,20}$/', $phone)) {
            $errors['phone'] = 'Please enter a valid phone number.';
        }

        $allowedServices = config('content.service_options', []) ?? [];
        if ($service !== '' && is_array($allowedServices) && !in_array($service, $allowedServices, true)) {
            $errors['service'] = 'Please select a valid service.';
        }

        if ($errors !== []) {
            return ['ok' => false, 'errors' => $errors];
        }

        return [
            'ok' => true,
            'errors' => [],
            'data' => [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'service' => $service,
                'message' => $message,
            ],
        ];
    }

    /**
     * @param array<string, string> $data
     */
    public function submit(array $data): bool
    {
        if (!config('forms.contact_enabled', true)) {
            return false;
        }

        $endpoint = (string) config('forms.formsubmit_endpoint');
        if ($endpoint === '') {
            return $this->logSubmission($data);
        }

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? '',
            'service' => $data['service'] ?? '',
            'message' => $data['message'],
            '_subject' => 'New Enquiry — ' . config('name'),
            '_captcha' => 'false',
            '_template' => 'table',
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
                'content' => http_build_query($payload),
                'timeout' => 15,
            ],
        ]);

        $response = @file_get_contents($endpoint, false, $context);
        if ($response === false) {
            return $this->logSubmission($data);
        }

        $decoded = json_decode($response, true);

        return is_array($decoded) && ($decoded['success'] ?? true);
    }

    /**
     * @param array<string, string> $data
     */
    private function logSubmission(array $data): bool
    {
        $logDir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $line = sprintf(
            "[%s] Contact: %s <%s> — %s\n",
            date('Y-m-d H:i:s'),
            $data['name'],
            $data['email'],
            substr($data['message'], 0, 80)
        );

        return (bool) file_put_contents($logDir . '/contact.log', $line, FILE_APPEND | LOCK_EX);
    }
}
