<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Flash a Nuxt UI toast for the next Inertia response.
     *
     * @param  array<string, mixed>  $props
     */
    protected function withToast(string $message, array $props = []): void
    {
        $timeout = $props['timeout'] ?? $props['duration'] ?? 5000;
        unset($props['timeout']);

        session()->flash('toast', [
            'color' => 'success',
            'duration' => $timeout,
            ...$props,
            'title' => $message,
        ]);
    }

    protected function successToast(string $message, array $props = []): void
    {
        $this->colorToast('success', $message, $props);
    }

    protected function infoToast(string $message, array $props = []): void
    {
        $this->colorToast('info', $message, $props);
    }

    protected function warningToast(string $message, array $props = []): void
    {
        $this->colorToast('warning', $message, $props);
    }

    protected function errorToast(string $message, array $props = []): void
    {
        $this->colorToast('error', $message, $props);
    }

    /**
     * @param  array<string, mixed>  $props
     */
    private function colorToast(string $color, string $message, array $props): void
    {
        $this->withToast($message, [
            ...$props,
            'color' => $color,
        ]);
    }
}
