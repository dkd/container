
    git clone https://github.com/typo3/typo3.git
    git checkout 12.4
    

cache ?

    cd Build
    COMMAND="cd /Build; npm ci || exit 1; node_modules/grunt/bin/grunt scripts"
    docker run -v ${PWD}:/Build -it ghcr.io/typo3/core-testing-nodejs18:1.4 /bin/sh -c "$COMMAND"

    cd Build
    nvm use v18.20.1
    npm ci
    node_modules/grunt/bin/grunt scripts