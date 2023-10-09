<?php

namespace JoelButcher\Socialstream\Installer\Drivers\Breeze;

use Illuminate\Filesystem\Filesystem;
use JoelButcher\Socialstream\Installer\Enums\BreezeInstallStack;
use JoelButcher\Socialstream\Installer\Enums\InstallOptions;

class BladeDriver extends BreezeDriver
{
    /**
     * Specify the stack used by this installer.
     */
    protected static function stack(): BreezeInstallStack
    {
        return BreezeInstallStack::Blade;
    }

    protected function postInstall(string $composerBinary, InstallOptions ...$options): void
    {
        $this->replaceInFile('Socialstream::setUserPasswordsUsing(SetUserPassword::class);', '', app_path('Providers/SocialstreamServiceProvider.php'));
    }

    protected static function directoriesToCreateForStack(): array
    {
        return [
            resource_path('views/auth'),
            resource_path('views/profile'),
        ];
    }

    /**
     * Copy the actions to the base "app" directory.
     */
    protected function copyActions(): static
    {
        copy(__DIR__.'/../../../../stubs/app/Actions/Socialstream/ResolveSocialiteUser.php', app_path('Actions/Socialstream/ResolveSocialiteUser.php'));
        copy(__DIR__.'/../../../../stubs/app/Actions/Socialstream/CreateConnectedAccount.php', app_path('Actions/Socialstream/CreateConnectedAccount.php'));
        copy(__DIR__.'/../../../../stubs/app/Actions/Socialstream/GenerateRedirectForProvider.php', app_path('Actions/Socialstream/GenerateRedirectForProvider.php'));
        copy(__DIR__.'/../../../../stubs/app/Actions/Socialstream/UpdateConnectedAccount.php', app_path('Actions/Socialstream/UpdateConnectedAccount.php'));
        copy(__DIR__.'/../../../../stubs/app/Actions/Socialstream/CreateUserFromProvider.php', app_path('Actions/Socialstream/CreateUserFromProvider.php'));
        copy(__DIR__.'/../../../../stubs/app/Actions/Socialstream/HandleInvalidState.php', app_path('Actions/Socialstream/HandleInvalidState.php'));

        return $this;
    }

    /**
     * Copy the auth views to the app "resources" directory for the given stack.
     */
    protected function copyAuthViews(InstallOptions ...$options): static
    {
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/auth/login.blade.php', resource_path('views/auth/login.blade.php'));
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/auth/register.blade.php', resource_path('views/auth/register.blade.php'));

        return $this;
    }

    /**
     * Copy the profile views to the app "resources" directory for the given stack.
     */
    protected function copyProfileViews(InstallOptions ...$options): static
    {
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/profile/edit.blade.php', resource_path('views/profile/edit.blade.php'));
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/profile/partials/set-password-form.blade.php', resource_path('views/profile/partials/set-password-form.blade.php'));
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/profile/partials/connected-accounts-form.blade.php', resource_path('views/profile/partials/connected-accounts-form.blade.php'));

        return $this;
    }

    /**
     * Copy the Socialstream components to the app "resources" directory for the given stack.
     */
    protected function copySocialstreamComponents(InstallOptions ...$options): static
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../../../stubs/breeze/default/resources/views/components/socialstream-icons', resource_path('views/components/socialstream-icons'));

        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/components/action-link.blade.php', resource_path('views/components/action-link.blade.php'));
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/components/connected-account.blade.php', resource_path('views/components/connected-account.blade.php'));
        copy(__DIR__.'/../../../../stubs/breeze/default/resources/views/components/socialstream.blade.php', resource_path('views/components/socialstream.blade.php'));

        return $this;
    }
}