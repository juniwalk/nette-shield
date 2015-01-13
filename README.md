Shield
============
Maintenance manager for Nette Framework will help you set your website into maintenance mode whilst allowing access to provided IP addresses.

[![Travis](https://img.shields.io/travis/juniwalk/shield.svg?style=flat-square)](https://travis-ci.org/juniwalk/shield)
[![Latest Packagist Version](https://img.shields.io/packagist/v/juniwalk/shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/shield)
[![Total Donwloads](https://img.shields.io/packagist/dt/juniwalk/shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/shield)
[![Code Quality](https://img.shields.io/scrutinizer/g/juniwalk/shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/shield/)
[![License](https://img.shields.io/packagist/l/juniwalk/shield.svg?style=flat-square)](https://mit-license.org)

Example
-------
Add Shield configuration to your config.neon file.

```neon
extensions:
        shield: JuniWalk\Shield\DI\ShieldExtension

shield:
    enabled: true
    debugger: true
    action:
        type: JuniWalk\Shield\Shield::TASK_INCLUDE
        path: %appDir%/maintenance.php
    hosts:
        Localhost IPv4: 127.0.0.1
        Localhost IPv6: ::1
```

That's it!

Possible actions are:
- Include: Include any file you wish.
- Redirect: Redirect to given url.
- Print: Print out given text directly.
- Callback: Given callback will be called, instance of `Shield` will be provided.
- None: No action will be taken.

*Either way `Shield::terminate();` will be called to exit the flow.*
