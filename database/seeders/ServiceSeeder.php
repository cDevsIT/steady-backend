<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\ServiceForm;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Annual Compliance with the State',
                'description' => 'Maintain 100% Compliance with the State',
                'initial_price' => 99.00,
                'renewal_fee' => 99.00,
                'transfer_fee' => 0.00,
                'renewal_period' => 12,
                'purchase_type' => 'recurring',
                'is_active' => true,
                'is_renewable' => true,
                'auto_renewal' => true,
                'visible_on_funnel' => false,
                'is_transferable' => false,
                'requires_state_selection' => true,
                'requires_state_fees' => true,
                'is_for_address' => false,
                'features' => [
                    '100% Compliant with the State'
                ],
                'forms' => [
                    [
                        'form_type' => 'user_information',
                        'title' => 'User Information Form',
                        'description' => 'Collect customer personal information',
                        'icon' => 'fas fa-user',
                        'is_required' => true
                    ],
                    [
                        'form_type' => 'providable_information',
                        'title' => 'Providable Information Form',
                        'description' => 'Service-specific information requirements',
                        'icon' => 'fas fa-info-circle',
                        'is_required' => true
                    ],
                    [
                        'form_type' => 'quotation',
                        'title' => 'Quotation Form',
                        'description' => 'Generate service quotes and estimates',
                        'icon' => 'fas fa-file-invoice-dollar',
                        'is_required' => true
                    ]
                ]
            ],
            [
                'name' => 'Business Bank Account Setup',
                'description' => 'Professional business bank account setup with all necessary documentation',
                'initial_price' => 199.00,
                'renewal_fee' => 0.00,
                'transfer_fee' => 0.00,
                'renewal_period' => 0,
                'purchase_type' => 'one_time',
                'is_active' => true,
                'is_renewable' => false,
                'auto_renewal' => false,
                'visible_on_funnel' => true,
                'is_transferable' => false,
                'requires_state_selection' => false,
                'requires_state_fees' => false,
                'is_for_address' => false,
                'features' => [
                    'Professional account setup',
                    'All necessary documentation',
                    'Bank liaison support',
                    'Account verification assistance'
                ],
                'forms' => [
                    [
                        'form_type' => 'user_information',
                        'title' => 'Business Information Form',
                        'description' => 'Collect business details and owner information',
                        'icon' => 'fas fa-building',
                        'is_required' => true
                    ]
                ]
            ],
            [
                'name' => 'Business Dissolution',
                'description' => 'Complete business dissolution service with state compliance',
                'initial_price' => 399.00,
                'renewal_fee' => 0.00,
                'transfer_fee' => 0.00,
                'renewal_period' => 0,
                'purchase_type' => 'one_time',
                'is_active' => true,
                'is_renewable' => false,
                'auto_renewal' => false,
                'visible_on_funnel' => false,
                'is_transferable' => false,
                'requires_state_selection' => true,
                'requires_state_fees' => true,
                'is_for_address' => false,
                'features' => [
                    'Complete dissolution filing',
                    'State compliance guarantee',
                    'Asset distribution guidance',
                    'Tax clearance assistance'
                ],
                'forms' => [
                    [
                        'form_type' => 'user_information',
                        'title' => 'Business Details Form',
                        'description' => 'Collect business and ownership information',
                        'icon' => 'fas fa-clipboard-list',
                        'is_required' => true
                    ],
                    [
                        'form_type' => 'providable_information',
                        'title' => 'Dissolution Information Form',
                        'description' => 'Service-specific dissolution requirements',
                        'icon' => 'fas fa-file-alt',
                        'is_required' => true
                    ]
                ]
            ],
            [
                'name' => 'EIN Registration Service',
                'description' => 'Federal Tax ID (EIN) registration and setup',
                'initial_price' => 49.00,
                'renewal_fee' => 0.00,
                'transfer_fee' => 0.00,
                'renewal_period' => 0,
                'purchase_type' => 'one_time',
                'is_active' => true,
                'is_renewable' => false,
                'auto_renewal' => false,
                'visible_on_funnel' => true,
                'is_transferable' => false,
                'requires_state_selection' => false,
                'requires_state_fees' => false,
                'is_for_address' => false,
                'features' => [
                    'Fast EIN processing',
                    'IRS compliance guarantee',
                    'Digital delivery',
                    'Support included'
                ],
                'forms' => [
                    [
                        'form_type' => 'user_information',
                        'title' => 'EIN Application Form',
                        'description' => 'Collect information for EIN application',
                        'icon' => 'fas fa-id-card',
                        'is_required' => true
                    ]
                ]
            ],
            [
                'name' => 'Registered Agent Service',
                'description' => 'Professional registered agent service for your business',
                'initial_price' => 149.00,
                'renewal_fee' => 149.00,
                'transfer_fee' => 25.00,
                'renewal_period' => 12,
                'purchase_type' => 'recurring',
                'is_active' => true,
                'is_renewable' => true,
                'auto_renewal' => true,
                'visible_on_funnel' => true,
                'is_transferable' => true,
                'requires_state_selection' => true,
                'requires_state_fees' => false,
                'is_for_address' => true,
                'features' => [
                    'Professional registered agent',
                    'Mail forwarding service',
                    'Compliance monitoring',
                    'Document delivery'
                ],
                'forms' => [
                    [
                        'form_type' => 'user_information',
                        'title' => 'Agent Information Form',
                        'description' => 'Collect business and contact information',
                        'icon' => 'fas fa-user-tie',
                        'is_required' => true
                    ]
                ]
            ]
        ];

        foreach ($services as $serviceData) {
            $features = $serviceData['features'];
            $forms = $serviceData['forms'];
            unset($serviceData['features'], $serviceData['forms']);

            $service = Service::create($serviceData);

            // Create features
            foreach ($features as $feature) {
                ServiceFeature::create([
                    'service_id' => $service->id,
                    'feature' => $feature,
                ]);
            }

            // Create forms
            foreach ($forms as $form) {
                ServiceForm::create([
                    'service_id' => $service->id,
                    'form_type' => $form['form_type'],
                    'title' => $form['title'],
                    'description' => $form['description'],
                    'icon' => $form['icon'],
                    'is_required' => $form['is_required'],
                ]);
            }
        }
    }
}