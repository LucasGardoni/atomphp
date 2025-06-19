<?php

namespace Core\Library;

class Validator 
{
    public static function make(array $data, array $rules)
    {
        $errors = null;

        foreach ($rules as $ruleKey => $ruleValue) {
            $itensRule = explode("|", $ruleValue['rules']);

            // --- LÓGICA DE VALIDAÇÃO REVISADA ---

            // 1. Verifica se um campo obrigatório está ausente ou é uma string vazia
            if (in_array('required', $itensRule) && (!isset($data[$ruleKey]) || $data[$ruleKey] === '')) {
                $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve ser preenchido.";
                continue; // Pula para a próxima regra de campo, já que esta falhou.
            }
            
            // Se o campo não foi enviado (e não é obrigatório), não precisa validar mais nada para ele.
            if (!isset($data[$ruleKey])) {
                continue;
            }
            
            // Se o campo foi enviado vazio mas não é obrigatório, está OK. Não valida outras regras.
            if (!in_array('required', $itensRule) && $data[$ruleKey] === '') {
                continue;
            }
            
            // 2. Itera sobre as regras (email, int, min, max, etc.)
            foreach ($itensRule as $itemKey) {
                $items = explode(":", $itemKey);

                switch ($items[0]) {
                    case 'required':
                        // Já foi tratado acima, então pulamos.
                        break;

                    case 'email':
                        if (!filter_var($data[$ruleKey], FILTER_VALIDATE_EMAIL)) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> não é válido.";
                        }
                        break;

                    case 'float':
                        if (!filter_var($data[$ruleKey], FILTER_VALIDATE_FLOAT)) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter número decimal.";
                        }
                        break;

                    case 'int':
                        // CORREÇÃO: A verificação agora é estrita contra 'false', aceitando o inteiro 0.
                        if (filter_var($data[$ruleKey], FILTER_VALIDATE_INT) === false) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter número inteiro.";
                        }
                        break;

                    case "min":
                        if (strlen(strip_tags($data[$ruleKey])) < $items[1]) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter no mínimo " . $items[1] . " caracteres.";
                        }
                        break;
                    
                    case 'max':
                        if (strlen(strip_tags($data[$ruleKey])) > $items[1]) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter no máximo " . $items[1] . " caracteres.";
                        }
                        break;
                    
                    case 'date':
                        if (!validateDate($data[$ruleKey], 'Y-m-d')) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> está com o formato incorreto, formato esperado é Y-m-d";
                        }
                        break;

                    case 'datetime':
                        if (!validateDate($data[$ruleKey], 'Y-m-d H:i:s')) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> está com o formato incorreto, formato esperado é Y-m-d H:i:s";
                        }
                        break;
                        
                    default:
                        break;
                }
            }
        }

        if ($errors) { // Se encontrar erros na validação
            Session::set('errors', $errors);
            Session::set('inputs', $data);
            return true;
        } else {
            Session::destroy('errors');
            Session::destroy('inputs');
            return false;
        }
    }
}

// A função validateDate não é padrão do PHP, ela deve estar em outro helper (ex: utilits.php)
// Se ela não existir, você pode adicioná-la aqui ou no seu helper de utilidades.
if (!function_exists('validateDate')) {
    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}