<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\HankakuKatakana;

/**
 * TelTest
 *
 */
class HankakuKatakanaTest extends TestCase
{
    /**
     * 半角ｶﾀｶﾅのテスト
     *
     * @dataProvider providerTel
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_半角ｶﾀｶﾅチェック($tel, $expect)
    {
        $rule = [
            'name' => [
                new HankakuKatakana()
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
    public function providerTel(): array
    {
        return [
            '半角ｶﾀｶﾅのみ' => ['ｻﾝﾌﾟﾙ', true],
            '全角カタカナのみ' => ['サンプル', false],
            '全角半角カタカナ' => ['サンﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false]
        ];
    }
}
