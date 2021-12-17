#!/usr/bin/bash

sudo cp apiListener.service /lib/systemd/system/apiListener.service

sudo systemctl daemon-reload

sudo systemctl enable apiListener.service
sudo systemctl start apiListener.service

sudo systemctl status apiListener.service


