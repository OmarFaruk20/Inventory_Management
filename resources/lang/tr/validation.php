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

    'accepted'             => ':attribute Kabul edilmeli.',
    'active_url'           => ':attribute Geçerli bir URL değil.',
    'after'                => ':attribute :date tarihinden sonra olmalı.',
    'after_or_equal'       => ':attribute :date tarihinden sonra veya eşit olmalı.',
    'alpha'                => ':attribute Sadece harfler içerebilir.',
    'alpha_dash'           => ':attribute Sadece harfler, rakamlar ve kısa çizgiler semboller içerebilir.',
    'alpha_num'            => ':attribute Sadece harf ve rakam içerebilir.',
    'array'                => ':attribute Bir dizi olmalı.',
    'before'               => ':attribute :date tarihinden önce olmalı.',
    'before_or_equal'      => ':attribute :date tarihinden önce veya eşit olmalı.',
    'between'              => [
        'numeric' => ':attribute Belirtilen aralıkta olmalı :min ve :max.',
        'file'    => ':attribute Belirtilen aralıkta olmalı :min ve :max kilobyte.',
        'string'  => ':attribute Belirtilen aralıkta olmalı :min ve :max karakter.',
        'array'   => ':attribute Belirtilen aralıkta olmalı :min ve :max öğeler.',
    ],
    'boolean'              => ':attribute Alan doğru(true) veya yanlış(false) olmalı.',
    'confirmed'            => ':attribute Onay uyuşmuyor.',
    'date'                 => ':attribute Geçerli tarih değil.',
    'date_format'          => ':attribute Uyuşmayan format :format.',
    'different'            => ':attribute ve :other farklı olmalı.',
    'digits'               => ':attribute Bu değer :digits sayı olmalı.',
    'digits_between'       => ':attribute Aralığı :min ve :max arasında bir sayı olmalıdır.',
    'dimensions'           => ':attribute Geçersiz resim boyutları var.',
    'distinct'             => ':attribute Alanın yinelenen bir değeri var.',
    'email'                => ':attribute Geçerli bir e-posta adresi olmalı.',
    'exists'               => 'Seçilen :attribute geçersiz.',
    'file'                 => ':attribute Bir dosya olmalı.',
    'filled'               => ':attribute Alanın bir değeri olmalı.',
    'image'                => ':attribute Bir resim olmalı.',
    'in'                   => 'Seçilen :attribute geçersiz.',
    'in_array'             => ':attribute  :other içinde alan yok.',
    'integer'              => ':attribute Tam sayı olmak zorunda.',
    'ip'                   => ':attribute Geçerli bir IP adresi olmak zorunda.',
    'ipv4'                 => ':attribute Geçerli bir IPv4 adresi olmak zorunda.',
    'ipv6'                 => ':attribute Geçerli bir IPv6 adresi olmak zorunda.',
    'json'                 => ':attribute Geçerli bir JSON string olmalı.',
    'max'                  => [
        'numeric' => ':attribute  :max Bu değerden daha büyük olamaz.',
        'file'    => ':attribute  :max kilobyte değerinden daha büyük olamaz.',
        'string'  => ':attribute  :max karakter değerinden daha büyük olamaz.',
        'array'   => ':attribute  :max Öğelerden daha fazla olmayabilir.',
    ],
    'mimes'                => ':attribute Bu türde bir dosya olmalı: :values.',
    'mimetypes'            => ':attribute Bu türde bir dosya olmalı: :values.',
    'min'                  => [
        'numeric' => ':attribute en azından :min olmalı.',
        'file'    => ':attribute en azından :min kilobyte olmalı.',
        'string'  => ':attribute en azından :min karakter olmalı.',
        'array'   => ':attribute en azıdnan :min öğe olmalı.',
    ],
    'not_in'               => 'Seçilen :attribute geçersiz.',
    'numeric'              => ':attribute Bir sayı olmalı.',
    'present'              => ':attribute alanı mevcut olmalıdır.',
    'regex'                => ':attribute Geçersiz format.',
    'required'             => ':attribute gerekli alan.',
    'required_if'          => ':attribute :other , :value olduğunda Alan gereklidir.',
    'required_unless'      => ':attribute :other , :values olmadıkça Alan gereklidir.',
    'required_with'        => ':attribute :values mevcut olduğunda alan gereklidir.',
    'required_with_all'    => ':attribute :values mevcut olduğunda alan gereklidir.',
    'required_without'     => ':attribute :values mevcut değilse alan gereklidir.',
    'required_without_all' => ':attribute :values hiçbiri mevcut değilse alan gereklidir..',
    'same'                 => ':attribute ve :other eşleşmeli.',
    'size'                 => [
        'numeric' => ':attribute :size Olmalıdır.',
        'file'    => ':attribute :size Kilobyte olmalıdır.',
        'string'  => ':attribute :size Karakter olmalıdır.',
        'array'   => ':attribute :size Öğe içermelidir.',
    ],
    'string'               => ':attribute Bir string olmalı.',
    'timezone'             => ':attribute Geçerli bir bölge olmalı.',
    'unique'               => ':attribute Daha önceden alındı.',
    'uploaded'             => ':attribute Yüklenirken hata oluştu.',
    'url'                  => ':attribute Geçersiz Format.',

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
            'rule-name' => 'özel mesaj',
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

    'attributes' => [],
    'custom-messages' => [
        'quantity_not_available' => 'Sadece  :qty :unit uygun',
        'this_field_is_required' => 'Bu alan gereklidir'
    ],

];
