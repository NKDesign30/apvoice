#!/usr/bin/env bash

print_banner() {
    echo ""
    echo -e "\033[33m"
    echo "    _                                      _                              __                          _                        _ "
    echo "   / \     _ __     ___   __   __   ___   (_)   ___    ___               / _|  _ __    ___    _ __   | |_    ___   _ __     __| |"
    echo "  / _ \   | '_ \   / _ \  \ \ / /  / _ \  | |  / __|  / _ \    _____    | |_  | '__|  / _ \  | '_ \  | __|  / _ \ | '_ \   / _  |"
    echo " / ___ \  | |_) | | (_) |  \ V /  | (_) | | | | (__  |  __/   |_____|   |  _| | |    | (_) | | | | | | |_  |  __/ | | | | | (_| |"
    echo "/_/   \_\ | .__/   \___/    \_/    \___/  |_|  \___|  \___|             |_|   |_|     \___/  |_| |_|  \__|  \___| |_| |_|  \__,_|"
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

echo ""
echo "Missing command. Usage:"
echo "  apovoice [command]"
echo ""
echo "Commands:"
echo -e "  up\tStart the development environment"
echo -e "  down\tStop the development environment"
echo -e "  logs\tAttach to the logging stream"
echo ""
