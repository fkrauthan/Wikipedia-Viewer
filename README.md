Wikipedia Viewer
================

This project is a small showcase project to show my skills and talents.
The whole project was developed from scratch within 10 hours.


What is this project
--------------------

This project is a fully working website with the following features:

* registration
* login
* password reset
* profile change
* password change
* searching for wikipedia articles by name
* browsing the results
* marking results as favorite
* works without javascript but adds some dynamic elements if javascript is enabled


The directories
---------------

* the `symfony` directory contains the project source
* the `docker` directory contains docker files to get a container running that runs this page


Using docker
------------

Please install docker (https://docs.docker.com/installation/). After that you
just need to run the `build-and-run.sh` script within the `docker` container.
That takes care of creating a container. Configuring the application and starts
the container so you can use the application.

* if you use plain docker you can access the project with `http://localhost:1991`.
* if you use boot2docker you can access the project with `http://BOOT2DOCKERIP:1991`

Please note that the docker container is just for testing purpose. It is highly
unsafe and has a really bad performance.
