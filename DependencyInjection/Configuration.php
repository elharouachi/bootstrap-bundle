<?php
/**
 * This file is part of BraincraftedBootstrapBundle.
 *
 * (c) 2012-2013 by Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\BootstrapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @package    BraincraftedBootstrapBundle
 * @subpackage DependencyInjection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2012-2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://bootstrap.braincrafted.com Bootstrap for Symfony2
 */
class Configuration implements ConfigurationInterface
{
    /** @var string */
    const DEFAULT_ASSETS_DIR = '%kernel.project_dir%/../vendor/twbs/bootstrap';

    /** @var string */
    const DEFAULT_ASSETS_DIR_SASS = '%kernel.project_dir%/../vendor/twbs/bootstrap-sass/assets';

    /** @var string */
    const DEFAULT_FONTAWESOME_DIR = '%kernel.project_dir%/../vendor/fortawesome/font-awesome';

    /** @var string */
    const DEFAULT_BOOTSTRAP_OUTPUT = '%kernel.project_dir%/Resources/less/bootstrap.less';

    /** @var string */
    const DEFAULT_BOOTSTRAP_OUTPUT_SASS = '%kernel.project_dir%/Resources/sass/bootstrap.scss';

    /** @var string */
    const DEFAULT_BOOTSTRAP_TEMPLATE = 'BraincraftedBootstrapBundle:Bootstrap:bootstrap.less.twig';

    /** @var string */
    const DEFAULT_BOOTSTRAP_TEMPLATE_SASS = 'BraincraftedBootstrapBundle:Bootstrap:bootstrap.scss.twig';

    /** @var string */
    const DEFAULT_JQUERY_PATH = '%kernel.project_dir%/../vendor/jquery/jquery/jquery-1.11.1.js';

    /** @var string */
    const DEFAULT_FONTS_DIR = '%kernel.project_dir%/../web/fonts';

    const TREE_BUILDER_NAME = 'braincrafted_bootstrap';
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        return $this->buildConfigTree();
    }

    private function buildConfigTree()
    {
        $treeBuilder = new TreeBuilder(self::TREE_BUILDER_NAME);

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root(self::TREE_BUILDER_NAME);
        }

        $rootNode
            ->children()
                ->scalarNode('output_dir')->defaultValue('')->end()
                ->scalarNode('assets_dir')
                    ->defaultValue(self::DEFAULT_ASSETS_DIR)
                ->end()
                ->scalarNode('fontawesome_dir')
                    ->defaultValue(self::DEFAULT_FONTAWESOME_DIR)
                ->end()
                ->scalarNode('jquery_path')
                    ->defaultValue(self::DEFAULT_JQUERY_PATH)
                ->end()
                ->scalarNode('fonts_dir')
                    ->defaultValue(self::DEFAULT_FONTS_DIR)
                ->end()

                // renamed from css_preprocessor to css_preprocessor
                ->scalarNode('css_preprocessor')
                    ->defaultValue('less')
                    ->validate()
                        ->ifNotInArray(array('less', 'lessphp', 'sass', 'scssphp', 'none'))
                        ->thenInvalid('Invalid less filter "%s"')
                    ->end()
                ->end()
                ->scalarNode('icon_prefix')
                    ->defaultValue('glyphicon')
                ->end()
                ->scalarNode('icon_tag')
                    ->defaultValue('span')
                ->end()
                ->arrayNode('customize')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('variables_file')->end()
                        ->scalarNode('bootstrap_output')
                            ->defaultValue(self::DEFAULT_BOOTSTRAP_OUTPUT)
                        ->end()
                        ->scalarNode('bootstrap_template')
                            ->defaultValue(self::DEFAULT_BOOTSTRAP_TEMPLATE)
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('auto_configure')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('assetic')->defaultValue(true)->end()
                        ->booleanNode('twig')->defaultValue(true)->end()
                        ->booleanNode('knp_menu')->defaultValue(true)->end()
                        ->booleanNode('knp_paginator')->defaultValue(true)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
