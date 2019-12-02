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

ENV FRX_LOG_PREFIX_MAXLEN=7

WORKDIR /xhgui
VOLUME [ "/xhgui/mongodb" ]
EXPOSE 80
EXPOSE 27017
ENTRYPOINT [ "/bin/sh", "-c" ]
CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf" ]