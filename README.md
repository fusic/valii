# Valii

## Setup

```
composer require fusic/valii
```

## validation

- Tel
  - 電話番号フォーマットチェック
- Hiragana
  - ひらがなのみチェック
- Katakana
  - カタカナのみチェック
- HankakuKatakana
  - 半角ｶﾀｶﾅチェック
- Zenkaku
  - 全角のみチェック
- ZipCode
  - 郵便番号チェック

## Usage

```
public function rules()
    {
        return [
            "name" => [
                'required',
                new Hiragana()
            ]
        ];
    }
```
