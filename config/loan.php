<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sample Clients
    |--------------------------------------------------------------------------
    */
    'sample_clients' => [
        [
            'name' => 'Petr Pavel',
            'age' => 35,
            'region' => 'PR',
            'income' => 1500,
            'score' => 600,
            'pin' => '123-45-6789',
            'email' => 'petr.pavel@example.com',
            'phone' => '+420123456789',
        ],
        [
            'name' => 'Jan Novak',
            'age' => 45,
            'region' => 'OS',
            'income' => 2000,
            'score' => 700,
            'pin' => '234-56-7890',
            'email' => 'jan.novak@example.com',
            'phone' => '+420234567890',
        ],
        [
            'name' => 'Alena Svobodova',
            'age' => 28,
            'region' => 'BR',
            'income' => 700,
            'score' => 70,
            'pin' => '345-67-8901',
            'email' => 'alena.svobodova@example.com',
            'phone' => '+420345678901',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sample Loans
    |--------------------------------------------------------------------------
    */
    'sample_loans' => [
        [
            'name' => 'Personal Loan',
            'amount' => 1000,
            'rate' => 10,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'client_id' => 3,
            'is_approved' => true,
        ],
        [
            'name' => 'Car Loan',
            'amount' => 5000,
            'rate' => 8,
            'start_date' => '2024-01-01',
            'end_date' => '2026-12-31',
            'client_id' => 1,
            'is_approved' => false,
        ],
        [
            'name' => 'Mortgage',
            'amount' => 50000,
            'rate' => 5,
            'start_date' => '2024-01-01',
            'end_date' => '2044-12-31',
            'client_id' => 2,
            'is_approved' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Loan Rules
    |--------------------------------------------------------------------------
    */
    'rules' => [
        'min_score' => 500,
        'min_income' => 1000,
        'min_age' => 18,
        'max_age' => 60,
        'allowed_regions' => ['PR', 'BR', 'OS'],
        'prague_rejection_probability' => 0.3, // 30% rejection rate for Prague
        'ostrava_rate_increase' => 5, // 5% rate increase for Ostrava
    ],
];
