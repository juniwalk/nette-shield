Shield
======

[![Travis](https://img.shields.io/travis/juniwalk/Shield.svg?style=flat-square)](https://travis-ci.org/juniwalk/Shield)
[![GitHub Releases](https://img.shields.io/github/release/juniwalk/Shield.svg?style=flat-square)](https://github.com/juniwalk/Shield/releases)
[![Total Donwloads](https://img.shields.io/packagist/dt/juniwalk/Shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/Shield)
[![Code Quality](https://img.shields.io/scrutinizer/g/juniwalk/Shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/Shield/)
[![Tests Coverage](https://img.shields.io/scrutinizer/coverage/g/juniwalk/Shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/Shield/)
[![License](https://img.shields.io/packagist/l/juniwalk/Shield.svg?style=flat-square)](https://mit-license.org)

Simple, yet powerfull library for [Nette Framework](https://github.com/nette/nette) that will help you block access of unauthorized visitors when in maintenance mode, all this based on listed IP addresses.

Installation
------------
Best way to install Shield is using composer.
```
$ composer require juniwalk/shield:~1.3
```

Example
-------
Add Shield configuration to your config.neon file.

```yaml
extensions:
    shield: JuniWalk\Shield\DI\ShieldExtension

shield:
    enabled: true
    debugger: true
    autorun: true
    actions:
        output: "Forbidden! 403"
        include: %appDir%/tmp/maintenance.html
        redirect: /tmp/maintenance.html
        callback: {@service, method} #will receive instance of Shield
        abort: 255 #status code
    hosts:
        - 127.0.0.1     # Local IPv4
        - ::1           # Local IPv6
```

That's it!

Actions
-------
- `Include`: Include any file you wish.
- `Redirect`: Redirect to given url.
- `Output`: Print out given text directly.
- `Callback`: Given callback will be invoked.
- `Abort`: Code execution is aborted.

You can use all above mentioned actions one time, but do not use `Output` and `Redirect` in that order as headers will be send and redirect will fail. You can also leave the action empty to take no action.

*`Abort` action is called automatically with status code 0 if you don't add it yourself.*
