<?php

namespace App\Constants;

/**
 * Permission Constants for RBAC System
 * Organization: Category → Action → Permission
 */
class Permission
{
    // ===== DASHBOARD =====
    public const DASHBOARD_VIEW = 'view-dashboard';

    // ===== PRODUCTS =====
    public const PRODUCT_VIEW = 'view-products';
    public const PRODUCT_CREATE = 'create-products';
    public const PRODUCT_EDIT = 'edit-products';
    public const PRODUCT_DELETE = 'delete-products';
    public const PRODUCT_PUBLISH = 'publish-products';

    // ===== PRODUCT CATEGORIES =====
    public const PRODUCT_CATEGORY_VIEW = 'view-product-categories';
    public const PRODUCT_CATEGORY_CREATE = 'create-product-categories';
    public const PRODUCT_CATEGORY_EDIT = 'edit-product-categories';
    public const PRODUCT_CATEGORY_DELETE = 'delete-product-categories';

    // ===== CAREERS/JOBS =====
    public const CAREER_VIEW = 'view-careers';
    public const CAREER_CREATE = 'create-careers';
    public const CAREER_EDIT = 'edit-careers';
    public const CAREER_DELETE = 'delete-careers';
    public const CAREER_PUBLISH = 'publish-careers';

    // ===== JOB APPLICANTS =====
    public const APPLICANT_VIEW = 'view-applicants';
    public const APPLICANT_SCREEN = 'screen-applicants';
    public const APPLICANT_SHORTLIST = 'shortlist-applicants';
    public const APPLICANT_REJECT = 'reject-applicants';
    public const APPLICANT_DELETE = 'delete-applicants';

    // ===== NEWS =====
    public const NEWS_VIEW = 'view-news';
    public const NEWS_CREATE = 'create-news';
    public const NEWS_EDIT = 'edit-news';
    public const NEWS_DELETE = 'delete-news';
    public const NEWS_PUBLISH = 'publish-news';

    // ===== GALLERIES =====
    public const GALLERY_VIEW = 'view-galleries';
    public const GALLERY_CREATE = 'create-galleries';
    public const GALLERY_EDIT = 'edit-galleries';
    public const GALLERY_DELETE = 'delete-galleries';

    public const GALLERY_CATEGORY_VIEW = 'view-gallery-categories';
    public const GALLERY_CATEGORY_CREATE = 'create-gallery-categories';
    public const GALLERY_CATEGORY_EDIT = 'edit-gallery-categories';
    public const GALLERY_CATEGORY_DELETE = 'delete-gallery-categories';

    // ===== CERTIFICATES =====
    public const CERTIFICATE_VIEW = 'view-certificates';
    public const CERTIFICATE_CREATE = 'create-certificates';
    public const CERTIFICATE_EDIT = 'edit-certificates';
    public const CERTIFICATE_DELETE = 'delete-certificates';

    public const CERTIFICATE_CATEGORY_VIEW = 'view-certificate-categories';
    public const CERTIFICATE_CATEGORY_CREATE = 'create-certificate-categories';
    public const CERTIFICATE_CATEGORY_EDIT = 'edit-certificate-categories';
    public const CERTIFICATE_CATEGORY_DELETE = 'delete-certificate-categories';

    // ===== TEAM =====
    public const TEAM_VIEW = 'view-teams';
    public const TEAM_CREATE = 'create-teams';
    public const TEAM_EDIT = 'edit-teams';
    public const TEAM_DELETE = 'delete-teams';

    // ===== TESTIMONIALS =====
    public const TESTIMONIAL_VIEW = 'view-testimonials';
    public const TESTIMONIAL_CREATE = 'create-testimonials';
    public const TESTIMONIAL_EDIT = 'edit-testimonials';
    public const TESTIMONIAL_DELETE = 'delete-testimonials';

    // ===== PARTNERS =====
    public const PARTNER_VIEW = 'view-partners';
    public const PARTNER_CREATE = 'create-partners';
    public const PARTNER_EDIT = 'edit-partners';
    public const PARTNER_DELETE = 'delete-partners';

