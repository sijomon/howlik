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
    
    'accepted' => 'Le champ :attribute doit être accepté.',
    'active_url' => 'Le champ :attribute n\'est pas une adresse URL valide.',
    'after' => 'Le champ :attribute doit être une date ultérieure à :date.',
    'alpha' => 'Le champ :attribute ne peut contenir que des lettres.',
    'alpha_dash' => 'Le champ :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num' => 'Le champs :attribute ne peut contenir que des lettres et des chiffres.',
    'array' => 'Le champ :attribute doit être un array.',
    'before' => 'Le champ :attribute doit être une date antérieure à :date.',
    'between' => [
        'numeric' => 'Le champ :attribute doit être entre :min et :max.',
        'file' => 'Le fichier chargé dans le champ :attribute doit avoir une taille entre :min et :max ko.',
        'string' => 'Le champ :attribute doit avoir entre :min et :max caractères.',
        'array' => 'Le champ :attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation n\'est pas valide.',
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
    
    "recaptcha" => 'Le champ :attribute n\'est pas correcte.',
    
    
    // Blacklist - Whitelist
    'whitelist_email' => 'Cette adresse email est bannie du site.',
    'whitelist_domain' => 'Le domaine de votre adresse email est banni du site.',
    'whitelist_word' => 'Le champ :attribute contient des mots ou des expressions bannis.',
    'whitelist_word_title' => 'Le champ :attribute contient des mots ou des expressions bannis.',
    
    
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
            'required' => 'Vous devez sélectionner une civilité.',
            'not_in' => 'Vous devez sélectionner une civilité.',
        ],
        'first_name' => [
            'required' => 'Vous devez renseigner votre prénom.',
            'min' => 'Votre prénom doit avoir :min caractères minimum.',
            'max' => 'Votre prénom ne doit pas dépasser :max caractères.',
        ],
        'last_name' => [
            'required' => 'Vous devez renseigner votre nom de famille.',
            'min' => 'Votre nom doit avoir :min caractères minimum.',
            'max' => 'Votre nom de famille ne doit pas dépasser :max caractères.',
        ],
        'user_type' => [
            'required' => 'Vous devez devez spécifier si vous êtes un particulier ou un(e) professionnel(le).',
            'not_in' => 'Vous devez devez spécifier si vous êtes un particulier ou un(e) professionnel(le).',
        ],
        'country' => [
            'required' => 'Vous devez sélectionner votre pays.',
            'not_in' => 'Vous devez sélectionner votre pays.',
        ],
        'phone' => [
            'required' => 'Vous devez renseigner votre numéro de téléphone.',
            'min' => 'Votre numéro de téléphone doit avoir :min caractères minimum.',
            'max' => 'Votre numéro de téléphone ne doit pas dépasser :max caractères.',
            'phone_number' => 'Votre numéro de téléphone n\'est pas valide.',
        ],
        'email' => [
            'required' => 'Vous devez renseigner votre adresse email.',
            'email' => 'Votre adresse email n\'est pas valide.',
            'unique' => 'Cette adresse email est déjà utilisé par un autre utilisateur.',
        ],
        'password' => [
            'required' => 'Vous devez renseigner votre mot de passe.',
            'between' => 'Votre mot de passe doit avoir entre :min et :max caractères.',
        ],
        'g-recaptcha-response' => [
            'required' => 'Vous devez chocher le champs "Je ne suis pas un robot".',
            'recaptcha' => 'Vous devez chocher le champs "Je ne suis pas un robot".',
        ],
        'term' => [
            'required' => 'Vous devez lire et accepter les conditions d\'utilisation du site.',
            'accepted' => 'Vous devez lire et accepter les conditions d\'utilisation du site.',
        ],
        'category' => [
            'required' => 'Vous devez sélectionner une catégorie et une sous-catégorie.',
            'not_in' => 'Vous devez sélectionner une catégorie et une sous-catégorie.',
        ],
        'ad_type' => [
            'required' => 'Vous devez sélectionner le type d\'annonce.',
            'not_in' => 'Vous devez sélectionner le type d\'annonce.',
        ],
        'title' => [
            'required' => 'Vous devez donner un titre à votre annonce.',
            'between' => 'Le titre de votre annonce doit avoir entre :min et :max caractères.',
        ],
        'description' => [
            'required' => 'Vous devez donner une description à votre annonce.',
            'between' => 'La description de votre annonce doit avoir entre :min et :max caractères.',
        ],
        'price' => [
            'required' => 'Vous devez renseigner un prix sur votre annonce.',
        ],
        'salary' => [
            'required' => 'Vous devez renseigner un salaire sur votre annonce.',
        ],
        'resume' => [
            'required_if' => 'Vous devez ajouter votre CV à l\'annonce.',
            'mimes' => 'Votre CV doit être dans ces formats: :mimes.',
        ],
        'seller_name' => [
            'required' => 'Vous devez renseigner votre nom et prénom.',
            'min' => 'Votre nom et prénom doit avoir :min caractères minimum.',
            'max' => 'Votre nom et prénom ne doit pas dépasser :max caractères.',
        ],
        'seller_email' => [
            'required_without' => 'Vous devez renseigner votre adresse email.',
            'email' => 'Votre adresse email n\'est pas valide.',
        ],
        'seller_phone' => [
            'required_without' => 'Vous devez renseigner votre numéro de téléphone.',
            'min' => 'Votre numéro de téléphone doit avoir :min caractères minimum.',
            'max' => 'Votre numéro de téléphone ne doit pas dépasser :max caractères.',
            'phone_number' => 'Votre numéro de téléphone n\'est pas valide.',
        ],
        'location' => [
            'required' => 'Vous devez sélectionner votre région.',
            'not_in' => 'Vous devez sélectionner votre région.',
        ],
        'city' => [
            'required' => 'Vous devez sélectionner votre ville.',
            'not_in' => 'Vous devez sélectionner votre ville.',
        ],
        'package' => [
            'required_with' => 'Vous devez sélectionner un forfait.',
            'not_in' => 'Vous devez sélectionner un forfait.',
        ],
        'payment_method' => [
            'required_if' => 'Vous devez sélectionner un mode de paiement.',
            'not_in' => 'Vous devez sélectionner un mode de paiement.',
        ],
        'sender_name' => [
            'required' => 'Vous devez renseigner votre nom et prénom.',
            'min' => 'Votre nom et prénom doit avoir :min caractères minimum.',
            'max' => 'Votre nom et prénom ne doit pas dépasser :max caractères.',
        ],
        'sender_email' => [
            'required' => 'Vous devez renseigner votre adresse email.',
            'email' => 'Votre adresse email n\'est pas valide.',
        ],
        'sender_phone' => [
            'required' => 'Vous devez renseigner votre numéro de téléphone.',
            'min' => 'Votre numéro de téléphone doit avoir :min caractères minimum.',
            'max' => 'Votre numéro de téléphone ne doit pas dépasser :max caractères.',
            'phone_number' => 'Votre numéro de téléphone n\'est pas valide.',
        ],
        'subject' => [
            'required' => 'Vous devez renseigner un objet pour votre message.',
            'between' => 'L\'objet de votre message doit avoir entre :min et :max caractères.',
        ],
        'message' => [
            'required' => 'Vous devez ajouter un message.',
            'between' => 'Votre message doit avoir entre :min et :max caractères.',
        ],
        'report_type' => [
            'required' => 'Vous devez sélectionner la raison de votre signalement.',
            'not_in' => 'Vous devez sélectionner la raison de votre signalement.',
        ],
        'report_sender_email' => [
            'required' => 'Vous devez renseigner votre adresse email.',
            'email' => 'Votre adresse email n\'est pas valide.',
        ],
        'report_message' => [
            'required' => 'Vous devez ajouter un message.',
            'between' => 'Votre message doit avoir entre :min :max caractères.',
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
