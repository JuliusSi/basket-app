<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Laukas :attribute turi būti priimtas.',
    'accepted_if'          => 'The :attribute must be accepted when :other is :value.',
    'active_url'           => 'Laukas :attribute nėra galiojantis internetinis adresas.',
    'after'                => 'Lauko :attribute reikšmė turi būti po :date datos.',
    'after_or_equal'       => 'Lauko :attribute reikšmė privalo būti data lygi arba vėlesnė negu :date.',
    'alpha'                => 'Laukas :attribute gali turėti tik raides.',
    'alpha_dash'           => 'Laukas :attribute gali turėti tik raides, skaičius ir brūkšnelius.',
    'alpha_num'            => 'Laukas :attribute gali turėti tik raides ir skaičius.',
    'array'                => 'Laukas :attribute turi būti masyvas.',
    'before'               => 'Laukas :attribute turi būti data prieš :date.',
    'before_or_equal'      => 'Lauko :attribute reikšmė privalo būti data lygi arba ankstesnė negu :date.',
    'between'              => [
        'array'   => 'Elementų skaičius lauke :attribute turi turėti nuo :min iki :max.',
        'file'    => 'Failo dydis lauke :attribute turi būti tarp :min ir :max kilobaitų.',
        'numeric' => 'Lauko :attribute reikšmė turi būti tarp :min ir :max.',
        'string'  => 'Simbolių skaičius lauke :attribute turi būti tarp :min ir :max.',
    ],
    'boolean'              => 'Lauko reikšmė :attribute turi būti \'taip\' arba \'ne\'.',
    'confirmed'            => 'Lauko :attribute patvirtinimas nesutampa.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => 'Lauko :attribute reikšmė nėra galiojanti data.',
    'date_equals'          => 'Lauko :attribute reikšmė turi būti data lygi :date.',
    'date_format'          => 'Lauko :attribute reikšmė neatitinka formato :format.',
    'declined'             => 'The :attribute must be declined.',
    'declined_if'          => 'The :attribute must be declined when :other is :value.',
    'different'            => 'Laukų :attribute ir :other reikšmės turi skirtis.',
    'digits'               => 'Laukas :attribute turi būti sudarytas iš :digits skaitmenų.',
    'digits_between'       => 'Laukas :attribute turi turėti nuo :min iki :max skaitmenų.',
    'dimensions'           => 'Lauke :attribute įkeltas paveiksliukas neatitinka išmatavimų reikalavimo.',
    'distinct'             => 'Laukas :attribute pasikartoja.',
    'email'                => 'Lauko :attribute reikšmė turi būti galiojantis el. pašto adresas.',
    'ends_with'            => 'Laukas :attribute turi baigtis vienu iš: :values',
    'enum'                 => 'The selected :attribute is invalid.',
    'exists'               => 'Pasirinkta negaliojanti :attribute reikšmė.',
    'file'                 => ':attribute turi būti failas.',
    'filled'               => 'Laukas :attribute turi būti užpildytas.',
    'gt'                   => [
        'array'   => 'Laukas :attribute turi turėti daugiau nei :value elementus.',
        'file'    => 'Failas lauke :attribute turi būti didesnis negu :value kilobaitai.',
        'numeric' => 'Lauko :attribute reikšmė turi būti didesnė negu :value.',
        'string'  => 'Lauko :attribute reikšmė turi būti didesnė negu :value simboliai.',
    ],
    'gte'                  => [
        'array'   => 'Laukas :attribute turi turėti :value elementus arba daugiau.',
        'file'    => 'Failas lauke :attribute turi būti didesnis arba lygus :value kilobaitams.',
        'numeric' => 'Lauko :attribute reikšmė turi būti didesnė arba lygi :value.',
        'string'  => 'Lauko :attribute reikšmė turi būti didesnė arba lygi :value simboliams.',
    ],
    'image'                => 'Lauko :attribute reikšmė turi būti paveikslėlis.',
    'in'                   => 'Pasirinkta negaliojanti :attribute reikšmė.',
    'in_array'             => 'Laukas :attribute neegzistuoja :other lauke.',
    'integer'              => 'Lauko :attribute reikšmė turi būti sveikasis skaičius.',
    'ip'                   => 'Lauko :attribute reikšmė turi būti galiojantis IP adresas.',
    'ipv4'                 => 'Lauko :attribute reikšmė turi būti galiojantis IPv4 adresas.',
    'ipv6'                 => 'Lauko :attribute reikšmė turi būti galiojantis IPv6 adresas.',
    'json'                 => 'Lauko :attribute reikšmė turi būti JSON tekstas.',
    'lt'                   => [
        'array'   => 'Laukas :attribute turi turėti mažiau negu :value elementus.',
        'file'    => 'Failas lauke :attribute turi būti mažesnis negu :value kilobaitai.',
        'numeric' => 'Lauko :attribute reikšmė turi būti mažesnė negu :value.',
        'string'  => 'Lauko :attribute reikšmė turi būti mažesnė negu :value simboliai.',
    ],
    'lte'                  => [
        'array'   => 'Laukas :attribute turi turėti mažiau arba lygiai :value elementus.',
        'file'    => 'Failas lauke :attribute turi būti mažesnis arba lygus :value kilobaitams.',
        'numeric' => 'Lauko :attribute reikšmė turi būti mažesnė arba lygi :value.',
        'string'  => 'Lauko :attribute reikšmė turi būti mažesnė arba lygi :value simboliams.',
    ],
    'mac_address'          => 'The :attribute must be a valid MAC address.',
    'max'                  => [
        'array'   => 'Elementų kiekis lauke :attribute negali turėti daugiau nei :max elementų.',
        'file'    => 'Failo dydis lauke :attribute negali būti didesnis nei :max kilobaitų.',
        'numeric' => 'Lauko :attribute reikšmė negali būti didesnė nei :max.',
        'string'  => 'Simbolių kiekis lauke :attribute reikšmė negali būti didesnė nei :max simbolių.',
    ],
    'mimes'                => 'Lauko reikšmė :attribute turi būti failas vieno iš sekančių tipų: :values.',
    'mimetypes'            => 'Lauko reikšmė :attribute turi būti failas vieno iš sekančių tipų: :values.',
    'min'                  => [
        'array'   => 'Elementų kiekis lauke :attribute turi būti ne mažiau nei :min.',
        'file'    => 'Failo dydis lauke :attribute turi būti ne mažesnis nei :min kilobaitų.',
        'numeric' => 'Lauko :attribute reikšmė turi būti ne mažesnė nei :min.',
        'string'  => 'Simbolių kiekis lauke :attribute turi būti ne mažiau nei :min.',
    ],
    'multiple_of'          => 'Laukas :attribute turi būti :value kartotinis.',
    'not_in'               => 'Pasirinkta negaliojanti reikšmė :attribute.',
    'not_regex'            => 'Lauko :attribute formatas yra neteisingas.',
    'numeric'              => 'Lauko :attribute reikšmė turi būti skaičius.',
    'password'             => 'Slaptažodis neteisingas.',
    'present'              => 'Laukas :attribute turi egzistuoti.',
    'prohibited'           => ':attribute laukas draudžiamas.',
    'prohibited_if'        => ':attribute laukas draudžiamas, kai :other yra :value.',
    'prohibited_unless'    => ':attribute laukas draudžiamas, nebent :other yra :values.',
    'prohibits'            => 'The :attribute field prohibits :other from being present.',
    'regex'                => 'Negaliojantis lauko :attribute formatas.',
    'required'             => 'Privaloma užpildyti lauką :attribute.',
    'required_if'          => 'Privaloma užpildyti lauką :attribute, kai :other yra :value.',
    'required_unless'      => 'Laukas :attribute yra privalomas, nebent :other yra tarp :values reikšmių.',
    'required_with'        => 'Privaloma užpildyti lauką :attribute, kai pateikta :values.',
    'required_with_all'    => 'Privaloma užpildyti lauką :attribute, kai pateikta :values.',
    'required_without'     => 'Privaloma užpildyti lauką :attribute, kai nepateikta :values.',
    'required_without_all' => 'Privaloma užpildyti lauką :attribute, kai nepateikta nei viena iš reikšmių :values.',
    'same'                 => 'Laukai :attribute ir :other turi sutapti.',
    'size'                 => [
        'array'   => 'Elementų kiekis lauke :attribute turi būti :size.',
        'file'    => 'Failo dydis lauke :attribute turi būti :size kilobaitai.',
        'numeric' => 'Lauko :attribute reikšmė turi būti :size.',
        'string'  => 'Simbolių skaičius lauke :attribute turi būti :size.',
    ],
    'starts_with'          => 'Laukas :attribute turi prasidėti vienu iš: :values',
    'string'               => 'Laukas :attribute turi būti tekstinis.',
    'timezone'             => 'Lauko :attribute reikšmė turi būti galiojanti laiko zona.',
    'unique'               => 'Tokia :attribute reikšmė jau pasirinkta.',
    'uploaded'             => 'Nepavyko įkelti :attribute lauko.',
    'url'                  => 'Negaliojantis lauko :attribute formatas.',
    'uuid'                 => 'Lauko :attribute reikšmė turi būti galiojantis UUID.',
    'phone_code' => 'Telefono numerio kodas neteisingas. Telefono numeris turi prasidėti: :codes.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'g-recaptcha-response' => [
            'required' => 'Kad ir kaip kvailai nuskambėtų, bet prašome pativrtinti, kad nesate robotas.',
            'captcha' => 'Nepavyko įrodyti, kad nesate robotas.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'phone' => 'telefono numeris',
        'email' => 'el. paštas',
        'username' => 'vartotojo vardas',
    ],
    'meter.names' => [
        'in' => 'Įvesto matuoklio pavadinimo nėra palaikomų matuoklių sąraše',
    ],
    'error_in_input' => 'Klaida laukelyje: ',
];