    // ===== HERO SLIDES =====
    public const HERO_SLIDE_VIEW = 'view-hero-slides';
    public const HERO_SLIDE_CREATE = 'create-hero-slides';
    public const HERO_SLIDE_EDIT = 'edit-hero-slides';
    public const HERO_SLIDE_DELETE = 'delete-hero-slides';

    // ===== PROMO BANNERS =====
    public const PROMO_BANNER_VIEW = 'view-promo-banners';
    public const PROMO_BANNER_CREATE = 'create-promo-banners';
    public const PROMO_BANNER_EDIT = 'edit-promo-banners';
    public const PROMO_BANNER_DELETE = 'delete-promo-banners';

    // ===== COMPANY INFO =====
    public const COMPANY_INFO_VIEW = 'view-company-info';
    public const COMPANY_INFO_EDIT = 'edit-company-info';

    // ===== VISION & MISSION =====
    public const VISION_MISSION_VIEW = 'view-vision-mission';
    public const VISION_MISSION_EDIT = 'edit-vision-mission';

    // ===== HOME INTRODUCTION =====
    public const HOME_INTRO_VIEW = 'view-home-introduction';
    public const HOME_INTRO_CREATE = 'create-home-introduction';
    public const HOME_INTRO_EDIT = 'edit-home-introduction';
    public const HOME_INTRO_DELETE = 'delete-home-introduction';

    // ===== OFFICE LOCATIONS =====
    public const OFFICE_LOCATION_VIEW = 'view-office-locations';
    public const OFFICE_LOCATION_CREATE = 'create-office-locations';
    public const OFFICE_LOCATION_EDIT = 'edit-office-locations';
    public const OFFICE_LOCATION_DELETE = 'delete-office-locations';

    // ===== MAP MARKERS =====
    public const MAP_MARKER_VIEW = 'view-map-markers';
    public const MAP_MARKER_CREATE = 'create-map-markers';
    public const MAP_MARKER_EDIT = 'edit-map-markers';
    public const MAP_MARKER_DELETE = 'delete-map-markers';

    // ===== CONTACT SUBMISSIONS =====
    public const CONTACT_SUBMISSION_VIEW = 'view-contact-submissions';
    public const CONTACT_SUBMISSION_RESPOND = 'respond-contact-submissions';
    public const CONTACT_SUBMISSION_DELETE = 'delete-contact-submissions';

    // ===== DIRECTOR MESSAGES =====
    public const DIRECTOR_MESSAGE_VIEW = 'view-director-messages';
    public const DIRECTOR_MESSAGE_CREATE = 'create-director-messages';
    public const DIRECTOR_MESSAGE_EDIT = 'edit-director-messages';
    public const DIRECTOR_MESSAGE_DELETE = 'delete-director-messages';

    // ===== VISILAB PAGES =====
    public const VISILAB_PAGE_VIEW = 'view-visilab-pages';
    public const VISILAB_PAGE_EDIT = 'edit-visilab-pages';

    // ===== SGM PAGE =====
    public const SGM_PAGE_VIEW = 'view-sgm-page';
    public const SGM_PAGE_EDIT = 'edit-sgm-page';

    // ===== ANALYTICS =====
    public const ANALYTICS_VIEW = 'view-analytics';
    public const ANALYTICS_EXPORT = 'export-analytics';

    // ===== ROLES & PERMISSIONS MANAGEMENT =====
    public const ROLE_VIEW = 'view-roles';
    public const ROLE_CREATE = 'create-roles';
    public const ROLE_EDIT = 'edit-roles';
    public const ROLE_DELETE = 'delete-roles';

    public const PERMISSION_VIEW = 'view-permissions';
    public const PERMISSION_CREATE = 'create-permissions';
    public const PERMISSION_EDIT = 'edit-permissions';

    public const USER_ROLE_VIEW = 'view-user-roles';
    public const USER_ROLE_EDIT = 'edit-user-roles';

