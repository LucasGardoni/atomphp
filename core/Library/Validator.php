<?php

namespace Core\Library;

// É importante adicionar o 'use' para Session e DateTime aqui
use Core\Library\Session;
use DateTime;

class Validator 
{
    public static function make(array $data, array $rules)
    {
        $errors = null;

        foreach ($rules as $ruleKey => $ruleValue) {
            $itensRule = explode("|", $ruleValue['rules']);

            // Lógica de validação para campos obrigatórios
            if (in_array('required', $itensRule) && (!isset($data[$ruleKey]) || $data[$ruleKey] === '')) {
                $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve ser preenchido.";
                continue;
            }
            
            if (!isset($data[$ruleKey])) {
                continue;
            }
            
            if (!in_array('required', $itensRule) && $data[$ruleKey] === '') {
                continue;
            }
            
            foreach ($itensRule as $itemKey) {
                $items = explode(":", $itemKey);
                $ruleName = $items[0];

                if ($ruleName == 'required') {
                    continue;
                }

                switch ($ruleName) {
                    case 'email':
                        if (!filter_var($data[$ruleKey], FILTER_VALIDATE_EMAIL)) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> não é um e-mail válido.";
                        }
                        break;

                    case 'float':
                        if (!filter_var($data[$ruleKey], FILTER_VALIDATE_FLOAT)) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter número decimal.";
                        }
                        break;

                    case 'int':
                        if (filter_var($data[$ruleKey], FILTER_VALIDATE_INT) === false) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter um número inteiro.";
                        }
                        break;

                    case "min":
                        if (isset($items[1]) && strlen(strip_tags($data[$ruleKey])) < $items[1]) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter no mínimo " . $items[1] . " caracteres.";
                        }
                        break;
                    
                    case 'max':
                        if (isset($items[1]) && strlen(strip_tags($data[$ruleKey])) > $items[1]) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> deve conter no máximo " . $items[1] . " caracteres.";
                        }
                        break;
                    
                    case 'date':
                        // Verifica se o campo não está vazio antes de validar a data
                        if (!empty($data[$ruleKey]) && !validateDate($data[$ruleKey], 'Y-m-d')) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> está com o formato incorreto. Formato esperado: AAAA-MM-DD";
                        }
                        break;

                    case 'datetime':
                        if (!empty($data[$ruleKey]) && !validateDate($data[$ruleKey], 'Y-m-d H:i:s')) {
                            $errors[$ruleKey] = "O campo <b>{$ruleValue['label']}</b> está com o formato incorreto. Formato esperado: AAAA-MM-DD HH:MM:SS";
                        }
                        break;
                        
                    default:
                        break;
                }
            }
        }

        if ($errors) {
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

if (!function_exists('validateDate')) {
    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

