<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ContactService;
use App\Services\CsrfService;

/**
 * Handles POST contact form submissions (AJAX JSON).
 */
final class ContactController
{
    public function submit(): array
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!CsrfService::getInstance()->validate($_POST['_csrf'] ?? null)) {
            return [
                'status' => 403,
                'body' => json_encode(['success' => false, 'message' => 'Invalid security token. Please refresh and try again.']),
            ];
        }

        $service = new ContactService();
        $result = $service->validate($_POST);

        if (!$result['ok']) {
            return [
                'status' => 422,
                'body' => json_encode(['success' => false, 'errors' => $result['errors']]),
            ];
        }

        $data = $result['data'] ?? [];
        $sent = $service->submit($data);

        if ($sent) {
            CsrfService::getInstance()->regenerate();
        }

        return [
            'status' => $sent ? 200 : 500,
            'body' => json_encode([
                'success' => $sent,
                'message' => $sent
                    ? 'Thank you! We will get back to you within 24 hours.'
                    : 'Unable to send your message. Please call us directly.',
            ]),
        ];
    }
}
