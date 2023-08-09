#!/usr/bin/env bash
function help() {
    echo ""
    echo "Usage:"
    echo "  bump-version [major|minor|patch]"
    echo ""
    echo "Commands:"
    echo -e "  \033[0;32mhelp\033[0m\tPrint this help message"
    echo ""
}

function bump() {
    output=$(npm version ${release})
    version=${output:1}

    git add .
    git commit -m "Prepare release ${version}"

    echo -e "Bumped version to \033[0;32m${version}\033[0m"
}

if [ -z "$1" ] || [ "$1" = "help" ]; then
    help
    exit 0
fi

release=$1

if [ -d ".git" ]; then
    changes=$(git status --porcelain)

    if [ ! -z "${changes}" ]; then
        echo "Please commit your changes before bumping the version!"
        exit 1
    fi
fi

bump "package.json"
