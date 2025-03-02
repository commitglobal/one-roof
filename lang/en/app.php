<?php

declare(strict_types=1);

return [

    'navigation' => [
        'activity' => 'Activity',
        'configurations' => 'Configurations',
    ],

    'field' => [
        'address' => 'Address',
        'admins' => 'Administrators',
        'capacity' => 'Capacity',
        'contact_person' => 'Contact person',
        'country' => 'Country',
        'created_at' => 'Created at',
        'description' => 'Description',
        'email' => 'Email',
        'fields' => 'Fields',
        'form_type' => 'Form type',
        'help' => 'Help text',
        'id' => 'ID',
        'identifier' => 'Identifier',
        'label' => 'Label',
        'legal_documents' => 'Legal documents',
        'legal_name' => 'Legal name',
        'legal_representative' => 'Legal representative',
        'location' => 'Location',
        'location' => 'Location',
        'logo' => 'Logo',
        'max_length' => 'Maximum length',
        'max_value' => 'Maximum value',
        'min_length' => 'Minimum length',
        'min_value' => 'Minimum value',
        'name' => 'Name',
        'notes' => 'Observations',
        'options' => 'Options',
        'organization_type' => 'Organization type',
        'phone' => 'Phone',
        'required' => 'Required',
        'section_name' => 'Section name',
        'sections' => 'Sections',
        'shelter_coordinator' => 'Shelter coordinator',
        'shelters' => 'Shelters',
        'status' => 'Status',
        'type' => 'Type',
        'updated_at' => 'Updated at',
    ],

    'field_help' => [
        'one_per_line' => 'Add one item per line.',
        'zero_to_disable' => 'To remove the limit, set this field to 0.',
    ],

    'country' => [
        'label' => [
            'singular' => 'country',
            'plural' => 'countries',
        ],
    ],

    'location' => [
        'label' => [
            'singular' => 'location',
            'plural' => 'locations',
        ],
    ],

    'form' => [
        'label' => [
            'singular' => 'form',
            'plural' => 'forms',
        ],

        'type' => [
            'personal' => 'Personal details',
            'request' => 'Request form',
        ],

        'status' => [
            'draft' => 'Draft',
            'published' => 'Published',
            'obsolete' => 'Obsolete',
        ],

        'actions' => [
            'draft' => [
                'button' => 'Draft',
                'confirm' => [
                    'description' => 'Are you sure you want to mark this form as draft?',
                    'title' => 'Mark as draft',
                    'success' => 'Form marked as draft successfully.',
                ],
            ],
            'publish' => [
                'button' => 'Publish',
                'confirm' => [
                    'description' => 'Are you sure you want to publish this form?',
                    'title' => 'Publish form',
                    'success' => 'Form published successfully.',
                ],
            ],
            'obsolete' => [
                'button' => 'Obsolete',
                'confirm' => [
                    'description' => 'Are you sure you want to mark this form as obsolete?',
                    'title' => 'Mark as obsolete',
                    'success' => 'Form marked as obsolete successfully.',
                ],
            ],
        ],
    ],

    'form_field' => [
        'checkbox' => 'Checkbox',
        'date' => 'Date',
        'email' => 'Email',
        'number' => 'Number',
        'radio' => 'Radio',
        'select' => 'Select',
        'text' => 'Text',
        'textarea' => 'Textarea',
        'url' => 'URL',
    ],

    'organization' => [
        'label' => [
            'singular' => 'organization',
            'plural' => 'organizations',
        ],

        'type' => [
            'ingo' => 'INGO',
            'ngo' => 'NGO',
            'public' => 'Public institution',
        ],

        'steps' => [
            'details' => 'Organization details',
            'shelters' => 'Shelters',
            'admins' => 'Admins',
        ],

        'actions' => [
            'activate' => [
                'button' => 'Activate',
                'confirm' => [
                    'description' => 'Are you sure you want to activate this organization?',
                    'title' => 'Activate organization',
                    'success' => 'Organization activated successfully.',
                ],
            ],
            'deactivate' => [
                'button' => 'Deactivate',
                'confirm' => [
                    'description' => 'Are you sure you want to deactivate this organization?',
                    'title' => 'Deactivate organization',
                    'success' => 'Organization deactivated successfully.',
                ],
            ],
        ],
    ],

    'user' => [
        'label' => [
            'singular' => 'user',
            'plural' => 'users',
        ],

        'role' => [
            'super_admin' => 'Super admin',
            'super_user' => 'Super user',
            'shelter_admin' => 'Shelter admin',
            'shelter_user' => 'Shelter user',
        ],
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
    ],
];
