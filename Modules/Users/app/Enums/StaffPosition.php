<?php

namespace Modules\Users\Enums;
enum StaffPosition: string
{
    //principal, vice_principal, teacher, social_worker, psychologist, librarian, tech_specialist, secretary, admin, finance
    case PRINCIPAL = 'principal';
    case VICE_PRINCIPAL = 'vice_principal';
    case TEACHER = 'teacher';
    case SOCIAL_WORKER = 'social_worker';
    case PSYCHOLOGIST = 'psychologist';
    case LIBRARIAN = 'librarian';
    case TECH_SPECIALIST = 'tech_specialist';
    case SECRETARY = 'secretary';
    case ADMIN = 'admin';
    case FINANCE = 'finance';
}
