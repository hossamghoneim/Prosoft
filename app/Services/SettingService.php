<?php

namespace App\Services;

use App\Interfaces\SettingRepositoryInterface;

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
        return $this->settingRepository->update($attributes);
    }

}
