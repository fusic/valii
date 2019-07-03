<?php
namespace Tests\Unit\Validators;

use Valii\Validators\ValiiValidator;
use Tests\TestCase;

/**
 * ValiiValidatorTest
 *
 */
class ValiiValidatorTest extends TestCase
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
              'katakana'
            ]
        ];
        $dataList = [];
        $dataList['name'] = $tel;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * 半角ｶﾀｶﾅのテスト
     *
     * @dataProvider providerHankakuKatakana
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_半角ｶﾀｶﾅチェック($tel, $expect)
    {
        $rule = [
            'name' => [
              'hankaku_katakana'
            ]
        ];
        $dataList = [];
        $dataList['name'] = $tel;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * ひらがなのテスト
     *
     * @dataProvider providerHiragana
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_ひらがなチェック($tel, $expect)
    {
        $rule = [
            'name' => [
              'hiragana'
            ]
        ];
        $dataList = [];
        $dataList['name'] = $tel;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

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
              'tel'
            ]
        ];
        $dataList = [];
        $dataList['name'] = $tel;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * 全角のテスト
     *
     * @dataProvider providerZenkaku
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_全角チェック($tel, $expect)
    {
        $rule = [
            'name' => [
              'zenkaku'
            ]
        ];
        $dataList = [];
        $dataList['name'] = $tel;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * 郵便番号のテスト
     *
     * @dataProvider providerZipCode
     * @param $tel string テストデータ
     * @param mixed $expect
     */
    public function test_郵便番号チェック($zipCode, $expect)
    {
        $rule = [
            'name' => [
              'zip_code'
            ]
        ];
        $dataList = [];
        $dataList['name'] = $zipCode;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * マルチバイト対応のバイト数のテスト
     *
     * @dataProvider providerMaxByte
     * @param $text string テストデータ
     * @param mixed $expect
     */
    public function test_バイト数チェック($text, $expect)
    {
        $rule = [
            'memo' => [
                'max_byte:10'
            ]
        ];
        $dataList = [];
        $dataList['memo'] = $text;

        $trans = $this->getTranslator();
        $validator = new ValiiValidator($trans, $dataList, $rule);
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

    /**
     * テストデータ
     *
     * @return array
     */
    public function providerHankakuKatakana(): array
    {
        return [
            '半角ｶﾀｶﾅのみ' => ['ｻﾝﾌﾟﾙ', true],
            '全角カタカナのみ' => ['サンプル', false],
            '全角半角カタカナ' => ['サンﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false]
        ];
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public function providerHiragana(): array
    {
        return [
            'ひらがなのみ' => ['さんぷる', true],
            'ひらがな以外' => ['ダミー情報', false],
            'ひらがな以外混じり' => ['さんぷる情報', false],
            '半角英数' => ['abcd1234', false]
        ];
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
