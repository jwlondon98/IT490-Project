#!/usr/bin/bash

sudo cp dbListener.service /lib/systemd/system/dbListener.service

sudo systemctl daemon-reload

sudo systemctl enable dbListener.service
sudo systemctl start dbListener.service

sudo systemctl status dbListener.service


