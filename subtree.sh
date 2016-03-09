#!/bin/bash

for path in `git config -f .gitsubtrees -l | grep 'path=' | cut -d '=' -f2 | uniq`; do
    url=`git config -f .gitsubtrees subtree.$path.url`
    branch=`git config -f .gitsubtrees subtree.$path.branch`
    remote=`git config -f .gitsubtrees subtree.$path.remote`

    if [ -d "$path" ] ; then
        echo "$path is existed"
    else
        git subtree add --prefix $path $url $branch --squash
    fi
done
