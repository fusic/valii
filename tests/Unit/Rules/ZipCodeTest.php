<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\ZipCode;

/**
 * ZipCodeTest
 *
 */
class ZipCodeTest extends TestCase
{
    /**
     * 郵便番号のテスト
     *
     * @dataProvider providerZipCode
     * @param $zipCode string テストデータ
     * @param mixed $expect
     */
    public function test_郵便番号チェック($zipCode, $expect)
    {
        $rule = [
            'name' => [
                new ZipCode()
            ]
        ];
        $dataList = [];
        $dataList['name'] = $zipCode;

        $trans = $this->getTranslator();
        $validator = new Validator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * 郵便番号のテスト
     *
     * @dataProvider providerZipCodeWithHyphen
     * @param $zipCode string テストデータ
     * @param mixed $expect
     */
    public function test_郵便番号チェック（ハイフンあり）($zipCode, $expect)
    {
        $rule = [
            'name' => [
                new ZipCode(['strict' => true])
            ]
        ];
        $dataList = [];
        $dataList['name'] = $zipCode;

        $trans = $this->getTranslator();
        $validator = new Validator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public function providerZipCode(): array
    {
        return [
            '郵便番号' => ['123-4567', true],
            '郵便番号（ハイフンなし）' => ['1234567', true],
            '郵便番号（数字8桁）' => ['12345678', false],
            '郵便番号（数字6桁）' => ['123456', false],
            '郵便番号（文字）' => ['abcdecf', false],
            '郵便番号（全角）' => ['１２３４５６７', false],
        ];
    }

    /**
     * テストデータ(ハイフンあり)
     *
     * @return array
     */
    public function providerZipCodeWithHyphen(): array
    {
        return [
            '郵便番号' => ['123-4567', true],
            '郵便番号（ハイフンなし）' => ['1234567', false],
            '郵便番号（数字8桁）' => ['12345678', false],
            '郵便番号（数字6桁）' => ['123456', false],
            '郵便番号（文字）' => ['abcdecf', false],
            '郵便番号（全角）' => ['１２３４５６７', false],
        ];
    }
}
