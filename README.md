Shield
============

[![Travis](https://img.shields.io/travis/juniwalk/Shield.svg?style=flat-square)](https://travis-ci.org/juniwalk/Shield)
[![GitHub Releases](https://img.shields.io/github/release/juniwalk/Shield.svg?style=flat-square)](https://github.com/juniwalk/Shield/releases)
[![Total Donwloads](https://img.shields.io/packagist/dt/juniwalk/Shield.svg?style=flat-square)](https://packagist.org/packages/juniwalk/Shield)
[![Code Quality](https://img.shields.io/scrutinizer/g/juniwalk/Shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/Shield/)
[![Tests Coverage](https://img.shields.io/scrutinizer/coverage/g/juniwalk/Shield.svg?style=flat-square)](https://scrutinizer-ci.com/g/juniwalk/Shield/)
[![License](https://img.shields.io/packagist/l/juniwalk/Shield.svg?style=flat-square)](https://mit-license.org)

Simple, yet powerfull library for [Nette Framework](https://github.com/nette/nette) that will help you block access of unauthorized visitors when in maintenance mode, all this based on listed IP addresses.

Example
-------
Add Shield configuration to your config.neon file.

```yaml
extensions:
        shield: JuniWalk\Shield\DI\ShieldExtension

shield:
    enabled: true
    debugger: true
    action:
        setRedirect: /maintenance.html
    hosts:
        - 127.0.0.1     # Local IPv4
        - ::1           # Local IPv6
```

That's it!

Possible actions
-------
- `getFile`: Include any file you wish.
- `setRedirect`: Redirect to given url.
- `setOutput`: Print out given text directly.
- `invokeCallback`: Given callback will be invoked.

Use of multiple actions is allowed, but do not use `setOutput` and `setRedirect` in that order as headers will be send and redirect will fail. You can also leave the action empty to take no action.

*Either way `AbortException` will be thrown to terminate the flow.*
