#!/usr/bin/env bash
docker run   -p 81:80 -v /root/.composer/ -v /root/.cache/composer/ -v $(pwd):/var/www/html/ -it phalcon_docker