    // ===== USER MANAGEMENT =====
    public const USER_VIEW = 'view-users';
    public const USER_CREATE = 'create-users';
    public const USER_EDIT = 'edit-users';
    public const USER_DELETE = 'delete-users';
    public const USER_ACTIVATE = 'activate-deactivate-users';

    /**
     * Get all permissions grouped by category
     */
    public static function getAll(): array
    {
        return [
            'dashboard' => [
                self::DASHBOARD_VIEW => 'View Dashboard',
            ],
            'products' => [
                self::PRODUCT_VIEW => 'View Products',
                self::PRODUCT_CREATE => 'Create Products',
                self::PRODUCT_EDIT => 'Edit Products',
                self::PRODUCT_DELETE => 'Delete Products',
                self::PRODUCT_PUBLISH => 'Publish Products',
                self::PRODUCT_CATEGORY_VIEW => 'View Categories',
                self::PRODUCT_CATEGORY_CREATE => 'Create Categories',
                self::PRODUCT_CATEGORY_EDIT => 'Edit Categories',
                self::PRODUCT_CATEGORY_DELETE => 'Delete Categories',
            ],
            'careers' => [
                self::CAREER_VIEW => 'View Careers',
                self::CAREER_CREATE => 'Create Careers',
                self::CAREER_EDIT => 'Edit Careers',
                self::CAREER_DELETE => 'Delete Careers',
                self::CAREER_PUBLISH => 'Publish Careers',
                self::APPLICANT_VIEW => 'View Applicants',
                self::APPLICANT_SCREEN => 'Screen Applicants',
                self::APPLICANT_SHORTLIST => 'Shortlist Applicants',
                self::APPLICANT_REJECT => 'Reject Applicants',
                self::APPLICANT_DELETE => 'Delete Applicants',
            ],
            'content' => [
                self::NEWS_VIEW => 'View News',
                self::NEWS_CREATE => 'Create News',
                self::NEWS_EDIT => 'Edit News',
                self::NEWS_DELETE => 'Delete News',
                self::NEWS_PUBLISH => 'Publish News',
                self::GALLERY_VIEW => 'View Galleries',
                self::GALLERY_CREATE => 'Create Galleries',
                self::GALLERY_EDIT => 'Edit Galleries',
                self::GALLERY_DELETE => 'Delete Galleries',
                self::GALLERY_CATEGORY_VIEW => 'View Gallery Categories',
                self::GALLERY_CATEGORY_CREATE => 'Create Gallery Categories',
                self::GALLERY_CATEGORY_EDIT => 'Edit Gallery Categories',
                self::GALLERY_CATEGORY_DELETE => 'Delete Gallery Categories',
                self::CERTIFICATE_VIEW => 'View Certificates',
                self::CERTIFICATE_CREATE => 'Create Certificates',
                self::CERTIFICATE_EDIT => 'Edit Certificates',
                self::CERTIFICATE_DELETE => 'Delete Certificates',
                self::CERTIFICATE_CATEGORY_VIEW => 'View Certificate Categories',
                self::CERTIFICATE_CATEGORY_CREATE => 'Create Certificate Categories',
                self::CERTIFICATE_CATEGORY_EDIT => 'Edit Certificate Categories',
                self::CERTIFICATE_CATEGORY_DELETE => 'Delete Certificate Categories',
            ],
            'company' => [
                self::TEAM_VIEW => 'View Teams',
                self::TEAM_CREATE => 'Create Teams',
                self::TEAM_EDIT => 'Edit Teams',
                self::TEAM_DELETE => 'Delete Teams',
                self::TESTIMONIAL_VIEW => 'View Testimonials',
                self::TESTIMONIAL_CREATE => 'Create Testimonials',
                self::TESTIMONIAL_EDIT => 'Edit Testimonials',
                self::TESTIMONIAL_DELETE => 'Delete Testimonials',
                self::PARTNER_VIEW => 'View Partners',
                self::PARTNER_CREATE => 'Create Partners',
                self::PARTNER_EDIT => 'Edit Partners',
                self::PARTNER_DELETE => 'Delete Partners',
                self::COMPANY_INFO_VIEW => 'View Company Info',
                self::COMPANY_INFO_EDIT => 'Edit Company Info',
                self::VISION_MISSION_VIEW => 'View Vision & Mission',
                self::VISION_MISSION_EDIT => 'Edit Vision & Mission',
                self::DIRECTOR_MESSAGE_VIEW => 'View Director Messages',
                self::DIRECTOR_MESSAGE_CREATE => 'Create Director Messages',
                self::DIRECTOR_MESSAGE_EDIT => 'Edit Director Messages',
                self::DIRECTOR_MESSAGE_DELETE => 'Delete Director Messages',
            ],
            'website' => [
                self::HERO_SLIDE_VIEW => 'View Hero Slides',
                self::HERO_SLIDE_CREATE => 'Create Hero Slides',
                self::HERO_SLIDE_EDIT => 'Edit Hero Slides',
                self::HERO_SLIDE_DELETE => 'Delete Hero Slides',
                self::PROMO_BANNER_VIEW => 'View Promo Banners',
                self::PROMO_BANNER_CREATE => 'Create Promo Banners',
                self::PROMO_BANNER_EDIT => 'Edit Promo Banners',
                self::PROMO_BANNER_DELETE => 'Delete Promo Banners',
                self::HOME_INTRO_VIEW => 'View Home Introduction',
                self::HOME_INTRO_CREATE => 'Create Home Introduction',
                self::HOME_INTRO_EDIT => 'Edit Home Introduction',
                self::HOME_INTRO_DELETE => 'Delete Home Introduction',
                self::OFFICE_LOCATION_VIEW => 'View Office Locations',
                self::OFFICE_LOCATION_CREATE => 'Create Office Locations',
                self::OFFICE_LOCATION_EDIT => 'Edit Office Locations',
                self::OFFICE_LOCATION_DELETE => 'Delete Office Locations',
                self::MAP_MARKER_VIEW => 'View Map Markers',
                self::MAP_MARKER_CREATE => 'Create Map Markers',
                self::MAP_MARKER_EDIT => 'Edit Map Markers',
                self::MAP_MARKER_DELETE => 'Delete Map Markers',
                self::VISILAB_PAGE_VIEW => 'View Visilab Pages',
                self::VISILAB_PAGE_EDIT => 'Edit Visilab Pages',
                self::SGM_PAGE_VIEW => 'View SGM Page',
                self::SGM_PAGE_EDIT => 'Edit SGM Page',
            ],
            'support' => [
                self::CONTACT_SUBMISSION_VIEW => 'View Contact Submissions',
                self::CONTACT_SUBMISSION_RESPOND => 'Respond to Contact',
                self::CONTACT_SUBMISSION_DELETE => 'Delete Contact Submissions',
            ],
            'admin' => [
                self::ANALYTICS_VIEW => 'View Analytics',
                self::ANALYTICS_EXPORT => 'Export Analytics',
                self::ROLE_VIEW => 'View Roles',
                self::ROLE_CREATE => 'Create Roles',
                self::ROLE_EDIT => 'Edit Roles',
                self::ROLE_DELETE => 'Delete Roles',
                self::PERMISSION_VIEW => 'View Permissions',
                self::PERMISSION_CREATE => 'Create Permissions',
                self::PERMISSION_EDIT => 'Edit Permissions',
                self::USER_ROLE_VIEW => 'View User Roles',
                self::USER_ROLE_EDIT => 'Edit User Roles',
                self::USER_VIEW => 'View Users',
                self::USER_CREATE => 'Create Users',
                self::USER_EDIT => 'Edit Users',
                self::USER_DELETE => 'Delete Users',
                self::USER_ACTIVATE => 'Activate/Deactivate Users',
            ],
        ];
    }

    /**
     * Get permissions for a specific category
     */
    public static function getByCategory(string $category): array
    {
        $all = self::getAll();
        return $all[$category] ?? [];
    }
}
