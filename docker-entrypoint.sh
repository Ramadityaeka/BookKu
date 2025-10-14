#!/bin/bash

# Replace ${PORT} with actual PORT value in Apache configs
sed -i "s/\${PORT}/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Start Apache
apache2-foreground