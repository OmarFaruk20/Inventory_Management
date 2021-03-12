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

    'accepted' => 'يجب قبول الحقل attribute:.',
    'active_url' => "الحقل attribute: ليست عنوان URL صالحًا.",
    'after' => 'يجب أن يكون الحقل attribute: تاريخًا بعد date:.',
    'after_or_equal' => 'يجب أن يكون الحقل attribute: تاريخًا متأخرًا عن أو يساوي date:.',
    'alpha' => 'يجب أن يحتوي الحقل attribute: على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي حقل attribute: على أحرف وأرقام وواصلات فقط.',
    'alpha_num' => 'يجب أن يحتوي الحقل attribute: على أرقام وحروف فقط.',
    'array' => 'يجب أن يكون الحقل attribute: مصفوفة.',
    'before' => 'يجب أن يكون الحقل attribute: تاريخًا قبل: date:.',
    'before_or_equal' => 'يجب أن يكون الحقل attribute: تاريخًا أقدم من أو يساوي: date:.',
    'between' => [
        'numeric' => 'يجب أن تتراوح قيمة attribute: بين min: و max:.',
        'file' => 'يجب أن يكون حجم ملف attribute: بين min: و max: كيلوبايت .',
        'string' => 'يجب أن يحتوي النص بين min: و max: حرف.',
        'array' => 'يجب أن تتضمن المصفوفة attribute: بين min: و max: عنصر.',
    ],
    'boolean' => 'يجب أن تكون خاصية الحقل attribute: صحيح أو خطأ.',
    'confirmed' => 'حقل التأكيد attribute: لا يتطابق.',
    'date' => "الحقل attribute: ليس تاريخًا صالحًا.",
    'date_format' => 'لا يتطابق الحقل attribute: مع التنسيق format:.',
    'different' => 'الحقول attribute: و other: يجب أن تكون مختلفة.',
    'digits' => 'يجب أن يحتوي الحقل  على digits: رقم(أرقام).',
    'digits_between' => 'يجب أن يحتوي الحقل  بين min: و max:  رقم(أرقام).',
    'dimensions' => "حجم الصورة attribute: غير متوافقة.",
    'distinct' => 'يحتوي الحقل attribute: على قيمة مكررة.',
    'email' => 'يجب أن يكون الحقل attribute: عنوان بريد إلكتروني صالحًا.',
    'exists' => 'الحقل attribute: المحدد غير صالح.',
    'file' => 'يجب أن يكون الحقل attribute: ملفًا.',
    'filled' => 'يجب أن يحتوي الحقل attribute: على قيمة.',
    'image' => 'يجب أن يكون الحقل attribute: صورة.',
    'in' => 'الحقل attribute: غير صالح.',
    'in_array' => "الحقل attribute: غير موجود في other:.",
    'integer' => 'يجب أن يكون الحقل attribute: عددًا صحيحًا.',
    'ip' => 'يجب أن يكون الحقل attribute: عنوان IP صالح.',
    'ipv4' => 'يجب أن يكون الحقل attribute: عنوان IPv4 صالح.',
    'ipv6' => 'يجب أن يكون الحقل attribute: عنوان IPv6 صالح.',
    'json' => 'يجب أن يكون الحقل attribute: مستند JSON صالحً.',
    'max' => [
        'numeric' => 'لا يمكن أن تكون قيمة attribute: أكبر من max:.',
        'file' => 'لا يمكن أن يتعدى حجم الملف attribute: (السمة القصوى) max: كيلوبايت .',
        'string' => 'لا يمكن أن يحتوي النص attribute: على أكثر من max: حرف(أحرف).',
        'array' => 'لا يمكن أن تحتوي المصفوفة attribute: على أكثر من max: عنصر.',
    ],
    'mimes' => 'يجب أن يكون الحقل attribute: ملفًا من نوع values:.',
    'mimetypes' => 'يجب أن يكون الحقل attribute: ملفًا من نوع values:.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة attribute: أكبر من أو تساوي min:.',
        'file' => 'يجب أن يكون حجم ملف attribute: أكبر من min: كيلوبايت.',
        'string' => 'يجب أن يحتوي النص  على الأقل min: حرف(أحرف).',
        'array' => 'يجب أن تحتوي المصفوفة attribute: على الأقل min: عنصر(عناصر).',
    ],
    'not_in' => "الحقل attribute: المحدد غير صالح.",
    'numeric' => 'يجب أن يحتوي الحقل attribute: على رقم.',
    'present' => 'يجب أن يكون الحقل attribute: موجود.',
    'regex' => 'نسق الحقل attribute: غير صالح.',
    'required' => 'الحقل  إلزامي.',
    'required_if' => 'الحقل attribute: إلزامي عندما تكون قيمة other: هي value:.',
    'required_unless' => 'الحقل attribute: إلزامي ما لم other: هو values:.',
    'required_with' => 'الحقل attribute: إلزامي عندما تكون values: موجودة.',
    'required_with_all' => 'الحقل attribute: إلزامي عندما تكون values: موجودة',
    'required_without' => "الحقل attribute: إلزامي عندما تكون values: غير موجودة",
    'required_without_all' => "الحقل attribute: إلزامي عندما تكون values: غير موجودة",
    'same' => 'الحقول attribute: و other: يجب أن تكون هي نفسها.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة attribute: هي size:.',
        'file' => 'يجب أن يكون حجم ملف attribute: هو size: كيلوبايت.',
        'string' => 'يجب أن يحتوي النص attribute: على size: حرف(أحرف).',
        'array' => 'يجب أن تحتوي المصفوفة attribute: على size: عنصر(عناصر).',
    ],
    'string' => 'يجب أن يكون الحقل attribute: سلسلة من الأحرف.',
    'timezone' => 'يجب أن يكون الحقل attribute: منطقة زمنية صالحة.',
    'unique' => 'قيمة الحقل attribute: مستخدمة بالفعل.',
    'uploaded' => "ملف الحقل attribute: لا يمكن تحميله",
    'url' => "نسق عنوان URL لـ attribute: غير صالح.",

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

    'attributes' => [
        'name' => 'الإسم',
        'username' => "إسم المستخدم",
        'email' => 'عنوان البريد الالكتروني',
        'first_name' => 'الإسم',
        'last_name' => 'الإسم العائلي',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'phone' => 'الهاتف',
        'mobile' => 'المحمول',
        'age' => 'السن',
        'sex' => 'الجنس',
        'gender' => 'النوع',
        'day' => 'يوم',
        'month' => 'شهر',
        'year' => 'عام',
        'hour' => 'ساعة',
        'minute' => 'دقيقة',
        'second' => 'ثانية',
        'title' => 'العنوان',
        'content' => 'المحتوى',
        'description' => 'الوصف',
        'excerpt' => 'مقتطف',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'متاح',
        'size' => 'الحجم',
    ],
];
