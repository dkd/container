
    git clone https://github.com/typo3/typo3.git
    # 13.0.1
    cp container-patch.patch .
    


build patch file
cache ?
js-12
js-13
af@MacBook-Pro-4.local:~/src/projects/typo3_build$ git format-patch  12.4 --stdout > js-12.patch
af@MacBook-Pro-4.local:~/src/projects/typo3_build$ patch -p1 < js-12.patch
patching file 'Build/Sources/TypeScript/backend/layout-module/drag-drop.ts'
patching file 'Build/Sources/TypeScript/backend/layout-module/paste.ts'




we can use core branch 13.0

git checkout js-13
git format-patch 13.0 --stdout > js-13.patch
git checkout 13.0
patch -p1 < js-13.patch



    cd Build
    COMMAND="cd /Build; npm ci || exit 1; node_modules/grunt/bin/grunt scripts"
    docker run -v ${PWD}:/Build -it ghcr.io/typo3/core-testing-nodejs18:1.4 /bin/sh -c "$COMMAND"

    cd Build
    nvm use v18.20.1
    npm ci
    node_modules/grunt/bin/grunt scripts

    cp JavaScript/backend/layout-module/* ~/src/projects/core12/src/extensions/container/Resources/Public/JavaScript/Overrides/