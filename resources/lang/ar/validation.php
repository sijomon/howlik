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
    
    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'email' => 'The :attribute must be a valid email address.',
    'exists' => 'The selected :attribute is invalid.',
    'filled' => 'The :attribute field is required.',
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'url' => 'The :attribute format is invalid.',
    
    "recaptcha" => 'The :attribute field is not correct.',
    
    
    // Blacklist - Whitelist
    'whitelist_email' => 'This email address is blacklisted.',
    'whitelist_domain' => 'The domain of your email address is blacklisted.',
    'whitelist_word' => 'The :attribute contains a banned words or phrases.',
    'whitelist_word_title' => 'The :attribute contains a banned words or phrases.',
    
    
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
        'gender' => [
            'required' => 'The gender is required.',
            'not_in' => 'The gender is required.',
        ],
        'first_name' => [
            'required' => 'Your first name is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ],
        'last_name' => [
            'required' => 'Your last name is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ],
        'user_type' => [
            'required' => 'The user type is required (Individual or Professional?).',
            'not_in' => 'The user type is required (Individual or Professional?).',
        ],
        'country' => [
            'required' => 'Your country is required.',
            'not_in' => 'Your country is required.',
        ],
        'phone' => [
            'required' => 'Your phone number is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'phone_number' => 'The :attribute must be a valid phone number.',
        ],
        'email' => [
            'required' => 'Your email address is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'between' => 'The :attribute must be between :min and :max characters.',
        ],
        'g-recaptcha-response' => [
            'required' => 'The captcha field is not correct.',
            'recaptcha' => 'The captcha field is not correct.',
        ],
        'term' => [
            'required' => 'Vous devez lire et accepter les conditions d\'utilisation du site',
            'accepted' => 'Vous devez lire et accepter les conditions d\'utilisation du site',
        ],
        'category' => [
            'required' => 'The category and sub-category are required.',
            'not_in' => 'The category and sub-category are required.',
        ],
        'ad_type' => [
            'required' => 'The ad type is required.',
            'not_in' => 'The ad type is required.',
        ],
        'title' => [
            'required' => 'The title is required.',
            'between' => 'The :attribute must be between :min and :max characters.',
        ],
        'description' => [
            'required' => 'The description is required.',
            'between' => 'The :attribute must be between :min and :max characters.',
        ],
        'price' => [
            'required' => 'The price is required.',
        ],
        'salary' => [
            'required' => 'The salary is required.',
        ],
        'resume' => [
            'required_if' => 'Your resume is required.',
            'mimes' => 'Your resume must in this formats: :mimes.',
        ],
        'seller_name' => [
            'required' => 'Your name is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ],
        'seller_email' => [
            'required_without' => 'Your email address is required.',
            'email' => 'The :attribute must be a valid email address.',
        ],
        'seller_phone' => [
            'required_without' => 'Your phone number is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'phone_number' => 'Your phone number is not valid.',
        ],
        'location' => [
            'required' => 'The region is required.',
            'not_in' => 'The region is required.',
        ],
        'city' => [
            'required' => 'The city is required.',
            'not_in' => 'The city is required.',
        ],
        'package' => [
            'required_with' => 'The package is required.',
            'not_in' => 'The package is required.',
        ],
        'payment_method' => [
            'required_if' => 'The payment method is required.',
            'not_in' => 'The payment method is required.',
        ],
        'sender_name' => [
            'required' => 'Your name is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ],
        'sender_email' => [
            'required' => 'Your email address is required.',
            'email' => 'The :attribute must be a valid email address.',
        ],
        'sender_phone' => [
            'required' => 'Your phone number is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'phone_number' => 'Your phone number is not valid.',
        ],
        'subject' => [
            'required' => 'The subject field is required.',
            'between' => 'The :attribute must be between :min and :max characters.',
        ],
        'message' => [
            'required' => 'The message field is required.',
            'between' => 'The :attribute must be between :min and :max characters.',
        ],
        'report_type' => [
            'required' => 'The raison is required.',
            'not_in' => 'The raison is required.',
        ],
        'report_sender_email' => [
            'required' => 'Your email address is required.',
            'email' => 'The :attribute must be a valid email address.',
        ],
        'report_message' => [
            'required' => 'The message field is required.',
            'between' => 'The :attribute must be between :min and :max characters.',
        ],
        'file' => [
            'required' => 'The pictures field are required.',
            'image' => 'The :attribute must be image.',
        ],
        'pictures.*' => [
            'required' => 'The pictures field are required.',
            'image' => 'The :attribute must be image.',
        ],
        'pictures.0' => [
            'required' => 'The pictures field are required.',
            'image' => 'The :attribute must be image.',
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

];
