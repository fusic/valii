<?php
namespace Tests\Unit\Rules;

use Illuminate\Validation\Validator;
use Tests\TestCase;
use Valii\Rules\Tel;

/**
 * TelTest
 *
 */
class TelTest extends TestCase
{
    /**
     * 電話番号のテスト
     *
     * @dataProvider providerTel
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_電話番号チェック($tel, $expect)
    {
        $rule = [
            'name' => [
                new Tel()
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
            '電話番号(ハイフンあり)' => ['092-737-2616', true],
            '電話番号(ハイフンあり-東京-)' => ['03-6450-1633', true],
            '電話番号(ハイフン無し)' => ['0927372616', true],
            '電話番号(ハイフン無し-東京-)' => ['0364501633', true],
            '電話番号(丸かっこ)' => ['092(737)2616', false],
            '電話番号(不正フォーマット)' => ['abcdefg', false],
            '電話番号(全角)' => ['０９２７３７２６１６', false]
        ];
    }
}
