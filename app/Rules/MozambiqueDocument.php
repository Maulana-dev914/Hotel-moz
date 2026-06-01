<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MozambiqueDocument implements Rule
{
    protected $documentType;

    public function __construct($documentType)
    {
        $this->documentType = $documentType;
    }

    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return false;
        }

        // Remove espaços e caracteres especiais
        $document = preg_replace('/[^A-Z0-9]/', '', strtoupper($value));

        switch ($this->documentType) {
            case 'bi':
                // B.I. (Bilhete de Identidade) - formato: letras e números, geralmente 9-13 caracteres
                // Exemplo: 123456789A ou 123456789
                return preg_match('/^[0-9]{7,13}[A-Z]?$/', $document) && strlen($document) >= 7 && strlen($document) <= 13;
            
            case 'passport':
                // Passaporte - formato: letras e números, geralmente 6-9 caracteres
                // Exemplo: A123456 ou AB123456
                return preg_match('/^[A-Z]{1,2}[0-9]{6,8}$/', $document) && strlen($document) >= 7 && strlen($document) <= 10;
            
            case 'driving_license':
                // Carta de Condução - formato: números e letras
                // Exemplo: 123456789 ou CD123456
                return preg_match('/^[A-Z0-9]{6,12}$/', $document) && strlen($document) >= 6 && strlen($document) <= 12;
            
            case 'nuit':
                // NUIT (Número Único de Identificação Tributária) - 9 dígitos
                // Exemplo: 123456789
                return preg_match('/^[0-9]{9}$/', $document);
            
            case 'company_registration':
                // Registo de Empresa - formato variado
                return preg_match('/^[A-Z0-9]{6,15}$/', $document) && strlen($document) >= 6 && strlen($document) <= 15;
            
            default:
                return false;
        }
    }

    public function message()
    {
        $messages = [
            'bi' => 'O B.I. deve ter entre 7 e 13 caracteres (ex: 123456789A).',
            'passport' => 'O Passaporte deve ter entre 7 e 10 caracteres (ex: A123456).',
            'driving_license' => 'A Carta de Condução deve ter entre 6 e 12 caracteres.',
            'nuit' => 'O NUIT deve ter exatamente 9 dígitos.',
            'company_registration' => 'O Registo de Empresa deve ter entre 6 e 15 caracteres.',
        ];

        return $messages[$this->documentType] ?? 'Documento inválido.';
    }
}


