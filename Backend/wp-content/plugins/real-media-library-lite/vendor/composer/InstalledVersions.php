<?php

namespace MatthiasWeb\RealMediaLibrary\Vendor\Composer;

use MatthiasWeb\RealMediaLibrary\Vendor\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '7aa4fc74daf87186a3cd07d33ecdd151a7c3dd3d', 'name' => '__root__'), 'versions' => array('__root__' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '7aa4fc74daf87186a3cd07d33ecdd151a7c3dd3d'), 'devowl-wp/freemium' => array('pretty_version' => 'dev-wordpress', 'version' => 'dev-wordpress', 'aliases' => array(), 'reference' => 'a6f7fa5938b077d07d390d5a6729e1b48e0c178b'), 'devowl-wp/real-product-manager-wp-client' => array('pretty_version' => 'dev-wordpress', 'version' => 'dev-wordpress', 'aliases' => array(), 'reference' => '20cb702cfdf8371d48750463c30f8551c1753410'), 'devowl-wp/real-utils' => array('pretty_version' => 'dev-wordpress', 'version' => 'dev-wordpress', 'aliases' => array(), 'reference' => '48f380da0e61910f07cecb52dc58cf8e24b8f5e1'), 'devowl-wp/utils' => array('pretty_version' => 'dev-wordpress', 'version' => 'dev-wordpress', 'aliases' => array(), 'reference' => '4f4a98962be8e2e5a3404e76233f744ca5346477'), 'yahnis-elsts/plugin-update-checker' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9999999-dev'), 'reference' => '56c78cc6da7b071e58ec4a4cc04f2a2dcae05a13')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(\MatthiasWeb\RealMediaLibrary\Vendor\Composer\Semver\VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        $ranges = array();
        if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            $ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
        }
        if (\array_key_exists('aliases', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
        }
        if (\array_key_exists('replaced', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
        }
        if (\array_key_exists('provided', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
        }
        return \implode(' || ', $ranges);
    }
    public static function getVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['version'];
    }
    public static function getPrettyVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['pretty_version'];
    }
    public static function getReference($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['reference'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['reference'];
    }
    public static function getRootPackage()
    {
        return self::$installed['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
    }
}
