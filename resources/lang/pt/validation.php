<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted' => ':attribute deve ser aceito.',
    'active_url' => ':attribute não é um URL válido.',
    'after' => ': o atributo deve ser uma data depois de: date.',
    'after_or_equal' => ':attribute deve ser uma data posterior ou igual a: date.',
    'alpha' => ':attribute deve conter apenas letras.',
    'alpha_dash' => ':attribute deve conter apenas letras, números e hífens.',
    'alpha_num' => ':attribute deve conter apenas letras e números.',
    'array' => ':attribute deve ser um conjunto.',
    'before' => ':attribute deve ser uma data anterior: date.',
    'before_or_equal' => ':attribute deve ser uma data anterior ou igual a: date.',
    'between'              => [
        'numeric' => ':attribute deve estar entre: min -: max.',
        'file' => ':attribute deve pesar entre: min -: max kilobytes.',
        'string' => ':attribute deve ter entre: min -: max caracteres.',
        'array' => ':attribute deve ter entre: min -: max items.',
    ],
    'boolean' => 'O campo :attribute deve ter um valor verdadeiro ou falso.',
    'confirmed' => 'A confirmação de :attribute não combina.',
    'date' => ':attribute não é uma data válida.',
    'date_format' => ':attribute não corresponde ao formato: format.',
    'different' => ':attribute e : other devem ser diferentes.',
    'digits' => ':attribute deve ter: dígitos dígitos.',
    'digits_between' => ':attribute deve ter entre: min e: max digits.',
    'dimensions' => 'As dimensões da imagem :attribute não são válidas.',
    'distinct' => 'O campo :attribute contém um valor duplicado.',
    'email' => ':attribute não é um email válido',
    'exists' => ':attribute é inválido.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute é obrigatório.',
    'image' => ':attribute deve ser uma imagem.',
    'in' => ':attribute é inválido.',
    'in_array' => 'O campo :attribute não existe em: other.',
    'integer' => ':attribute deve ser um inteiro.',
    'ip' => ': o atributo deve ser um endereço IP válido.',
    'ipv4' => ':attribute deve ser um endereço IPv4 válido',
    'ipv6' => ':attribute deve ser um endereço IPv6 válido',
    'json' => 'O campo :attribute deve ter uma string JSON válida.',
    'max'                  => [
        'numeric' => '::attribute não deve ser maior que:max.',
        'file' => ':attribute não deve ser maior que :max kilobytes.',
        'string' => ':attribute não deve ser maior que :max caracteres.',
        'array' => ':attribute não deve ter mais que :max elements.',
    ],
    'mimes'                => ':attribute debe ser un archivo con formato: :values.',
    'mimetypes'            => ':attribute debe ser un archivo con formato: :values.',
    'min'                  => [
        'numeric' => 'O tamanho de :attribute deve ser pelo menos :min.', 
		'file' => 'O tamanho de :attribute deve ser pelo menos :min kilobytes.', 
		'string' => ' :attribute deve conter pelo menos :min. caracteres.', 
		'array' => ' :attribute deve ter pelo menos :min elements.',
    ],
    'not_in'               => ':attribute é inválido.',
    'numeric'             => ':attribute deve ser numérico.',
    'present'             => 'O campo :attribute deve estar presente',
    'regex'                => 'O formato de :attribute é inválido.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'O campo :attribute é obrigatório quando: o outro é: valor.',
    'required_unless'      => 'O campo :attribute é obrigatório a menos que: other esteja em: values.',
    'required_with'        => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_with_all'    => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without'     => 'O campo :attribute é obrigatório quando :values não estão presentes.',
    'required_without_all' => ':attribute field: é obrigatório quando nenhum dos valores: estiver presente.',
    'same' => ':attribute e: other must match.',
    'size'                 => [
        'numeric'  => 'O tamanho de :attribute deve ser :size'.,
         'file'     => 'O tamanho de :attribute deve ser :size kilobytes.',
         'string'   => ':attribute deve conter :size caracteres de tamanho.',
         'array'    => ':attribute deve conter :size elementos de tamanho'.,
    ],
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => ':attribute ya ha sido registrado.',
    'uploaded'             => 'Subir :attribute ha fallado.',
    'url'                  => 'El formato :attribute es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    

    'custom'               => [
        'password' => [
            'min' => ':attribute deve conter mais de :size caracteres ',
        ],
        'email' => [
            'unique' => 'O :attribute já foi registrado.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [        'name'                  => 'name',
        'username'              => 'user',
        'email'                 => 'email',
        'first_name'            => 'nome',
        'last_name'             => 'sobrenome',
        'password'              => 'password',
        'password_confirmation' => 'confirmação da senha',
        'city'                  => 'cidade',
        'country'               => 'país',
        'endereço'              => 'endereço',
        'telefone'              => 'telefone',
        'mobile'                => 'mobile',
        'age'                   => 'idade',
        'sex'                   => 'sexo',
        'gender'                => 'gender',
        'year'                  => 'ano',
        'month'                 => 'mês',
        'day'                   => 'day',
        'hour'                  => 'hora',
        'minute'                => 'minuto',
        'second'                => 'segundo',
        'title'                 => 'title',
        'conteúdo'              => 'conteúdo',
        'body'                   => 'conteúdo',
        'description'            => 'description',
        'trecho'                 => 'extrair',
        'date'                   => 'data',
        'time'                   => 'hora',
        'subject'                => 'assunto',
        'message'                 => 'menssagem',
    ],

];
