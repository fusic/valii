<?php

namespace Valii\Providers;

use App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Valii\Validators\ValiiValidator;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'valii');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/valii'),
        ]);

        Validator::resolver(function($translator, $data, $rules, $messages, $attributes) {
            // バリデーションメッセージを取得
            $customMessages = trans('valii::validation', [], App::getLocale());

            $validator = new ValiiValidator($translator, $data, $rules, $messages, $attributes);

            // バリデータにメッセージ群をセット
            $validator->setCustomMessages($customMessages);
            return $validator;
        });
    }
}
