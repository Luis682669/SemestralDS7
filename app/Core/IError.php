<?php
/**
 * Sistema de Gestión de Capital Humano
 * @author Luis Alberto De Los Rios
 * @colaboradores Jeremías Donoso, Juan Segundo
 * Institución: Universidad Tecnológica de Panamá
 */

namespace App\Core;

interface IError {
    public function logError(string $message, string $file, int $line): void;
    public function displayError(): string;
}