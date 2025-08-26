<?php

namespace App\Services;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    protected SettingRepositoryInterface $settingRepository;
    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }
    public function index()
    {
        return $this->settingRepository->index();
    }
    public function update(array $attributes)
    {
        // Handle footer and header settings separately
        $footerSettings = [];
        $headerSettings = [];
        $regularSettings = [];

        foreach ($attributes as $key => $value) {
            if (str_starts_with($key, 'footer_')) {
                $footerSettings[substr($key, 7)] = $value; // Remove 'footer_' prefix
            } elseif (str_starts_with($key, 'header_')) {
                $headerSettings[substr($key, 7)] = $value; // Remove 'header_' prefix
            } else {
                $regularSettings[$key] = $value;
            }
        }

        // Update regular settings
        if (!empty($regularSettings)) {
            $this->settingRepository->update($regularSettings);
        }

        // Update footer settings if any
        if (!empty($footerSettings)) {
            $this->updateFooterSettings($footerSettings);
        }

        // Update header settings if any
        if (!empty($headerSettings)) {
            $this->updateHeaderSettings($headerSettings);
        }

        return true;
    }

    private function updateFooterSettings(array $attributes)
    {
        // Get existing footer settings
        $existingSetting = Setting::where('key', 'footer')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : [];

        // Clean up existing data that might have full URLs
        $existingData = $this->cleanupFooterImagePaths($existingData);

        // Handle file uploads using standard helper functions
        if (isset($attributes['banner_image']) && $attributes['banner_image']) {
            $oldBannerImage = $existingData['banner_image'] ?? null;
            $attributes['banner_image'] = update_file($oldBannerImage, $attributes['banner_image'], 'footer-settings');
        } elseif (isset($existingData['banner_image'])) {
            $attributes['banner_image'] = $existingData['banner_image'];
        }

        if (isset($attributes['logo']) && $attributes['logo']) {
            $oldLogo = $existingData['logo'] ?? null;
            $attributes['logo'] = update_file($oldLogo, $attributes['logo'], 'footer-settings');
        } elseif (isset($existingData['logo'])) {
            $attributes['logo'] = $existingData['logo'];
        }

        // Merge with existing data
        $mergedData = array_merge($existingData, $attributes);

        // Update or create footer setting
        Setting::updateOrCreate(
            ['key' => 'footer'],
            ['value' => json_encode($mergedData)]
        );
    }

    private function updateHeaderSettings(array $attributes)
    {
        // Get existing header settings
        $existingSetting = Setting::where('key', 'header')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : [];

        // Clean up existing data that might have full URLs
        $existingData = $this->cleanupHeaderImagePaths($existingData);

        // Handle file uploads using standard helper functions
        if (isset($attributes['secondary_logo']) && $attributes['secondary_logo']) {
            $oldSecondaryLogo = $existingData['secondaryLogo'] ?? null;
            $attributes['secondaryLogo'] = update_file($oldSecondaryLogo, $attributes['secondary_logo'], 'header-settings');
        } elseif (isset($existingData['secondaryLogo'])) {
            $attributes['secondaryLogo'] = $existingData['secondaryLogo'];
        }

        // Merge with existing data
        $mergedData = array_merge($existingData, $attributes);

        // Update or create header setting
        Setting::updateOrCreate(
            ['key' => 'header'],
            ['value' => json_encode($mergedData)]
        );
    }

    private function cleanupFooterImagePaths(array $data): array
    {
        // Clean up banner image path
        if (isset($data['banner_image']) && is_string($data['banner_image'])) {
            // If it's a full URL, extract just the file path
            if (str_starts_with($data['banner_image'], 'http')) {
                $data['banner_image'] = str_replace(asset('/storage/'), '', $data['banner_image']);
            }
        }

        // Clean up logo path
        if (isset($data['logo']) && is_string($data['logo'])) {
            // If it's a full URL, extract just the file path
            if (str_starts_with($data['logo'], 'http')) {
                $data['logo'] = str_replace(asset('/storage/'), '', $data['logo']);
            }
        }

        return $data;
    }

    private function cleanupHeaderImagePaths(array $data): array
    {
        // Clean up secondary logo path
        if (isset($data['secondaryLogo']) && is_string($data['secondaryLogo'])) {
            // If it's a full URL, extract just the file path
            if (str_starts_with($data['secondaryLogo'], 'http')) {
                $data['secondaryLogo'] = str_replace(asset('/storage/'), '', $data['secondaryLogo']);
            }
        }

        return $data;
    }

}
