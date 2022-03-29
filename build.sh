#!/bin/bash

PLUGIN_NAME="woocommerce-accepted-payment-methods"
rm -f $PLUGIN_NAME.zip
zip -r $PLUGIN_NAME.zip . -x \*.git\* build.sh \*.DS_Store