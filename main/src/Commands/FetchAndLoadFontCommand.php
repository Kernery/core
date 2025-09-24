<?php

namespace Kernery\Main\Commands;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use function Laravel\Prompts\text;

#[AsCommand('kernery:font:load', 'Fetch fonts and download them on the storage disk.')]

class FetchAndLoadFontCommand extends Command
{
    public function handle(): int
    {
        $appFont = text(
            label: 'Font URL',
            required: true,
            validate: $this->validate('url|starts_with:' . config('core.main.global.app_font_url') . '/css?family='),
        );

        $this->components->info(sprintf('Fetching font <comment>%s</comment>...', $appFont));

        try {

            app('core.load-app-fonts')->load($appFont, forceDownload: true);

        } catch (Exception $exception) {

            $this->components->error('Error during font fetching');

            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->components->info('✔ Font fetch and load operation done!');

        return self::SUCCESS;
    }
}
