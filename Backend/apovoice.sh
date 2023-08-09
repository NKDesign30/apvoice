#!/usr/bin/env bash

print_banner() {
    echo ""
    echo -e "\033[33m"
    echo "    _                                      _                             _                      _                         _ "
    echo "   / \     _ __     ___   __   __   ___   (_)   ___    ___              | |__     __ _    ___  | | __   ___   _ __     __| |"
    echo "  / _ \   | '_ \   / _ \  \ \ / /  / _ \  | |  / __|  / _ \    _____    | '_ \   / _  |  / __| | |/ /  / _ \ | '_ \   / _  |"
    echo " / ___ \  | |_) | | (_) |  \ V /  | (_) | | | | (__  |  __/   |_____|   | |_) | | (_| | | (__  |   <  |  __/ | | | | | (_| |"
    echo "/_/   \_\ | .__/   \___/    \_/    \___/  |_|  \___|  \___|             |_.__/   \__,_|  \___| |_|\_\  \___| |_| |_|  \__,_|"
    echo "          |_|"

    echo ""
    echo -e "\033[0m"
}

is_docker_available() {
    docker --version > /dev/null 2>&1
    return $?
}

is_docker_network_available() {
    docker network inspect apovoice > /dev/null 2>&1
    return $?
}

handle_up() {
    print_banner

    echo  -n "Checking docker... "
    if is_docker_available; then
        echo -e "\033[32mOk\033[0m"
        else
        echo -e "\033[31mDocker missing\033[0m"
        exit 1
    fi

    echo -n "Checking docker networks... "
    if is_docker_network_available; then
        echo -e "\033[32mOk\033[0m"
        else
        echo -e "\033[33mDocker network missing\033[0m"
        echo -en "  Creating apovoice network... "

        docker network create apovoice  > /dev/null 2>&1

        retVal=$?
        if [ $retVal -eq 0 ]; then
             echo -e "\033[32mOk\033[0m"
            else
              echo -e "\033[31mFailed\033[0m"
              exit 1
        fi

        exit 1
    fi

    echo ""
    echo ""

    # Starting the environment
    docker-compose up -d  > /dev/null 2>&1
    # Attach to the logs
    docker-compose logs -f -t
}

handle_down() {
    # Stopping the environment
    docker-compose down
}

handle_logs() {
    # Attach the logger
    docker-compose logs -f -t
}

handle_composer() {
    docker-compose run --rm \
        -v $PWD:/app \
        composer \
        composer "$@" --ignore-platform-reqs --no-scripts
}

if [ "$1" == "up" ]; then
    handle_up
    exit 0
fi

if [ "$1" == "down" ]; then
    handle_down
    exit 0
fi

if [ "$1" == "logs" ]; then
    handle_logs
    exit 0
fi

if [ "$1" == "composer" ]; then
    shift
    handle_composer "$@"
    exit 0
fi

echo ""
echo "Missing command. Usage:"
echo "  apovoice [command]"
echo ""
echo "Commands:"
echo -e "  \033[0;32mup\033[0m\t\tStart the development environment"
echo -e "  \033[0;32mdown\033[0m\t\tStop the development environment"
echo -e "  \033[0;32mlogs\033[0m\t\tAttach to the logging stream"
echo -e "    migrate\tMigrates the database"
echo -e "    clean\tDrops all objects in the configured schemas"
echo -e "    info\tPrints the details and status information about all the migrations"
echo -e "    validate\tValidates the applied migrations against the ones available on the classpath"
echo -e "    baseline\tBaselines an existing database, excluding all migrations up to and including baselineVersion"
echo -e "    repair\tRepairs the schema history table"
echo -e "  \033[0;32mcomposer\033[0m\tRun a Composer command"
echo ""
