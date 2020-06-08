<?php

namespace Valii\Validators;

use Illuminate\Validation\Validator;

class ValiiValidator extends Validator
{

    /**
     * over load replace before
     * replace :date place holder
     *
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    public function replaceBefore($message, $attribute, $rule, $parameters)
    {
        $valiiDate = trans('valii::validation.date');
        if (is_array($valiiDate)) {
            $parameter_translated = str_replace(
                array_keys($valiiDate),
                array_values($valiiDate),
                $parameters[0]
            );
            $message = str_replace(':date', $parameter_translated, $message);
        }

        return parent::replaceBefore($message, $attribute, $rule, $parameters);
    }

    /**
     * validation tel number
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateTel(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^[0-9]{2,5}-?[0-9]{1,4}-?[0-9]{1,4}$/';
        return preg_match($regex, $value);
    }

    /**
     * validation hankaku katakana
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateHankakuKatakana(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^(?:\xEF\xBD[\xA6-\xBF]|\xEF\xBE[\x80-\x9F])*$/';

        // in allow_spaces mode
        if (isset($parameters[0]) && $parameters[0] == 'allow_spaces') {
            $regex = '/^(?:\xEF\xBD[\xA6-\xBF]|\xEF\xBE[\x80-\x9F]|[ ])*$/';
        }

        return preg_match($regex, $value);
    }

    /**
     * validation hiragana
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateHiragana(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^(\xe3(\x81[\x81-\xbf]|\x82[\x80-\x93]|\x83\xbc))*$/';

        // in allow_spaces mode
        if (isset($parameters[0]) && $parameters[0] == 'allow_spaces') {
            $regex = '/^(\xe3(\x81[\x81-\xbf]|\x82[\x80-\x93]|\x83\xbc)|[　 ])*$/';
        }

        return preg_match($regex, $value);
    }

    /**
     * validation katakana
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateKatakana(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^(\xe3(\x82[\xa1-\xbf]|\x83[\x80-\xb6]|\x83\xbc|\x82\x9b|\x82\x9c))*$/';

        // in allow_spaces mode
        if (isset($parameters[0]) && $parameters[0] == 'allow_spaces') {
            $regex = '/^(\xe3(\x82[\xa1-\xbf]|\x83[\x80-\xb6]|\x83\xbc|\x82\x9b|\x82\x9c)|[　 ])*$/';
        }

        return preg_match($regex, $value);
    }

    /**
     * validation zenkaku
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateZenkaku(string $attribute, $value, array $parameters): bool
    {
        $regex = '/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/';

        return !preg_match($regex, $value);
    }

    /**
     * validation zip code
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateZipCode(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^\d{3}\-?\d{4}$/';

        // in strict mode, $value must include a hyphen
        if (isset($parameters[0]) && $parameters[0] == 'strict') {
            $regex = '/^\d{3}\-\d{4}$/';
        }

        return preg_match($regex, $value);
    }

    /**
     * validation max byte
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateMaxByte(string $attribute, $value, array $parameters): bool
    {
        $this->requireParameterCount(1, $parameters, 'max_byte');

        return mb_strwidth($value) <= $parameters[0];
    }

    /**
     * replaver fot validateMaxByte parameter
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array $parameters
     * @return string
     */
    protected function replaceMaxByte($message, $attribute, $rule, $parameters)
    {
        return str_replace(':max_byte', $parameters[0], $message);
    }

    /**
     * validation valii_email
     *
     * email validate refer to CakePHP regex
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateValiiEmail(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)'
        . '|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)'
        . '|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)'
        . '|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]'
        . '|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)'
        . '|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]'
        . '|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)'
        . '|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)'
        . '|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})'
        . '|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))'
        . '|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)'
        . '|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])'
        . '|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])'
        . '|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        return (bool)preg_match($regex, $value);
    }

}
