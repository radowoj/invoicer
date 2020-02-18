#!/bin/bash

docker build . -t invoicer-dev
docker run --rm -v "$(pwd)":/app invoicer-dev composer install
docker run --rm -ti -v "$(pwd)":/app invoicer-dev sh
