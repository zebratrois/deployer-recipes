<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('keep_css', null, InputOption::VALUE_OPTIONAL, 'Keep original CSS files after minifying', false);

set('css_files', [
    // source files (relative to release root) => /target/path/[filename].css
    //'www/css/*.src.css' => 'www/css/[filename].min.css',
]);


desc('Minifies CSS files');
task('deploy:minify_css', function () {
    $keepfiles = false;
    if (input()->hasOption('keep_css')) {
        $keepfiles = input()->getOption('keep_css');
    }
    cd('{{release_path}}');
    $files = get('css_files');
    foreach ($files as $glob => $target) {
        foreach (explode(PHP_EOL, run('ls ' . $glob)) as $sourcefile) {
            $filename = str_replace(['.src', '.css'], '', basename($sourcefile));
            $targetfile = str_replace('[filename]', $filename, $target);
            if ($sourcefile == $targetfile) {
                $targetfile .= '.tmp';
            }
            run('vendor/bin/minifycss ' . $sourcefile . ' > ' . $targetfile);
            if (($sourcefile . '.tmp') == $targetfile) {
                run('mv ' . $targetfile . ' ' . $sourcefile);
            } elseif (false === $keepfiles)  {
                run('unlink ' . $sourcefile);
            }
        }
    }
});