<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('keep_js', null, InputOption::VALUE_OPTIONAL, 'Keep original JS files after minifying', false);

set('js_files', [
    // source files (relative to release root) => /target/path/[filename].js
    //'www/js/*.src.js' => 'www/js/[filename].min.js',
]);


desc('Minifies JS files');
task('deploy:minify_js', function () {
    $keepfiles = false;
    if (input()->hasOption('keep_js')) {
        $keepfiles = input()->getOption('keep_js');
    }
    cd('{{release_path}}');
    $files = get('js_files');
    foreach ($files as $glob => $target) {
        foreach (explode(PHP_EOL, run('ls ' . $glob)) as $sourcefile) {
            $filename   = str_replace(['.src', '.js'], '', basename($sourcefile));
            $targetfile = str_replace('[filename]', $filename, $target);
            if ($sourcefile == $targetfile) {
                $targetfile .= '.tmp';
            }
            run('vendor/bin/minifyjs ' . $sourcefile . ' > ' . $targetfile);
            if (($sourcefile . '.tmp') == $targetfile) {
                run('mv ' . $targetfile . ' ' . $sourcefile);
            } elseif (false === $keepfiles) {
                run('unlink ' . $sourcefile);
            }
        }
    }
});