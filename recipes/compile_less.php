<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('keep_less', null, InputOption::VALUE_OPTIONAL, 'Keep original LESS files after compiling', false);

set('less_files', [
    // source files (relative to release root) => /target/path/[filename].css
    //'www/css/*.less' => 'www/css/[filename].css',
]);

desc('Compiles LESS files');
task('deploy:compile_less', function () {
    $keepfiles = false;
    if (input()->hasOption('keep_less')) {
        $keepfiles = input()->getOption('keep_less');
    }
    cd('{{release_path}}');
    $files = get('less_files');
    foreach ($files as $glob => $target) {
        foreach (explode(PHP_EOL, run('ls ' . $glob)) as $path) {
            $filename = str_replace('.less', '', basename($path));
            run('vendor/bin/plessc ' . $path . ' > ' . str_replace('[filename]', $filename, $target));
            if (false === $keepfiles)  {
                run('unlink ' . $path);
            }
        }
    }
});
