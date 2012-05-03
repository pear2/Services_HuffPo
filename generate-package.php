#!/usr/bin/env php
<?php
ini_set('date.timezone', 'Europe/Berlin');

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$api_version     = '0.1.0';
$api_state       = 'alpha';

$release_version = '0.1.0';
$release_state   = 'alpha';
$release_notes   = "Initial release!";

$description = "An API wrapper to retrieve meta data of articles on huffingtonpost.com.";

$package = new PEAR_PackageFileManager2();

$package->setOptions(
    array(
         'filelistgenerator' => 'file',
         'simpleoutput'      => true,
         'baseinstalldir'    => '/',
         'packagedirectory'  => './',
         'dir_roles'         => array(
             'library' => 'php',
             'tests'   => 'test',
             'docs'    => 'doc',
         ),
         'exceptions'        => array(
             'README.md' => 'doc',
         ),
         'ignore'            => array(
             '.git*',
             'generate-package.php',
             '*.tgz',
             'phpunit.xml',
         )
    )
);

$package->setPackage('PEAR2_Services_HuffPo');
$package->setSummary($description);
$package->setDescription($description);
$package->setChannel('easybib.github.com/pear');
$package->setPackageType('php');
$package->setLicense(
    'BSD',
    'http://www.opensource.org/licenses/bsd-license.php'
);

$package->setNotes($release_notes);
$package->setReleaseVersion($release_version);
$package->setReleaseStability($release_state);
$package->setAPIVersion($api_version);
$package->setAPIStability($api_state);

$package->addMaintainer(
    'lead',
    'till',
    'Till Klampaeckel',
    'till@php.net'
);

/**
 * Generate the list of files in {@link $GLOBALS['files']}
 *
 * @param string $path
 *
 * @return void
 */
function readDirectory($path) {
    foreach (glob($path . '/*') as $file) {
        if (!is_dir($file)) {
            $GLOBALS['files'][] = $file;
        } else {
            readDirectory($file);
        }
    }
}

$files = array();
readDirectory(__DIR__ . '/library');

/**
 * @desc Strip this from the filename for 'addInstallAs'
 */
$base = __DIR__ . '/';

foreach ($files as $file) {

    $file2 = str_replace($base, '', $file);

    $package->addReplacement(
        $file2,
        'package-info',
        '@package_version@',
        'version'
    );
    $file2 = str_replace($base, '', $file);
    $package->addInstallAs($file2, str_replace('library/', '', $file2));
}

$package->setPhpDep('5.3.0');

$package->addPackageDepWithChannel(
    'required',
    'HTTP_Request2',
    'pear.php.net'
);

$package->addExtensionDep('required', 'spl');
$package->setPearInstallerDep('1.9.4');
$package->generateContents();

if (   isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')
) {
    $package->writePackageFile();
} else {
    $package->debugPackageFile();
}