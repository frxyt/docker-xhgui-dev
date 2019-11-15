# Copyright (c) 2019 FEROX YT EIRL, www.ferox.yt <devops@ferox.yt>
# Copyright (c) 2019 Jérémy WALTHER <jeremy.walther@golflima.net>
# See <https://github.com/frxyt/docker-xhgui-dev> for details.

# Build xhgui
FROM frxyt/php-dev:7.3-cli AS build

COPY build/build.xhgui /frx/build
RUN /frx/build

# Build final image
FROM php:7.3-fpm
LABEL maintainer="Jérémy WALTHER <jeremy@ferox.yt>"

COPY --from=build /xhgui /xhgui
COPY build /frx/
RUN /frx/build
COPY Dockerfile LICENSE README.md /frx/

WORKDIR /xhgui
VOLUME [ "/xhgui/config", "/xhgui/external", "/xhgui/log", "/xhgui/mongodb", "/xhgui/vendor" ]
EXPOSE 80
ENTRYPOINT [ "/bin/sh", "-c" ]
CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf" ]