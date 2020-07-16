#!/bin/sh
socat -T10 tcp-l:10099,reuseaddr,fork exec:"timeout -s 9 10 ./bof0"
