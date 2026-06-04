<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

final class ValidationRules
{
    /** Nombres, títulos, tipos: solo letras */
    public const LETTERS_REGEX = '/^[\pL\s\-]+$/u';

    /** Teléfonos: números y símbolos de llamada */
    public const PHONE_REGEX = '/^[\d\s\+\-\(\)]+$/u';

    /** Direcciones: letras, números y signos habituales (Calle 45 #12-34) */
    public const ADDRESS_REGEX = '/^[\pL\pN\s\-.,#ºª\/°]+$/u';

    /** Descripciones y textos largos: letras, números y puntuación */
    public const TEXT_REGEX = '/^[\pL\pN\s\-.,;:¡!¿?()#ºª\/°]+$/u';

    /**
     * @return array<int, string>
     */
    public static function lettersOnly(bool $required = true, int $max = 255): array
    {
        return self::withRegex(self::LETTERS_REGEX, $required, $max);
    }

    /**
     * @return array<int, string>
     */
    public static function phone(bool $required = true): array
    {
        $rules = ['string', 'max:50', 'regex:'.self::PHONE_REGEX];
        array_unshift($rules, $required ? 'required' : 'nullable');

        return $rules;
    }

    /**
     * @return array<int, string>
     */
    public static function address(bool $required = true, int $max = 255): array
    {
        return self::withRegex(self::ADDRESS_REGEX, $required, $max);
    }

    /**
     * @return array<int, string>
     */
    public static function text(bool $required = true, int $max = 5000): array
    {
        return self::withRegex(self::TEXT_REGEX, $required, $max);
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @return array<int, string>
     */
    public static function lettersOnlyForRequest(
        FormRequest $request,
        string $attribute,
        string $modelClass,
        string $routeParameter,
        bool $required = true,
        int $max = 255,
    ): array {
        return self::forRequest($request, $attribute, $modelClass, $routeParameter, self::lettersOnly($required, $max));
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @return array<int, string>
     */
    public static function addressForRequest(
        FormRequest $request,
        string $attribute,
        string $modelClass,
        string $routeParameter,
        bool $required = true,
        int $max = 255,
    ): array {
        return self::forRequest($request, $attribute, $modelClass, $routeParameter, self::address($required, $max));
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @return array<int, string>
     */
    public static function textForRequest(
        FormRequest $request,
        string $attribute,
        string $modelClass,
        string $routeParameter,
        bool $required = true,
        int $max = 5000,
    ): array {
        return self::forRequest($request, $attribute, $modelClass, $routeParameter, self::text($required, $max));
    }

    /**
     * @deprecated Use text() instead
     *
     * @return array<int, string>
     */
    public static function description(bool $required = true): array
    {
        return self::text($required);
    }

    /**
     * @deprecated Use textForRequest() instead
     *
     * @param  class-string<Model>  $modelClass
     * @return array<int, string>
     */
    public static function descriptionForRequest(
        FormRequest $request,
        string $attribute,
        string $modelClass,
        string $routeParameter,
        bool $required = true,
    ): array {
        return self::textForRequest($request, $attribute, $modelClass, $routeParameter, $required);
    }

    /**
     * @param  array<int, string>  $rules
     * @return array<int, string>
     */
    private static function forRequest(
        FormRequest $request,
        string $attribute,
        string $modelClass,
        string $routeParameter,
        array $rules,
    ): array {
        if ($request->isMethod('put') || $request->isMethod('patch')) {
            $model = $modelClass::query()->find($request->route($routeParameter));

            if ($model && self::valuesAreEqual($request->input($attribute), $model->getAttribute($attribute))) {
                return self::withoutRegex($rules);
            }
        }

        return $rules;
    }

    /**
     * @return array<int, string>
     */
    private static function withRegex(string $regex, bool $required, int $max): array
    {
        $rules = ['string', 'max:'.$max, 'regex:'.$regex];
        array_unshift($rules, $required ? 'required' : 'nullable');

        return $rules;
    }

    /**
     * @param  array<int, string>  $rules
     * @return array<int, string>
     */
    private static function withoutRegex(array $rules): array
    {
        return array_values(array_filter(
            $rules,
            static fn (string $rule): bool => ! str_starts_with($rule, 'regex:'),
        ));
    }

    private static function valuesAreEqual(mixed $incoming, mixed $original): bool
    {
        return trim((string) $incoming) === trim((string) $original);
    }

    /**
     * @return array<string, string>
     */
    public static function letterRegexMessage(string $attribute, string $label): array
    {
        return [
            $attribute.'.regex' => $label.' solo puede contener letras, espacios y guiones.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function phoneRegexMessage(string $attribute, string $label): array
    {
        return [
            $attribute.'.regex' => $label.' solo puede contener números y los símbolos + - ( ).',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function addressRegexMessage(string $attribute, string $label): array
    {
        return [
            $attribute.'.regex' => $label.' contiene caracteres no permitidos. Use letras, números y signos como # . , - /',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function textRegexMessage(string $attribute, string $label): array
    {
        return [
            $attribute.'.regex' => $label.' contiene caracteres no permitidos.',
        ];
    }

    /**
     * @deprecated Use textRegexMessage()
     *
     * @return array<string, string>
     */
    public static function descriptionRegexMessage(string $attribute, string $label): array
    {
        return self::textRegexMessage($attribute, $label);
    }
}
