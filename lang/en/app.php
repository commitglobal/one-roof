<?php

declare(strict_types=1);

return [

    'navigation' => [
        'activity' => 'Activity',
        'configurations' => 'Configurations',
    ],

    'yes' => 'Yes',
    'no' => 'No',

    'field' => [
        'address' => 'Address',
        'admins' => 'Administrators',
        'capacity' => 'Capacity',
        'children_count' => 'Number of children',
        'children_notes' => 'Observations about children',
        'code' => 'Code',
        'contact_person' => 'Contact person',
        'country' => 'Country',
        'create_beneficiary_consent' => 'I confirm that I have obtained the individual\'s consent and authorize the collection and processing of their personal data in accordance with the Privacy Policy. The data will be used solely for providing shelter and support services, ensuring safety, and complying with legal requirements.',
        'create_beneficiary_search' => 'Search for an existing beneficiary',
        'created_at' => 'Created at',
        'date_of_birth' => 'Date of birth',
        'description' => 'Description',
        'document_name' => 'Document name',
        'document_type' => 'Document type',
        'document' => 'Document',
        'email' => 'Email',
        'enabled' => 'Enabled',
        'end_date' => 'End date',
        'fields' => 'Fields',
        'form_type' => 'Form type',
        'gender' => 'Gender',
        'has_children' => 'Accompanied by children',
        'help' => 'Help text',
        'id_number' => 'ID number',
        'id_type' => 'ID type',
        'id' => 'ID',
        'identifier' => 'Identifier',
        'label' => 'Label',
        'latest_stay' => 'Latest stay',
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
        'nationality' => 'Nationality',
        'native_name' => 'Native name',
        'not_applicable' => 'Not applicable',
        'notes' => 'Observations',
        'options' => 'Options',
        'organization_type' => 'Organization type',
        'phone' => 'Phone',
        'photo' => 'Photo',
        'required' => 'Required',
        'residence_country' => 'Residence country',
        'section_name' => 'Section name',
        'sections' => 'Sections',
        'shelter_coordinator' => 'Shelter coordinator',
        'shelter' => 'Shelter',
        'shelters' => 'Shelters',
        'start_date' => 'Start date',
        'status' => 'Status',
        'type' => 'Type',
        'updated_at' => 'Updated at',
        'upload_document' => 'Upload document',
    ],

    'placeholder' => [
        'create_beneficiary_search' => 'Start typing to search a beneficiary...',
    ],

    'field_help' => [
        'one_per_line' => 'Add one item per line.',
        'zero_to_disable' => 'To remove the limit, set this field to 0.',
        'create_beneficiary_search' => 'If this beneficiary has previously stayed with you, or if the beneficiary has stayed in a different shelter in the system, search for their name or ID in the field above to retrieve personal data. If this is a new beneficiary, check the box below and move on to the next step.',
    ],

    'beneficiary' => [
        'label' => [
            'singular' => 'beneficiary',
            'plural' => 'beneficiaries',
        ],

        'steps' => [
            'consent' => 'Consent',
            'identification' => 'Identification',
            'personal_details' => 'Personal details',
            'stay' => 'Stay',
        ],
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

    'language' => [
        'label' => [
            'singular' => 'language',
            'plural' => 'languages',
        ],
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
    ],

    'gender' => [
        'male' => 'Male',
        'female' => 'Female',
        'nonbinary' => 'Non-binary',
        'other' => 'Prefer not to say',
    ],

    'id_type' => [
        'passport' => 'Passport',
        'national_id_card' => 'National ID Card',
        'drivers_license' => 'Driver’s License',
        'residence_permit' => 'Residence Permit',
        'other' => 'Other',
        'none' => 'None',
    ],

    'documents' => [
        'label' => [
            'singular' => 'document',
            'plural' => 'documents',
        ],

        'actions' => [
            'delete' => 'Delete document',
            'edit' => 'Edit details',
            'download' => 'Download',
        ],

        'type' => [
            'passport' => 'Passport',
            'national_id_card' => 'National ID card',
            'birth_certificate' => 'Birth certificate',
            'drivers_license' => 'Driver’s license',
            'refugee_certificate' => 'Refugee or asylum seeker certificate',
            'residence_permit' => 'Residence permit',
            'work_permit' => 'Work permit',
            'travel_documents' => 'Travel documents for displaced persons',
            'court_orders' => 'Court orders (e.g., guardianship or custody papers)',
            'vaccination_records' => 'Vaccination records',
            'medical_history' => 'Medical history or health reports',
            'disability_certification' => 'Disability certification',
            'prescriptions' => 'Prescriptions for ongoing medical treatment',
            'marriage_certificate' => 'Marriage certificate',
            'death_certificate' => 'Death certificate of a family member',
            'proof_of_guardianship' => 'Proof of guardianship for minors',
            'proof_of_income' => 'Proof of income',
            'social_security_documents' => 'Social security or welfare assistance documents',
            'bank_account_details' => 'Bank account details',
            'previous_address' => 'Previous address or proof of residence',
            'relocation_approval' => 'Relocation or resettlement approval letters',
            'referral_letters' => 'Referral letters from other shelters or organizations',
            'other' => 'Other',
        ],

        'empty_state' => [
            'no_file' => [
                'header' => 'No document uploaded',
                'description' => 'Upload a document to view it here.',
            ],
            'no_preview' => [
                'header' => 'This document type does not allow previews',
                'description' => 'Download the document to view it.',
            ],

        ],
    ],

];
