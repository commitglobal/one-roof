<?php

declare(strict_types=1);

return [

    'navigation' => [
        'activity' => 'Activity',
        'configurations' => 'Configurations',
    ],

    'field' => [
        'address' => 'Address',
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
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
    ],
];
