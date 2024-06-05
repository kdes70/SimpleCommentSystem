<?php

namespace App\Exceptions;

use Exception;
use Psr\Log\LoggerInterface;
use Twig\Environment;

class Handler
{
    public function __construct(private LoggerInterface $logger, private Environment $twig)
    {
    }

    public function report(Exception $exception): void
    {
        $this->logger->error($exception->getMessage(), [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    public function render(Exception $exception): string
    {
        if (getenv('APP_ENV') === 'local') {
            return $this->renderDebug($exception);
        }

        return $this->twig->render('errors/500.html.twig', [
            'message' => 'Что-то пошло не так.'
        ]);
    }

    private function renderDebug(Exception $exception): string
    {
        $html = "<h1>Exception</h1>";
        $html .= "<p><strong>Message:</strong> {$exception->getMessage()}</p>";
        $html .= "<p><strong>File:</strong> {$exception->getFile()}</p>";
        $html .= "<p><strong>Line:</strong> {$exception->getLine()}</p>";
        $html .= "<h2>Trace</h2>";
        $html .= "<pre>{$exception->getTraceAsString()}</pre>";

        return $html;
    }
}
