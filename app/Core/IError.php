<?php
/**
 * Sistema de Gestión de Capital Humano
 * @author Luis Alberto De Los Rios
 * @colaboradores Jeremías Donoso, Juan Segundo
 * Institución: Universidad Tecnológica de Panamá
 */

namespace App\Core;
// Implementamos una interfaz para cumplir con el Criterio 20 que sirve para manejar 
// errores de manera uniforme en toda la aplicación
interface IError {
    public function logError(string $message, string $file, int $line): void;
    public function displayError(): string;
}