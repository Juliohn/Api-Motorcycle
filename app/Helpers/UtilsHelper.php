<?php

if (!function_exists('currency_format')) {
    function currency_format(?float $value)
    {
        if ($value === null || empty($value)) {
            //return  'R$ 0,00';
            return  '$ 0.00';
        }
        //return 'R$ '.number_format($value,2,',','.');
        return '$ '. number_format($value, 2, '.', ',');
    }
}

if (!function_exists('kg_format')) {
    function kg_format(?float $value)
    {
        if ($value === null || empty($value)) {
            return '0,00';
        }
        return number_format($value, 3, ',', '.');
    }
}


if (!function_exists('dateFormat')) {
    function dateFormat(?DateTimeInterface $value, $format = "d/m/Y H:i:s"):string
    {
        if ($value === null) {
            return '';
        }
        return  $value->format($format);
    }
}

if (!function_exists('money_format_bd')) {
    function money_format_bd($valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $valor);
        return $valor;
    }
}

if (!function_exists('phone_format')) {
    /**
     * @param $phone
     *
     * @return string
     */
    function phone_format($phone)
    {
        $formatedPhone = preg_replace('/[^0-9]/', '', $phone);
        $matches = [];
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formatedPhone, $matches);

        return $matches ? '('.$matches[1].') '.$matches[2].'-'.$matches[3] : $phone;
    }
}

if (!function_exists('just_number')) {
    function just_number($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }
}


if (!function_exists('status_format')) {
    function status_format($str)
    {
        switch ($str) {
            case 'A':
                return 'Ativo';
                break;

            case 'I':
                    return 'Inativo';
                break;
            case 'B':
                    return 'Bloqueado';
                break;
            case 'P':
                return 'Pago';
                break;

            case 'E':
                    return 'Em Analise';
                break;
            case 'C':
                    return 'Cancelada';
                break;
            default:
                # code...
                break;
        }
    }
}


if (!function_exists('validateCpf')) {
    function validateCpf($value)
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('defaultImage')) {
    function defaultImage($path, $value)
    {
        if (empty($value)) {
            return asset("images/default.png");
        }


        if (file_exists(public_path($path.$value))) {
            return asset($path.$value);
        } else {
            return asset("images/default.png");
        }
    }
}

if (!function_exists('getDatesFromRange')) {
    function getDatesFromRange($start, $end, $format = 'd/m/Y')
    {

    // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        // Return the array elements
        return $array;
    }
}
