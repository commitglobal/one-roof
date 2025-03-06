<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentType: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case PASSPORT = 'passport';
    case NATIONAL_ID_CARD = 'national_id_card';
    case BIRTH_CERTIFICATE = 'birth_certificate';
    case DRIVERS_LICENSE = 'drivers_license';
    case REFUGEE_CERTIFICATE = 'refugee_certificate';
    case RESIDENCE_PERMIT = 'residence_permit';
    case WORK_PERMIT = 'work_permit';
    case TRAVEL_DOCUMENTS = 'travel_documents';
    case COURT_ORDERS = 'court_orders';
    case VACCINATION_RECORDS = 'vaccination_records';
    case MEDICAL_HISTORY = 'medical_history';
    case DISABILITY_CERTIFICATION = 'disability_certification';
    case PRESCRIPTIONS = 'prescriptions';
    case MARRIAGE_CERTIFICATE = 'marriage_certificate';
    case DEATH_CERTIFICATE = 'death_certificate';
    case PROOF_OF_GUARDIANSHIP = 'proof_of_guardianship';
    case PROOF_OF_INCOME = 'proof_of_income';
    case SOCIAL_SECURITY_DOCUMENTS = 'social_security_documents';
    case BANK_ACCOUNT_DETAILS = 'bank_account_details';
    case PREVIOUS_ADDRESS = 'previous_address';
    case RELOCATION_APPROVAL = 'relocation_approval';
    case REFERRAL_LETTERS = 'referral_letters';
    case OTHER = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::PASSPORT => __('app.documents.type.passport'),
            self::NATIONAL_ID_CARD => __('app.documents.type.national_id_card'),
            self::BIRTH_CERTIFICATE => __('app.documents.type.birth_certificate'),
            self::DRIVERS_LICENSE => __('app.documents.type.drivers_license'),
            self::REFUGEE_CERTIFICATE => __('app.documents.type.refugee_certificate'),
            self::RESIDENCE_PERMIT => __('app.documents.type.residence_permit'),
            self::WORK_PERMIT => __('app.documents.type.work_permit'),
            self::TRAVEL_DOCUMENTS => __('app.documents.type.travel_documents'),
            self::COURT_ORDERS => __('app.documents.type.court_orders'),
            self::VACCINATION_RECORDS => __('app.documents.type.vaccination_records'),
            self::MEDICAL_HISTORY => __('app.documents.type.medical_history'),
            self::DISABILITY_CERTIFICATION => __('app.documents.type.disability_certification'),
            self::PRESCRIPTIONS => __('app.documents.type.prescriptions'),
            self::MARRIAGE_CERTIFICATE => __('app.documents.type.marriage_certificate'),
            self::DEATH_CERTIFICATE => __('app.documents.type.death_certificate'),
            self::PROOF_OF_GUARDIANSHIP => __('app.documents.type.proof_of_guardianship'),
            self::PROOF_OF_INCOME => __('app.documents.type.proof_of_income'),
            self::SOCIAL_SECURITY_DOCUMENTS => __('app.documents.type.social_security_documents'),
            self::BANK_ACCOUNT_DETAILS => __('app.documents.type.bank_account_details'),
            self::PREVIOUS_ADDRESS => __('app.documents.type.previous_address'),
            self::RELOCATION_APPROVAL => __('app.documents.type.relocation_approval'),
            self::REFERRAL_LETTERS => __('app.documents.type.referral_letters'),
            self::OTHER => __('app.documents.type.other'),
        };
    }
}
