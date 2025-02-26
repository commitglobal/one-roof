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
        'email' => 'Email',
        'id' => 'ID',
        'identifier' => 'Identifier',
        'legal_documents' => 'Legal documents',
        'legal_name' => 'Legal name',
        'legal_representative' => 'Legal representative',
        'location' => 'Location',
        'logo' => 'Logo',
        'name' => 'Name',
        'notes' => 'Observations',
        'organization_type' => 'Organization type',
        'phone' => 'Phone',
        'shelter_coordinator' => 'Shelter coordinator',
        'shelters' => 'Shelters',
        'status' => 'Status',
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

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
    ],
];
