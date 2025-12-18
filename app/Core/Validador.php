<?php
declare(strict_types=1);

namespace App\Core;

final class Validador
{
    private array $errores = [];
    
    /**
     * Constructor con dependency injection para mensajes personalizados
     */
    public function __construct(
        private readonly array $mensajesPersonalizados = []
    ) {}

    public function limpiarCadena(string $cadena): string
    {
        $cadena = trim($cadena);
        
        return htmlspecialchars(
            string: $cadena,
            flags: ENT_QUOTES | ENT_HTML5,
            encoding: 'UTF-8'
        );
    }

    /**
     * Limpia y formatea un email
     */
    public function limpiarEmail(string $email): string
    {
        $email = trim($email);
        $email = strtolower($email);
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Limpia un número de teléfono mexicano
     */
    public function limpiarTelefonoMx(string $telefono): string
    {
        // Elimina todo excepto números
        $limpio = preg_replace('/[^0-9]/', '', $telefono);
        
        // Si tiene código +52, lo removemos
        if (strlen($limpio) === 12 && str_starts_with($limpio, '52')) {
            $limpio = substr($limpio, 2);
        }
        
        return $limpio;
    }


    public function validarNoVacio(
        string $campo,
        mixed $valor,
        ?string $mensajePersonalizado = null
    ): self {
        // '0' es válido, pero empty() lo considera vacío
        if (empty($valor) && $valor !== '0' && $valor !== 0) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['no_vacio'] 
                ?? "El campo {$campo} no puede estar vacío";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida longitud mínima de una cadena
     */
    public function validarLongitudMinima(
        string $campo,
        mixed $valor,
        int $longitudMinima,
        ?string $mensajePersonalizado = null
    ): self {
        if (!is_string($valor)) {
            $this->errores[$campo][] = "El campo {$campo} debe ser texto";
            return $this;
        }

        $longitudActual = mb_strlen($valor, 'UTF-8');
        
        if ($longitudActual < $longitudMinima) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['longitud_minima']
                ?? "El campo {$campo} debe tener al menos {$longitudMinima} caracteres (tiene {$longitudActual})";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida longitud máxima de una cadena
     */
    public function validarLongitudMaxima(
        string $campo,
        mixed $valor,
        int $longitudMaxima,
        ?string $mensajePersonalizado = null
    ): self {
        if (!is_string($valor)) {
            $this->errores[$campo][] = "El campo {$campo} debe ser texto";
            return $this;
        }

        $longitudActual = mb_strlen($valor, 'UTF-8');
        
        if ($longitudActual > $longitudMaxima) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['longitud_maxima']
                ?? "El campo {$campo} no debe exceder {$longitudMaxima} caracteres (tiene {$longitudActual})";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida que sea un email válido
     */
    public function validarEmail(
        string $campo,
        string $valor,
        ?string $mensajePersonalizado = null
    ): self {
        $emailLimpio = $this->limpiarEmail($valor);
        
        if (!filter_var($emailLimpio, FILTER_VALIDATE_EMAIL)) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['email']
                ?? "El campo {$campo} debe ser un email válido";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida que sea un número entero
     */
    public function validarEntero(
        string $campo,
        mixed $valor,
        ?string $mensajePersonalizado = null
    ): self {
        if (filter_var($valor, FILTER_VALIDATE_INT) === false) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['entero']
                ?? "El campo {$campo} debe ser un número entero";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida que sea un número decimal
     */
    public function validarFloat(
        string $campo,
        mixed $valor,
        ?string $mensajePersonalizado = null
    ): self {
        if (filter_var($valor, FILTER_VALIDATE_FLOAT) === false) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['float']
                ?? "El campo {$campo} debe ser un número decimal";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida un número de teléfono mexicano (10 dígitos)
     */
    public function validarTelefonoMx(
        string $campo,
        string $valor,
        ?string $mensajePersonalizado = null
    ): self {
        $limpio = $this->limpiarTelefonoMx($valor);
        
        if (strlen($limpio) !== 10) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['telefono_mx']
                ?? "El campo {$campo} debe ser un teléfono válido de 10 dígitos";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida que un valor esté dentro de un rango numérico
     */
    public function validarRango(
        string $campo,
        int|float $valor,
        int|float $minimo,
        int|float $maximo,
        ?string $mensajePersonalizado = null
    ): self {
        if ($valor < $minimo || $valor > $maximo) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['rango']
                ?? "El campo {$campo} debe estar entre {$minimo} y {$maximo}";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida que un valor coincida con otro (útil para confirmación de password)
     */
    public function validarCoincidencia(
        string $campo,
        mixed $valor,
        mixed $valorComparacion,
        string $campoComparacion,
        ?string $mensajePersonalizado = null
    ): self {
        if ($valor !== $valorComparacion) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['coincidencia']
                ?? "El campo {$campo} debe coincidir con {$campoComparacion}";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Valida una fecha en formato específico
     */
    public function validarFecha(
        string $campo,
        string $valor,
        string $formato = 'Y-m-d',
        ?string $mensajePersonalizado = null
    ): self {
        $fecha = \DateTime::createFromFormat($formato, $valor);
        
        if (!$fecha || $fecha->format($formato) !== $valor) {
            $mensaje = $mensajePersonalizado 
                ?? $this->mensajesPersonalizados['fecha']
                ?? "El campo {$campo} debe ser una fecha válida en formato {$formato}";
                
            $this->errores[$campo][] = $mensaje;
        }
        
        return $this;
    }

    /**
     * Verifica si hay errores de validación
     */
    public function tieneErrores(): bool
    {
        return !empty($this->errores);
    }

    /**
     * Obtiene todos los errores
     */
    public function obtenerErrores(): array
    {
        return $this->errores;
    }

    /**
     * Obtiene los errores de un campo específico
     */
    public function obtenerErroresCampo(string $campo): array
    {
        return $this->errores[$campo] ?? [];
    }

    /**
     * Obtiene el primer error general
     */
    public function obtenerPrimerError(): ?string
    {
        if (empty($this->errores)) {
            return null;
        }
        
        $primerCampo = array_key_first($this->errores);
        return $this->errores[$primerCampo][0] ?? null;
    }

    /**
     * Limpia todos los errores (útil para reutilizar el validador)
     */
    public function limpiarErrores(): self
    {
        $this->errores = [];
        return $this;
    }

    /**
     * Obtiene un resumen de errores para mostrar al usuario
     */
    public function obtenerResumenErrores(): string
    {
        if (empty($this->errores)) {
            return '';
        }
        
        $resumen = [];
        foreach ($this->errores as $campo => $erroresCampo) {
            $resumen[] = "• " . implode(', ', $erroresCampo);
        }
        
        return implode("\n", $resumen);
    }

    /**
     * Valida y retorna email limpio o null
     */
    public static function obtenerEmailValido(string $email): ?string
    {
        $email = trim(strtolower($email));
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false 
            ? $email 
            : null;
    }

    /**
     * Valida y retorna entero o null
     */
    public static function obtenerEnteroValido(mixed $valor): ?int
    {
        $resultado = filter_var($valor, FILTER_VALIDATE_INT);
        return $resultado !== false ? $resultado : null;
    }

    /**
     * Valida y retorna float o null
     */
    public static function obtenerFloatValido(mixed $valor): ?float
    {
        $resultado = filter_var($valor, FILTER_VALIDATE_FLOAT);
        return $resultado !== false ? $resultado : null;
    }

    /**
     * Valida y retorna teléfono MX o null
     */
    public static function obtenerTelefonoMxValido(string $telefono): ?string
    {
        $limpio = preg_replace('/[^0-9]/', '', $telefono);
        
        if (strlen($limpio) === 12 && str_starts_with($limpio, '52')) {
            $limpio = substr($limpio, 2);
        }
        
        return strlen($limpio) === 10 ? $limpio : null;
    }
}