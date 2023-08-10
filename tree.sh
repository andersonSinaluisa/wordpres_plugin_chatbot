#!/bin/bash

print_tree() {
    local indent="${2:-0}"
    printf "%${indent}s%s\n" " " "$1"
    local items="$(ls -A "$1")"
    for item in $items; do
        local path="$1/$item"
        if [ -d "$path" ]; then
            print_tree "$path" $((indent + 2))
        fi
    done
}

if [ $# -eq 0 ]; then
    root="."
else
    root="$1"
fi

print_tree "$root"
