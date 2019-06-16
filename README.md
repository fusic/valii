# Valii

![CircleCI](https://img.shields.io/circleci/build/github/fusic/valii.svg?style=flat-square)
![Scrutinizer code quality (GitHub/Bitbucket)](https://img.shields.io/scrutinizer/quality/g/fusic/valii.svg?style=flat-square)
![Codecov](https://img.shields.io/codecov/c/github/fusic/valii.svg?style=flat-square)

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
