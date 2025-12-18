<?php
declare(strict_types=1);

namespace App\Core;

final class AlertaFlash
{
    private const CLAVE = '__alertas_flash';

    private static function asegurarSesion(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * $opciones ejemplo:
     * [
     *   'timer' => 2000,
     *   'toast' => true,
     *   'position' => 'top-end',
     *   'showConfirmButton' => false
     * ]
     */
    public static function agregar(string $icono, string $titulo, string $texto = '', array $opciones = []): void
    {
        self::asegurarSesion();

        $_SESSION[self::CLAVE] ??= [];

        $_SESSION[self::CLAVE][] = [
            'icon'  => $icono,     // success|error|warning|info|question (SweetAlert)
            'title' => $titulo,
            'text'  => $texto,
            'opts'  => $opciones,
        ];
    }

    public static function exito(string $titulo, string $texto = '', array $opciones = []): void
    {
        self::agregar('success', $titulo, $texto, $opciones);
    }

    public static function error(string $titulo, string $texto = '', array $opciones = []): void
    {
        self::agregar('error', $titulo, $texto, $opciones);
    }

    public static function advertencia(string $titulo, string $texto = '', array $opciones = []): void
    {
        self::agregar('warning', $titulo, $texto, $opciones);
    }

    public static function info(string $titulo, string $texto = '', array $opciones = []): void
    {
        self::agregar('info', $titulo, $texto, $opciones);
    }

    /** Consume TODAS las alertas: las lee y las borra (solo aparecen una vez) */
    public static function consumirTodas(): array
    {
        self::asegurarSesion();

        $alertas = $_SESSION[self::CLAVE] ?? [];
        unset($_SESSION[self::CLAVE]);

        return is_array($alertas) ? $alertas : [];
    }
}
