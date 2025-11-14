<?php

namespace App\Enums;

enum CheckTypeEnum: string
{
    case GitHubUserExists = 'github_user_exists';
    case RepositoryExists = 'repository_exists';
    case DirectoryExists = 'directory_exists';

    public function label(): string
    {
        return match ($this) {
            self::GitHubUserExists => __('Usuario de GitHub'),
            self::RepositoryExists => __('Repositorio'),
            self::DirectoryExists => __('Directorio'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::GitHubUserExists => 'bi bi-person-check',
            self::RepositoryExists => 'bi bi-clipboard-check',
            self::DirectoryExists => 'bi bi-folder-check',
        };
    }
}
