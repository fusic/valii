<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\Hiragana;

/**
 * TelTest
 *
 */
class HiraganaTest extends TestCase
{
    /**
     * ひらがなのテスト
     *
     * @dataProvider providerTel
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_ひらがなチェック($tel, $expect)
    {
        $rule = [
            'name' => [
                new Hiragana()
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
            'ひらがなのみ' => ['さんぷる', true],
            'ひらがな以外' => ['ダミー情報', false],
            'ひらがな以外混じり' => ['さんぷる情報', false],
            '半角英数' => ['abcd1234', false]
        ];
    }
}
