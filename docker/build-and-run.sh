#!/bin/bash

set -e


echo "Do you need sudo for running docker [1|2]?"
docker_prefix=""
select yn in "Yes" "No"; do
    case $yn in
        Yes ) docker_prefix="sudo "; break;;
        No ) break;;
    esac
done
echo
echo


if [ -d ./project ]; then
    echo "> Remove old project"
    rm -Rf ./project
fi

echo "> Copying project"
cp -R ../symfony ./project

echo "> Cleanup project"
if [ -d /project/vendor ]; then
    rm -Rf ./project/vendor
fi
if [ -d /project/logs ]; then
    rm -Rf ./project/logs/*
fi
if [ -d /project/database ]; then
    rm -Rf ./project/database/*
fi
if [ -d /project/cache ]; then
    rm -Rf ./project/cache/*
fi

echo "> Creating config file"
cp ./project/app/config/parameters.yml.dist ./project/app/config/parameters.yml

echo "> Build the container"
$docker_prefix docker build -t fkrauthan/wikipedia-viewer .

echo "> Clean up project"
rm -Rf ./project

if [ ! -d ./database ]; then
    echo "> Create database directory"
    mkdir ./database
    chmod 777 ./database
fi

if type "boot2docker" > /dev/null 2>&1; then
    ip=$(boot2docker ip)
    echo "> Run the container (You can exit stop it with CTRL+C) Please open http://$ip:1991"
else
    echo "> Run the container (You can exit stop it with CTRL+C) Please open http://localhost:1991"
fi

dir=$(pwd)
$docker_prefix docker run -i -t -p 1991:80 -v $dir/database:/var/database  --rm fkrauthan/wikipedia-viewer
