<?php

declare(strict_types=1);

return [
    'navigation' => [
        'activity' => 'Activity',
        'configurations' => 'Configurations',
        'shelter_configuration' => 'Shelter configuration',
        'manual' => 'Manual',
    ],
    'developed_by' => 'Developed by',
    'yes' => 'Yes',
    'no' => 'No',
    'submit' => 'Submit',
    'more_actions' => 'More actions',
    'add_another' => 'Add another',
    'field' => [
        'active' => 'Active',
        'address' => 'Address',
        'admins' => 'Administrators',
        'age' => 'Age',
        'all_time_beneficiaries' => 'All time beneficiaries',
        'beneficiary' => 'Beneficiary',
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
        'departure_country' => 'Departure country',
        'description' => 'Description',
        'document_name' => 'Document name',
        'document_type' => 'Document type',
        'document' => 'Document',
        'email' => 'Email',
        'enabled' => 'Enabled',
        'end_date' => 'End date',
        'fields' => 'Fields',
        'form_sections' => 'Form sections',
        'form_type' => 'Form type',
        'gender' => 'Gender',
        'group_name' => 'Group name',
        'group_members' => 'Members',
        'group_size' => 'No.',
        'group' => 'Group',
        'has_children' => 'Accompanied by children',
        'has_group' => 'The beneficiary is part of a group',
        'has_request' => 'The stay is linked to an existing request',
        'help' => 'Help text',
        'id_number' => 'ID number',
        'id_type' => 'ID type',
        'id' => 'ID',
        'identifier' => 'Identifier',
        'is_indefinite' => 'Indefinite end date',
        'is_listed' => 'Listed',
        'label' => 'Label',
        'latest_stay' => 'Latest stay',
        'legal_documents' => 'Legal documents',
        'legal_name' => 'Legal name',
        'legal_representative' => 'Legal representative',
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
        'occupancy' => 'Occupancy',
        'options' => 'Options',
        'order' => 'Order',
        'organization_type' => 'Organization type',
        'organization' => 'Organization',
        'phone' => 'Phone',
        'photo' => 'Photo',
        'reason_rejected' => 'Reason rejected',
        'referral_notes' => 'Referral notes',
        'registration_date' => 'Registration date',
        'request_group' => 'Request for a group',
        'request_shelter' => 'Where do you seek accommodation?',
        'request_somebody_else' => 'Request for somebody else',
        'request' => 'Request',
        'requester' => 'Requester',
        'required' => 'Required',
        'residence_country' => 'Residence country',
        'section_name' => 'Section name',
        'sections' => 'Sections',
        'shelter_coordinator' => 'Shelter coordinator',
        'shelter' => 'Shelter',
        'shelters' => 'Shelters',
        'special_needs_notes' => 'Details about special needs',
        'special_needs' => 'Special needs',
        'start_date' => 'Start date',
        'status' => 'Status',
        'stay' => 'Stay',
        'type' => 'Type',
        'updated_at' => 'Updated at',
        'upload_document' => 'Upload document',
        'usage' => 'Usage',
        'variable_name' => 'Variable name',
        'variables' => 'Variables',
    ],
    'filters' => [
        'date_from' => 'From date',
        'date_until' => 'Until date',
    ],
    'placeholder' => [
        'create_beneficiary_search' => 'Start typing to search for a beneficiary…',
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
    'stay' => [
        'label' => [
            'singular' => 'stay',
            'plural' => 'stays',
        ],
        'indefinite' => 'Indefinite',
        'details' => 'Stay details',
        'actions' => [
            'extend' => [
                'button' => 'Extend stay',
                'confirm' => [
                    'description' => 'Extend a beneficiary\'s stay by updating the end date.',
                    'title' => 'Extend stay :title',
                    'success' => 'Stay extended successfully.',
                ],
            ],
        ],
    ],
    'group' => [
        'label' => [
            'singular' => 'group',
            'plural' => 'groups',
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
            'history' => 'Form history',
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
    'shelter' => [
        'label' => [
            'singular' => 'shelter',
            'plural' => 'shelters',
        ],
        'profile' => 'Profile',
        'actions' => [
            'list' => [
                'button' => 'List shelter',
                'confirm' => [
                    'description' => 'Once a shelter is listed, it will be displayed in the public request form and in the referral process. In order to eliminate the shelter from these lists, it needs to be unlisted.',
                    'title' => 'List shelter',
                    'success' => 'Shelter listed successfully.',
                ],
            ],
            'unlist' => [
                'button' => 'Unlist shelter',
                'confirm' => [
                    'description' => 'Once a shelter is unlisted, it will no longer be displayed in the public request form or in the referral process. To include the shelter in these lists again, it needs to be listed.',
                    'title' => 'Unlist shelter',
                    'success' => 'Shelter unlisted successfully.',
                ],
            ],
        ],
        'empty_state' => [
            'header' => 'No shelter found',
            'description' => 'Please try again with a different filter.',
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
        'actions' => [
            'select' => 'Select language',
        ],
    ],
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
    ],
    'gender' => [
        'man' => 'Man',
        'woman' => 'Woman',
        'trans_man' => 'Transgender man',
        'trans_woman' => 'Transgender woman',
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
    'stats' => [
        'overview' => [
            'available_places' => 'Total available places',
            'beneficiaries_in_shelter' => 'Total beneficiaries in the shelter',
            'beneficiaries' => 'Total hosted beneficiaries',
            'organizations' => 'Total organizations',
            'shelters' => 'Total shelters',
            'average_capacity' => 'Average shelter capacity',
            'total_capacity' => 'Total shelter capacity',
            'total_occupancy' => 'Total current occupancy',
        ],
        'beneficiaries' => [
            'nationalities' => 'Total beneficiaries per nationality',
            'residencies' => 'Total beneficiaries per country of residence',
            'genders' => 'Total beneficiaries per gender',
        ],
    ],
    'request' => [
        'label' => [
            'singular' => 'request',
            'plural' => 'requests',
        ],
        'status' => [
            'new' => 'New',
            'referred' => 'Referred',
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'obsolete' => 'Obsolete',
            'duplicate' => 'Duplicate',
        ],
        'referred_by' => 'This request was referred by :name.',
        'sent' => [
            'title' => 'Request submitted successfully.',
            'message' => 'Your request has been submitted successfully.',
        ],
        'actions' => [
            'add' => 'Add request',
            'accept' => 'Accept request',
            'accept' => [
                'button' => 'Accept request',
                'confirm' => [
                    'description' => 'Are you sure you want to accept this request?',
                    'title' => 'Accept request',
                    'success' => 'Request accepted successfully.',
                ],
            ],
            'refer' => [
                'button' => 'Refer request',
                'confirm' => [
                    'description' => 'Are you sure you want to refer this request to the ":shelter" shelter?',
                    'title' => 'Refer request #:request',
                    'success' => 'Request referred successfully to the ":shelter" shelter.',
                ],
            ],
            'reject' => [
                'button' => 'Reject request',
                'confirm' => [
                    'description' => 'Are you sure you want to reject this request?',
                    'title' => 'Reject request',
                    'success' => 'Request rejected successfully.',
                ],
            ],
            'pending' => [
                'button' => 'Mark as pending',
                'confirm' => [
                    'description' => 'Are you sure you want to mark this request as pending?',
                    'title' => 'Mark as pending',
                    'success' => 'Request marked as pending successfully.',
                ],
            ],
            'obsolete' => [
                'button' => 'Mark as obsolete',
                'confirm' => [
                    'description' => 'Are you sure you want to mark this request as obsolete?',
                    'title' => 'Mark as obsolete',
                    'success' => 'Request marked as obsolete successfully.',
                ],
            ],
            'duplicate' => [
                'button' => 'Mark as duplicate',
                'confirm' => [
                    'description' => 'Are you sure you want to mark this request as duplicate?',
                    'title' => 'Mark as duplicate',
                    'success' => 'Request marked as duplicate successfully.',
                ],
            ],
            'delete' => [
                'button' => 'Delete request',
                'confirm' => [
                    'description' => 'Are you sure you want to delete this request?',
                    'title' => 'Delete request',
                    'success' => 'Request deleted successfully.',
                ],
            ],
        ],
    ],
    'special_needs' => [
        'disabilities' => 'Disabilities',
        'chronic_illness' => 'Chronic illness',
        'paliative_care' => 'Paliative care needs',
        'other' => 'Other',
    ],
    'attribute' => [
        'label' => [
            'singular' => 'attribute',
            'plural' => 'attributes',
        ],
        'type' => [
            'attribute' => 'Attributes',
            'facility' => 'Facilities',
            'service' => 'Services',
        ],
        'actions' => [
            'add' => 'Add attribute',
            'edit' => 'Edit attribute',
            'delete' => 'Delete attribute',
            'activate' => [
                'button' => 'Activate',
                'confirm' => [
                    'description' => 'Are you sure you want to activate this attribute?',
                    'title' => 'Activate attribute',
                    'success' => 'Attribute activated successfully.',
                ],
            ],
            'deactivate' => [
                'button' => 'Deactivate',
                'confirm' => [
                    'description' => 'Are you sure you want to deactivate this attribute?',
                    'title' => 'Deactivate attribute',
                    'success' => 'Attribute deactivated successfully.',
                ],
            ],
            'list' => [
                'button' => 'List attribute',
                'confirm' => [
                    'description' => 'Once a attribute is listed, it will be displayed in the public request form. In order to eliminate the attribute from this lists, it needs to be unlisted.',
                    'title' => 'List shelter attribute',
                    'success' => 'Shelter attribute listed successfully.',
                ],
            ],
            'unlist' => [
                'button' => 'Unlist attribute',
                'confirm' => [
                    'description' => 'Once a attribute is unlisted, it will no longer be displayed in the public request form. To include the attribute in this lists again, it needs to be listed.',
                    'title' => 'Unlist shelter attribute',
                    'success' => 'Shelter attribute unlisted successfully.',
                ],
            ],
        ],
    ],
];
