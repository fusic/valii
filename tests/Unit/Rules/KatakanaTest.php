<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\Katakana;

/**
 * TelTest
 *
 */
class KatakanaTest extends TestCase
{
    /**
     * 全角カタカナのテスト
     *
     * @dataProvider providerKatakana
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_全角カタカナチェック($tel, $expect)
    {
        $rule = [
            'name' => [
                new Katakana()
            ]
        ];
        $dataList = [];
        $dataList['name'] = $tel;

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
    public function providerKatakana(): array
    {
        return [
            '全角カタカナ' => ['サンプル', true],
            '全角ひらがな' => ['さんぷる', false],
            '半角ｶﾀｶﾅ' => ['ｻﾝﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false],
        ];
    }
}
