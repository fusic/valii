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
     * validation email_cakephp
     *
     * email validate by CakePHP regex
     *
     * @SuppressWarnings("unused")
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  mixed  $parameters
     * @return bool
     */
    public function validateEmailCake(string $attribute, $value, array $parameters): bool
    {
        $regex = '/^[\p{L}0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[\p{L}0-9!#$%&\'*+\/=?^_`{|}~-]+)*@'
        . '(?:[_\p{L}0-9][-_\p{L}0-9]*\.)*(?:[\p{L}0-9][-\p{L}0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,})'
        . '$/ui';

        return preg_match($regex, $value);
    }

}
