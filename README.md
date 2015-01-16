Shield
============
Maintenance manager for Nette Framework will help you set your website into maintenance mode whilst allowing access to provided IP addresses.

[![Travis](https://img.shields.io/travis/juniwalk/shield.svg?style=flat-square)](https://travis-ci.org/juniwalk/shield)
[![Latest Packagist Version](https://img.shields.io/packagist/v/juniwalk/shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/shield)
[![Total Donwloads](https://img.shields.io/packagist/dt/juniwalk/shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/shield)
[![Code Quality](https://img.shields.io/scrutinizer/g/juniwalk/shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/shield/)
[![Tests Coverage](https://img.shields.io/scrutinizer/coverage/g/juniwalk/shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/shield/)
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
        setRedirect: /maintenance.html
    hosts:
        Localhost IPv4: 127.0.0.1
        Localhost IPv6: ::1
```

That's it!

Possible actions
-------
- `getFile`: Include any file you wish.
- `setRedirect`: Redirect to given url.
- `setOutput`: Print out given text directly.
- `invokeCallback`: Given callback will be invoked.

Use of multiple actions is allowed, but do not use `setOutput` and `setRedirect` in that order as headers will be send and redirect will fail. You can also leave the action empty to take no action.

*Either way `Shield::terminate();` will be called to exit the flow.*
