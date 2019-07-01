# Valii

[![CircleCI](https://img.shields.io/circleci/build/github/fusic/valii.svg?style=flat-square)](https://circleci.com/gh/fusic/valii)
[![Scrutinizer code quality (GitHub/Bitbucket)](https://img.shields.io/scrutinizer/quality/g/fusic/valii.svg?style=flat-square)](https://scrutinizer-ci.com/g/fusic/valii/)
[![Codecov](https://img.shields.io/codecov/c/github/fusic/valii.svg?style=flat-square)](https://codecov.io/gh/fusic/valii/)

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
            "name" => 'required|hiragana',
            "tel" =>  'tel',
            "zip_code"  => [
                'zip_code'
            ],
            "strict_zip_code"  =>  [
                'required',
                'zip_code:strict'
            ]
        ];
    }
```
