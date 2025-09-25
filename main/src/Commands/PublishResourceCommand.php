<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('kernery:resource:publish', 'Publish assets and resource file to public.')]
class PublishResourceCommand extends Command {}
