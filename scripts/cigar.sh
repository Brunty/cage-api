#!/usr/bin/env bash
set -e
docker-compose exec -T php vendor/bin/cigar -c .cigar
