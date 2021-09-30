<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\CreatePbc;

use Spryker\Shared\Application\ApplicationConstants;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class CreatePbcSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_CONSTANT_NAME = 'name';
    protected const SHORTCODE = 'pbc-hello-world';

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'createPbc';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $rootDir = $this->config->getRootDirectory();
        $name = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_NAME)
            ->getValue();
        $pbcPath = $rootDir . $name;
        $backofficePort = (int)(getenv('SPRYKER_BE_PORT')) ?: 443;
        $zedHost = sprintf(
            'https:\\/\\/%s%s\\/%s',
            getenv('SPRYKER_BE_HOST'),
            $backofficePort !== 443 ? ':' . $backofficePort : '',
            'enable-pbc?name=' . $name
        );

        exec('mkdir ' . $name . ' && tar -xvf ' . __DIR__ . DIRECTORY_SEPARATOR . 'data.tar.gz -C' . $pbcPath);
        exec('sed -i \'s/' . static::SHORTCODE . '/' . $name . '/g\' ' . $pbcPath . DIRECTORY_SEPARATOR . 'composer.json');
        exec('sed -i \'s/' . static::SHORTCODE     . '/' . $this->dashesToCamelCase($name) . '/\' ' . $pbcPath .
            DIRECTORY_SEPARATOR . 'config' .
            DIRECTORY_SEPARATOR . 'app' .
            DIRECTORY_SEPARATOR . 'pbc' .
            DIRECTORY_SEPARATOR . 'manifest' . DIRECTORY_SEPARATOR . '*'
        );
        exec('sed -i \'s/pbcPath/' . $zedHost . '/\' ' . $pbcPath .
            DIRECTORY_SEPARATOR . 'config' .
            DIRECTORY_SEPARATOR . 'app' .
            DIRECTORY_SEPARATOR . 'pbc' .
            DIRECTORY_SEPARATOR . 'manifest' . DIRECTORY_SEPARATOR . '*'
        );
    }

    /**
     * @param $string
     * @param false $capitalizeFirstCharacter
     *
     * @return array|string|string[]
     */
    protected function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {

        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}
