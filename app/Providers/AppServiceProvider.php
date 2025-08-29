<?php

namespace App\Providers;

use App\Interfaces\AboutUsFeatureItemRepositoryInterface;
use App\Interfaces\AboutUsMiddleSectionRepositoryInterface;
use App\Interfaces\AboutUsMiddleSectionItemRepositoryInterface;
use App\Interfaces\AboutUsFinalSectionRepositoryInterface;
use App\Interfaces\AboutUsFinalSectionItemRepositoryInterface;
use App\Interfaces\AboutUsBannerSectionRepositoryInterface;
use App\Interfaces\AdminRepositoryInterface;
use App\Interfaces\SolutionRepositoryInterface;
use App\Interfaces\SolutionHeroSectionRepositoryInterface;
use App\Interfaces\SolutionMainSectionRepositoryInterface;
use App\Interfaces\SolutionMainSectionItemRepositoryInterface;
use App\Interfaces\SolutionMainSectionItemContentRepositoryInterface;
use App\Interfaces\SolutionMiddleSectionRepositoryInterface;
use App\Interfaces\SolutionMiddleSectionItemRepositoryInterface;
use App\Interfaces\ServiceHeroSectionRepositoryInterface;
use App\Interfaces\CarModelRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\ServiceBannerSectionRepositoryInterface;
use App\Interfaces\ServiceSectionRepositoryInterface;
use App\Interfaces\ServiceSectionItemRepositoryInterface;
use App\Interfaces\PartnershipHeroSectionRepositoryInterface;
use App\Interfaces\PartnershipSectionRepositoryInterface;
use App\Interfaces\PartnerRepositoryInterface;
use App\Interfaces\PartnerBannerSectionRepositoryInterface;
use App\Interfaces\PartnerBannerSectionItemRepositoryInterface;
use App\Interfaces\ContactUsContentRepositoryInterface;
use App\Interfaces\ContactUsSectionRepositoryInterface;
use App\Interfaces\ContactInquiryRepositoryInterface;
use App\Interfaces\LocationRepositoryInterface;
use App\Interfaces\AboutUsHeroSectionRepositoryInterface;
use App\Interfaces\AboutUsFeatureRepositoryInterface;
use App\Interfaces\HomeHeroSectionRepositoryInterface;
use App\Interfaces\HomePrimarySectionRepositoryInterface;
use App\Interfaces\HomeSecondarySectionRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\TermsConditionHeroSectionRepositoryInterface;
use App\Interfaces\TermsConditionItemRepositoryInterface;
use App\Repositories\AboutUsFeatureItemRepository;
use App\Repositories\AboutUsMiddleSectionRepository;
use App\Repositories\AboutUsMiddleSectionItemRepository;
use App\Repositories\AboutUsFinalSectionRepository;
use App\Repositories\AboutUsFinalSectionItemRepository;
use App\Repositories\AboutUsBannerSectionRepository;
use App\Repositories\AdminRepository;
use App\Repositories\SolutionRepository;
use App\Repositories\SolutionHeroSectionRepository;
use App\Repositories\SolutionMainSectionRepository;
use App\Repositories\SolutionMainSectionItemRepository;
use App\Repositories\SolutionMainSectionItemContentRepository;
use App\Repositories\SolutionMiddleSectionRepository;
use App\Repositories\SolutionMiddleSectionItemRepository;
use App\Repositories\ServiceHeroSectionRepository;
use App\Repositories\CarModelRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ServiceBannerSectionRepository;
use App\Repositories\ServiceSectionRepository;
use App\Repositories\ServiceSectionItemRepository;
use App\Repositories\PartnershipHeroSectionRepository;
use App\Repositories\PartnershipSectionRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\PartnerBannerSectionRepository;
use App\Repositories\PartnerBannerSectionItemRepository;
use App\Repositories\ContactUsContentRepository;
use App\Repositories\ContactUsSectionRepository;
use App\Repositories\ContactInquiryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\AboutUsHeroSectionRepository;
use App\Repositories\AboutUsFeatureRepository;
use App\Repositories\HomeHeroSectionRepository;
use App\Repositories\HomePrimarySectionRepository;
use App\Repositories\HomeSecondarySectionRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TermsConditionHeroSectionRepository;
use App\Repositories\TermsConditionItemRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositoriesInterfaces();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

    private function bindRepositoriesInterfaces(): void
    {
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ServiceHeroSectionRepositoryInterface::class, ServiceHeroSectionRepository::class);
        $this->app->bind(CarModelRepositoryInterface::class, CarModelRepository::class);
        $this->app->bind(ServiceBannerSectionRepositoryInterface::class, ServiceBannerSectionRepository::class);
        $this->app->bind(ServiceSectionRepositoryInterface::class, ServiceSectionRepository::class);
        $this->app->bind(ServiceSectionItemRepositoryInterface::class, ServiceSectionItemRepository::class);
        $this->app->bind(PartnershipHeroSectionRepositoryInterface::class, PartnershipHeroSectionRepository::class);
        $this->app->bind(PartnershipSectionRepositoryInterface::class, PartnershipSectionRepository::class);
        $this->app->bind(PartnerRepositoryInterface::class, PartnerRepository::class);
        $this->app->bind(PartnerBannerSectionRepositoryInterface::class, PartnerBannerSectionRepository::class);
        $this->app->bind(PartnerBannerSectionItemRepositoryInterface::class, PartnerBannerSectionItemRepository::class);
        $this->app->bind(ContactUsContentRepositoryInterface::class, ContactUsContentRepository::class);
        $this->app->bind(ContactUsSectionRepositoryInterface::class, ContactUsSectionRepository::class);
        $this->app->bind(ContactInquiryRepositoryInterface::class, ContactInquiryRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(AboutUsHeroSectionRepositoryInterface::class, AboutUsHeroSectionRepository::class);
        $this->app->bind(AboutUsFeatureRepositoryInterface::class, AboutUsFeatureRepository::class);
        $this->app->bind(HomeHeroSectionRepositoryInterface::class, HomeHeroSectionRepository::class);
        $this->app->bind(HomePrimarySectionRepositoryInterface::class, HomePrimarySectionRepository::class);
        $this->app->bind(HomeSecondarySectionRepositoryInterface::class, HomeSecondarySectionRepository::class);
        $this->app->bind(AboutUsFeatureItemRepositoryInterface::class, AboutUsFeatureItemRepository::class);
        $this->app->bind(AboutUsMiddleSectionRepositoryInterface::class, AboutUsMiddleSectionRepository::class);
        $this->app->bind(AboutUsMiddleSectionItemRepositoryInterface::class, AboutUsMiddleSectionItemRepository::class);
        $this->app->bind(AboutUsFinalSectionRepositoryInterface::class, AboutUsFinalSectionRepository::class);
        $this->app->bind(AboutUsFinalSectionItemRepositoryInterface::class, AboutUsFinalSectionItemRepository::class);
        $this->app->bind(AboutUsBannerSectionRepositoryInterface::class, AboutUsBannerSectionRepository::class);
        $this->app->bind(SolutionRepositoryInterface::class, SolutionRepository::class);
        $this->app->bind(SolutionHeroSectionRepositoryInterface::class, SolutionHeroSectionRepository::class);
        $this->app->bind(SolutionMainSectionRepositoryInterface::class, SolutionMainSectionRepository::class);
        $this->app->bind(SolutionMainSectionItemRepositoryInterface::class, SolutionMainSectionItemRepository::class);
        $this->app->bind(SolutionMainSectionItemContentRepositoryInterface::class, SolutionMainSectionItemContentRepository::class);
        $this->app->bind(SolutionMiddleSectionRepositoryInterface::class, SolutionMiddleSectionRepository::class);
        $this->app->bind(SolutionMiddleSectionItemRepositoryInterface::class, SolutionMiddleSectionItemRepository::class);
        $this->app->bind(TermsConditionHeroSectionRepositoryInterface::class, TermsConditionHeroSectionRepository::class);
        $this->app->bind(TermsConditionItemRepositoryInterface::class, TermsConditionItemRepository::class);
    }

}
