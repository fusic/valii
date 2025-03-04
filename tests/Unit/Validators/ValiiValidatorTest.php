<?php
namespace Tests\Unit\Validators;

use App;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * ValiiValidatorTest
 *
 */
class ValiiValidatorTest extends TestCase
{
    # --------------------------------------------------------------
    # katakana

    /**
     * 全角カタカナのテスト
     *
     * @dataProvider providerKatakana
     * @param string $katakana
     * @param bool $expect
     */
    public function test_全角カタカナ($katakana, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $katakana,
            ],
            [
                'name' => 'katakana',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerKatakana(): array
    {
        return [
            '全角カタカナ' => ['サンプル', true],
            '全角ひらがな_en' => ['さんぷる', false],
            '全角ひらがな_ja' => ['さんぷる', false],
            '半角ｶﾀｶﾅ' => ['ｻﾝﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false],
            '半角スペースあり' => ['サン プル', false],
            '全角スペースあり' => ['サン　プル', false],
        ];
    }

    /**
     * 全角カタカナのテスト_スペースあり
     *
     * @dataProvider providerKatakanaWithSpaces
     * @param string $katakana
     * @param bool $expect
     */
    public function test_全角カタカナ_スペースあり($katakana, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $katakana,
            ],
            [
                'name' => 'katakana:allow_spaces',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerKatakanaWithSpaces(): array
    {
        return [
            '全角カタカナ' => ['サンプル', true],
            '全角ひらがな_en' => ['さんぷる', false],
            '全角ひらがな_ja' => ['さんぷる', false],
            '半角ｶﾀｶﾅ' => ['ｻﾝﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false],
            '半角スペースあり' => ['サン プル', true],
            '全角スペースあり' => ['サン　プル', true],
        ];
    }

    /**
     * 全角カタカナのエラーメッセージ テスト
     *
     * @dataProvider providerKatakanaMessage
     * @param string $katakana
     * @param string $locale
     * @param string $expect
     */
    public function test_全角カタカナ_メッセージ($katakana, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $katakana,
            ],
            [
                'name' => 'katakana',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerKatakanaMessage(): array
    {
        return [
            'en' => ['さんぷる', 'en', 'The name must be Katakana.'],
            'ja' => ['さんぷる', 'ja', 'nameはカタカナのみにしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # hankaku_katakana

    /**
     * 半角ｶﾀｶﾅのテスト
     *
     * @dataProvider providerHankakuKatakana
     * @param $katakana string テストデータ
     * @param bool $expect
     */
    public function test_半角ｶﾀｶﾅ($katakana, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $katakana,
            ],
            [
                'name' => 'hankaku_katakana',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerHankakuKatakana(): array
    {
        return [
            '半角ｶﾀｶﾅのみ' => ['ｻﾝﾌﾟﾙ', true],
            '全角カタカナのみ' => ['サンプル', false],
            '全角半角カタカナ' => ['サンﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false],
            '半角スペースあり' => ['ｻﾝ ﾌﾟﾙ', false],
            '全角スペースあり' => ['ｻﾝ　ﾌﾟﾙ', false],
        ];
    }

    /**
     * 半角ｶﾀｶﾅのテスト_スペースあり
     *
     * @dataProvider providerHankakuKatakanaWithSpaces
     * @param $katakana string テストデータ
     * @param bool $expect
     */
    public function test_半角ｶﾀｶﾅ_スペースあり($katakana, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $katakana,
            ],
            [
                'name' => 'hankaku_katakana:allow_spaces',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerHankakuKatakanaWithSpaces(): array
    {
        return [
            '半角ｶﾀｶﾅのみ' => ['ｻﾝﾌﾟﾙ', true],
            '全角カタカナのみ' => ['サンプル', false],
            '全角半角カタカナ' => ['サンﾌﾟﾙ', false],
            '半角英数' => ['abcd1234', false],
            '半角スペースあり' => ['ｻﾝ ﾌﾟﾙ', true],
            '全角スペースあり' => ['ｻﾝ　ﾌﾟﾙ', false],
        ];
    }

    /**
     * 半角ｶﾀｶﾅのエラーメッセージ テスト
     *
     * @dataProvider providerHankakuKatakanaMessage
     * @param string $katakana
     * @param sting $locale
     * @param sting $expect
     */
    public function test_半角ｶﾀｶﾅ_メッセージ($katakana, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $katakana,
            ],
            [
                'name' => 'hankaku_katakana',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerHankakuKatakanaMessage(): array
    {
        return [
            'en' => ['さんぷる', 'en', 'The name must be half-width Katakana.'],
            'ja' => ['さんぷる', 'ja', 'nameは半角カタカナのみにしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # hiragana

    /**
     * ひらがなのテスト
     *
     * @dataProvider providerHiragana
     * @param $hiragana string テストデータ
     * @param bool $expect
     */
    public function test_ひらがな($hiragana, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $hiragana,
            ],
            [
                'name' => 'hiragana',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerHiragana(): array
    {
        return [
            'ひらがなのみ' => ['さんぷる', true],
            'ひらがな以外' => ['ダミー情報', false],
            'ひらがな以外混じり' => ['さんぷる情報', false],
            '半角英数' => ['abcd1234', false],
            '半角スペースあり' => ['さん ぷる', false],
            '全角スペースあり' => ['さん　ぷる', false],
        ];
    }

    /**
     * ひらがなのテスト_スペースあり
     *
     * @dataProvider providerHiraganaWithSpaces
     * @param $hiragana string テストデータ
     * @param bool $expect
     */
    public function test_ひらがな_スペースあり($hiragana, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $hiragana,
            ],
            [
                'name' => 'hiragana:allow_spaces',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerHiraganaWithSpaces(): array
    {
        return [
            'ひらがなのみ' => ['さんぷる', true],
            'ひらがな以外' => ['ダミー情報', false],
            'ひらがな以外混じり' => ['さんぷる情報', false],
            '半角英数' => ['abcd1234', false],
            '半角スペースあり' => ['さん ぷる', true],
            '全角スペースあり' => ['さん　ぷる', true],
        ];
    }

    /**
     * ひらがなのエラーメッセージ テスト
     *
     * @dataProvider providerHiraganaMessage
     * @param string $hiragana
     * @param string $locale
     * @param string $expect
     */
    public function test_ひらがな_メッセージ($hiragana, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $hiragana,
            ],
            [
                'name' => 'hiragana',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerHiraganaMessage(): array
    {
        return [
            'en' => ['ダミー情報', 'en', 'The name must be Hiragana.'],
            'ja' => ['ダミー情報', 'ja', 'nameはひらがなのみにしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # zenkaku

    /**
     * 全角のテスト
     *
     * @dataProvider providerZenkaku
     * @param $zenkaku string テストデータ
     * @param bool $expect
     */
    public function test_全角($zenkaku, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $zenkaku,
            ],
            [
                'name' => 'zenkaku',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerZenkaku(): array
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
     * 全角のエラーメッセージ テスト
     *
     * @dataProvider providerZenkakuMessage
     * @param string $zenkaku
     * @param string $locale
     * @param string $expect
     */
    public function test_全角_メッセージ($zenkaku, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $zenkaku,
            ],
            [
                'name' => 'zenkaku',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerZenkakuMessage(): array
    {
        return [
            'en' => ['ｻﾝﾌﾟﾙ', 'en', 'The name must be full-width character.'],
            'ja' => ['ｻﾝﾌﾟﾙ', 'ja', 'nameは全角のみにしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # tel

    /**
     * 電話番号のテスト
     *
     * @dataProvider providerTel
     * @param $tel string テストデータ
     * @param bool $expect
     */
    public function test_電話番号($tel, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $tel,
            ],
            [
                'name' => 'tel',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerTel(): array
    {
        return [
            '電話番号(ハイフンあり)' => ['092-737-2616', true],
            '電話番号(ハイフンあり-東京-)' => ['03-6450-1633', true],
            '電話番号(ハイフンあり-市外局番2桁-)' => ['045-999-9999', true],
            '電話番号(ハイフンあり-市外局番3桁-)' => ['0940-99-9999', true],
            '電話番号(ハイフンあり-市外局番4桁-)' => ['04992-9-9999', true],
            '電話番号(ハイフン無し)' => ['0927372616', true],
            '電話番号(ハイフン無し-東京-)' => ['0364501633', true],
            '携帯電話番号(ハイフンあり-070-)' => ['070-9999-9999', true],
            '携帯電話番号(ハイフンあり-080-)' => ['080-9999-9999', true],
            '携帯電話番号(ハイフンあり-090-)' => ['090-9999-9999', true],
            '携帯電話番号(ハイフン無し)' => ['09099999999', true],
            '電話番号(丸かっこ)' => ['092(737)2616', false],
            '電話番号(不正フォーマット)' => ['abcdefg', false],
            '電話番号(全角)' => ['０９２７３７２６１６', false]
        ];
    }

    /**
     * 電話番号のエラーメッセージ テスト
     *
     * @dataProvider providerTelMessage
     * @param string $tel
     * @param string $locale
     * @param string $expect
     */
    public function test_電話番号_メッセージ($tel, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $tel,
            ],
            [
                'name' => 'tel',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerTelMessage(): array
    {
        return [
            'en' => ['092(737)2616', 'en', 'The name is not a valid phone number.'],
            'ja' => ['092(737)2616', 'ja', 'nameは電話番号の書式にしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # zip_code

    /**
     * 郵便番号のテスト
     *
     * @dataProvider providerZipCode
     * @param $zipCode string テストデータ
     * @param bool $expect
     */
    public function test_郵便番号($zipCode, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $zipCode,
            ],
            [
                'name' => 'zip_code',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerZipCode(): array
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
     * 郵便番号のテスト
     *
     * @dataProvider providerZipCodeStrict
     * @param $zipCode string テストデータ
     * @param bool $expect
     */
    public function test_郵便番号_strict($zipCode, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $zipCode,
            ],
            [
                'name' => 'zip_code:strict',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerZipCodeStrict(): array
    {
        return [
            '郵便番号' => ['123-4567', true],
            '郵便番号（ハイフンなし）' => ['1234567', false],
            '郵便番号（数字8桁）' => ['12345678', false],
            '郵便番号（数字6桁）' => ['123456', false],
            '郵便番号（文字）' => ['abcdecf', false],
            '郵便番号（全角ハイフンあり）' => ['１２３-４５６７', false],
            '郵便番号（全角ハイフンなし）' => ['１２３４５６７', false],
        ];
    }

    /**
     * 郵便番号のエラーメッセージ テスト
     *
     * @dataProvider providerZipCodeMessage
     * @param string $zipCode
     * @param string $locale
     * @param string $expect
     */
    public function test_郵便番号_メッセージ($zipCode, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $zipCode,
            ],
            [
                'name' => 'zip_code',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerZipCodeMessage(): array
    {
        return [
            'en' => ['12345678', 'en', 'The name is not a valid ZIP Code.'],
            'ja' => ['12345678', 'ja', 'nameは郵便番号の書式にしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # max_byte

    /**
     * マルチバイト対応のバイト数のテスト
     *
     * @dataProvider providerMaxByte
     * @param $text string テストデータ
     * @param bool $expect
     */
    public function test_バイト数($text, $expect)
    {
        $validator = Validator::make(
            [
                'name' => $text,
            ],
            [
                'name' => 'max_byte:10',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerMaxByte(): array
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

    /**
     * マルチバイト対応のバイト数 テスト
     *
     * @dataProvider providerMaxByteMessage
     * @param string $text
     * @param string $locale
     * @param string $expect
     */
    public function test_バイト数_メッセージ($text, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'name' => $text,
            ],
            [
                'name' => 'max_byte:10',
            ]
        );

        $errorMessage = $validator->errors()->get('name')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerMaxByteMessage(): array
    {
        return [
            'en' => ['12345678901', 'en', 'The name may not be greater than 10 bytes.'],
            'ja' => ['12345678901', 'ja', 'nameは10バイト以下にしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # valii_email

    /**
     * メールアドレスのテスト.ver
     *
     * @dataProvider providerEmail
     * @param $text string テストデータ
     * @param bool $expect
     */
    public function test_メールアドレス($text, $expect)
    {
        $validator = Validator::make(
            [
                'mail' => $text,
            ],
            [
                'mail' => 'valii_email',
            ]
        );

        $this->assertEquals($expect, $validator->passes());
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerEmail(): array
    {
        return [
            '通常' => ['example@example.com', true],
            '記号含む' => ['example+115@example.com', true],
            '先頭スペース_半角' => [' example@example.com', false],
            '末尾スペース_半角' => ['example@example.com ', false],
            '先頭スペース_全角' => ['　example@example.com', false],
            '末尾スペース_全角' => ['example@example.com　', false],
            '途中スペース_半角' => ['example @example.com', false],
            '途中スペース_全角' => ['example@e　xample.com', false],
            '@なし' => ['examplexample.com', false],
            '全角' => ['ｅｘａｍｐｌｅ＠ｅｘａｍｐｌｅ．ｃｏｍm', false],
            'ひらがな' => ['あexample@example.com', false],
            '漢字' => ['example例@example.com', false],
            '先頭がドット' => ['.example@example.com', false],
            '末尾がドット' => ['example@example.com.', false],
            'ドットが連続' => ['example..@example.com', false],
        ];
    }

    /**
     * メールアドレスのテスト メッセージ テスト
     *
     * @dataProvider providerEmailMessage
     * @param string $text
     * @param string $locale
     * @param string $expect
     */
    public function test_メールアドレス_メッセージ($text, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'mail' => $text,
            ],
            [
                'mail' => 'valii_email',
            ]
        );

        $errorMessage = $validator->errors()->get('mail')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerEmailMessage(): array
    {
        return [
            'en' => ['example..@example.com', 'en', 'The mail must be a valid email address.'],
            'ja' => ['example..@example.com', 'ja', 'mailは、有効なメールアドレスにしてください。'],
        ];
    }

    # --------------------------------------------------------------
    # valii_emoji

    /**
     * 絵文字、特殊文字のテスト
     *
     * @dataProvider providerEmoji
     */
    public function test_絵文字($text, $locale, $expect)
    {
        App::setLocale($locale);

        $validator = Validator::make(
            [
                'text' => $text,
            ],
            [
                'text' => 'valii_emoji_and_symbol',
            ]
        );

        $errorMessage = $validator->errors()->get('text')[0];
        $this->assertEquals($expect, $errorMessage);
    }

    /**
     * テストデータ
     *
     * @return array
     */
    public static function providerEmoji(): array
    {
        return [
            // 各種技術記号
            'ja' => ['⌘⌫', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['⌘⌫', 'en', 'The text must not contain emojis and symbols.'],
            // 丸囲み数字
            'ja' => ['➀', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['➀', 'en', 'The text must not contain emojis and symbols.'],
            // 雑多な記号
            'ja' => ['☀️', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['☀️', 'en', 'The text must not contain emojis and symbols.'],
            // 装飾記号
            'ja' => ['✂️', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['✂️', 'en', 'The text must not contain emojis and symbols.'],
            // 矢印記号
            'ja' => ['↑ ↓ ← →', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['↑ ↓ ← →', 'en', 'The text must not contain emojis and symbols.'],
            // 補助矢印記号
            'ja' => ['⟰⟱', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['⟰⟱', 'en', 'The text must not contain emojis and symbols.'],
            // 補助数学演算子（矢印含む）
            'ja' => ['⤒⤓', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['⤒⤓', 'en', 'The text must not contain emojis and symbols.'],
            // その他の矢印記号
            'ja' => ['➡️', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['➡️', 'en', 'The text must not contain emojis and symbols.'],
            // 異体字セレクタ
            'ja' => ['⭕️❗️', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['⭕️❗️', 'en', 'The text must not contain emojis and symbols.'],
            // サロゲートペア
            'ja' => ['😋😁', 'ja', 'textは、絵文字と特殊文字を含めないでください。'],
            'en' => ['😋😁', 'en', 'The text must not contain emojis and symbols.'],
        ];
    }
    
}
