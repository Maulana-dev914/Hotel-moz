<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MozambiquePhone implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove espaços e caracteres especiais
        $phone = preg_replace('/[^0-9]/', '', $value);
        
        // Números de Moçambique podem começar com:
        // 82, 83, 84, 85, 86, 87 (celular)
        // 21, 23, 24, 26, 27, 28, 29, 41, 42, 43, 44, 46, 47, 48, 49, 251, 252, 253, 254, 255, 256, 257, 258, 259, 271, 272, 273, 274, 275, 276, 277, 278, 279, 281, 282, 293, 294, 295, 296, 297, 298, 299 (fixo)
        // Formato: +258 ou 00258 seguido de 9 dígitos, ou apenas 9 dígitos começando com 8
        
        // Verifica se tem 9 dígitos e começa com 8 (celular)
        if (preg_match('/^8[2-7]\d{7}$/', $phone)) {
            return true;
        }
        
        // Verifica formato internacional +258 ou 00258
        if (preg_match('/^(\+258|00258)?8[2-7]\d{7}$/', $phone)) {
            return true;
        }
        
        // Verifica números fixos (mais complexo, mas aceita os principais)
        if (preg_match('/^(\+258|00258)?(21|23|24|26|27|28|29|41|42|43|44|46|47|48|49)\d{7}$/', $phone)) {
            return true;
        }
        
        return false;
    }

    public function message()
    {
        return 'O número de telefone deve ser válido para Moçambique (ex: 82 123 4567 ou +258 82 123 4567).';
    }
}


