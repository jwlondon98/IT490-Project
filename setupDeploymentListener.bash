#!/usr/bin/bash

sudo cp deploymentListener.service /lib/systemd/system/deploymentListener.service

sudo systemctl daemon-reload

sudo systemctl enable deploymentListener.service
sudo systemctl start deploymentListener.service

sudo systemctl status deploymentListener.service

