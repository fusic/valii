<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\MaxByte;

/**
 * MaxByteTest
 *
 */
class MaxByteTest extends TestCase
{
    /**
     * マルチバイト対応のイト数のテスト
     *
     * @dataProvider providerMaxByte
     * @param $text string テストデータ
     * @param mixed $expect
     */
    public function test_バイト数チェック($text, $expect)
    {
        $rule = [
            'memo' => [
                new MaxByte(10)
            ]
        ];
        $dataList = [];
        $dataList['memo'] = $text;

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
    public function providerMaxByte(): array
    {
        return [
            '0バイト' => ['', true],
            '半角のみ10バイト' => ['0123456789', true],
            '半角のみ11バイト' => ['12345678901', false],
            '全角のみ10バイト' => ['１２３４５', true],
            '全角のみ12バイト' => ['１２３４５６', false],
            '半角全角10バイト' => ['1234１２３', true],
            '半角全角11バイト' => ['１２３４123', false],
        ];
    }
}
