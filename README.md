# Docker Image for `xhgui`, a GUI for XHProf, by [FEROX](https://ferox.yt)

![Docker Cloud Automated build](https://img.shields.io/docker/cloud/automated/frxyt/xhgui-dev.svg)
![Docker Cloud Build Status](https://img.shields.io/docker/cloud/build/frxyt/xhgui-dev.svg)
![Docker Pulls](https://img.shields.io/docker/pulls/frxyt/xhgui-dev.svg)
![GitHub issues](https://img.shields.io/github/issues/frxyt/docker-xhgui-dev.svg)
![GitHub last commit](https://img.shields.io/github/last-commit/frxyt/docker-xhgui-dev.svg)

This image packages [`xhgui`](https://github.com/perftools/xhgui) with MongoDB and NGINX so you can just focus on using it instead of how to install it!

* Docker Hub: https://hub.docker.com/r/frxyt/xhgui-dev
* GitHub: https://github.com/frxyt/docker-xhgui-dev

## Docker Hub Image

**`frxyt/xhgui-dev`**

## Usage

### General use

1. See documentation of [`xhgui`](https://github.com/perftools/xhgui) and [`xhgui-collector`](https://github.com/perftools/xhgui-collector).
1. Add `frxyt/xhgui-dev` to your `docker-compose.yml` file:
   ```yaml
   xhgui:
     image: frxyt/xhgui-dev
     ports:
       - 127.0.0.1:80:80
   ```

### Example in a PHP application running with PHP 7.x

1. If your `php` container is on the same `docker-compose.yml` file:
   1. Make sure you have [`Tideways XHProf Extension`](https://github.com/tideways/php-xhprof-extension) enabled on your `php` container
   1. Make sure your `php` and `xhgui` containers are on the same network
   ```yaml
   networks:
     private:
   services: 
     php:
       networks:
         - private
     xhgui:
       networks:
         - private
   ```
   1. Share a volume with PHP vendor path from `xhgui` to `php`:
   ```yaml
   volumes:
     xhgui-vendor:
   services:
     php:
       volumes:
         - xhgui-vendor:/xhgui/vendor:ro
     xhgui:
       volumes:
         - xhgui-vendor:/xhgui/vendor:rw
   ```
   1. Start profiling on the first script called by your webserver, typically `index.php`:
   ```php
   if ($_SERVER['XHGUI_PROFILING'] && \file_exists('/xhgui/vendor/perftools/xhgui-collector/external/header.php')) {
       require_once('/xhgui/vendor/perftools/xhgui-collector/external/header.php');
   }
   ```
   1. Configure and enable the profiling
   ```yaml
   php:
     environment:
       - XHGUI_PROFILING=1
       - XHGUI_SAVE_HANDLER=upload
   ```

### Full example

You can see a full example here: [`tests/docker-compose.yml`](tests/docker-compose.yml), [`tests/index.php`](tests/index.php).

1. `git checkout https://github.com/frxyt/docker-xhgui-dev`
1. `cd docker-xhgui-dev/tests`
1. `docker-compose up`
1. Browse:
   * The example app: http://localhost
   * XhGui : http://xhgui.localhost

## Build

```sh
docker build -f Dockerfile -t frxyt/xhgui-dev:latest .
```

## License

This project and images are published under the [MIT License](LICENSE).

```
MIT License

Copyright (c) 2019 FEROX YT EIRL, www.ferox.yt <devops@ferox.yt>
Copyright (c) 2019 Jérémy WALTHER <jeremy.walther@golflima.net>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```