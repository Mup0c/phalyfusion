# Phalyfusion
## NOTE: This repository is the development history. See [taptima/phalyfusion] for the current version.

Phalyfusion is a tool for convenient and effective usage of multiple PHP static code analysers.
It runs analysers, combines its outputs and makes a single nice output in various formats:
  - Nice PHPStan-like table console output, groups errors by the file.
  - Checkstyle
  - Json
 

Currently supported analysers:
  - [PHPStan]
  - [Phan]
  - [Psalm]
  - [PHPMD]

# Installation
```sh
composer require --dev taptima/phalyfusion
```
Composer will install Phalyfusion’s executable in its ```bin-dir``` which defaults to ```vendor/bin```.

**Analysers should be installed individually.**

# Usage
After installing Phalyfusion you need to create `phalyfusion.neon` configuration file in the project root. 
#### Config sample
```
plugins:
    usePlugins:
        - phan
        - phpstan
        - psalm
        - phpmd
    runCommands:
        phan:    'bin/phan -k .phan/config.php'
        phpstan:  bin/phpstan analyse -c phpstan.neon --level 7
        psalm:   "bin/psalm -c 'psalm.xml'"
        phpmd:    bin/phpmd src text cleancode
```
Provide names of analysers (plugins) you want to use in `usePlugins`. Choose from: `phan` `phpstan` `psalm` `phpmd`.
Provide command lines to run stated analysers. Paths are resolved relative to current working directory (the directory where from you are running Phalyfusion)

- Note that each analyser should be individually installed and configured.
- All supported by individual analysers arguments and options can be used in the corresponding command line (runCommands)
- Output formats of the analysers are overridden. To choose Phalyfusion output format use --format option when running.
- File\path arguments of analysers are NOT guaranteed to be overridden in case you pass such argument to Phalyfusion.
- Do not state path/files options/arguments in runCommands, use paths argument of Phalyfusion or configure it in configs.
#### Running
After configuring the tool and all used analysers run Phalyfusion:
<br>
`<path_to_bin>/phalyfusion analyse [options] [--] [<files>...]`
<br><br>
`analyse` is a default command, so it is optional to specify it. The simplest run command looks like:
<br>`<path_to_bin>/phalyfusion`
<br><br>
Type `<path_to_bin>/phalyfusion analyse --help` to show all available options and arguments.

# Contributing
It is easy to add support of other PHP static code analysers. 
You have to implement `PluginRunnerInterface`, write functional tests and thats it.

Before you create a pull request to submit your contribution, you must:
 - run tests and be sure everything is ok.

#### How to run tests

```bash
make test
```
[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

  [PHPStan]: https://github.com/phpstan/phpstan
  [Phan]: https://github.com/phan/phan
  [Psalm]: https://github.com/vimeo/psalm
  [PHPMD]: https://github.com/phpmd/phpmd
  [taptima/phalyfusion]: https://github.com/taptima/phalyfusion
