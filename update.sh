#!/bin/bash

svn up
cd ./app/migration/ && ./_migrate.sh