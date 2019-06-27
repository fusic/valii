<?php

namespace Valii\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Valii\Validators\ValiiValidator;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'valii');

        // バリデーションメッセージを取得
        $customMessages = trans('valii::validation');
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) use ($customMessages) {
            $validator = new ValiiValidator($translator, $data, $rules, $messages, $attributes);

            // バリデータにメッセージ群をセット
            $validator->setCustomMessages($customMessages);
            return $validator;
        });
    }
}
