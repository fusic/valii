<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\Zenkaku;

/**
 * ZenkakuTest
 *
 */
class ZenkakuTest extends TestCase
{
    /**
     * 全角のテスト
     *
     * @dataProvider providerZenkaku
     * @param $zenkaku string テストデータ
     * @param mixed $expect
     */
    public function test_全角チェック($zenkaku, $expect)
    {
        $rule = [
            'name' => [
                new Zenkaku()
            ]
        ];
        $dataList = [];
        $dataList['name'] = $zenkaku;

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
    public function providerZenkaku(): array
    {
        return [
            '全角ひらがな' => ['さんぷる', true],
            '全角カタカナ' => ['サンプル', true],
            '全角数字' => ['０１２３', true],
            '全角英字' => ['ＡＢＣＤ', true],
            '全角漢字' => ['情報', true],

            '半角ｶﾀｶﾅ' => ['ｻﾝﾌﾟﾙ', false],
            '半角数字' => ['1234', false],
            '半角英字' => ['abcd', false],
            '全角半角混じり' => ['さんぷるｻﾝﾌﾟﾙ', false]
        ];
    }
}
