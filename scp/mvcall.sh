#!/bin/bash

chown asterisk:asterisk $1;
chmod 0664 $1;

mv $1 $2
