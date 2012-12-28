#! /bin/sh

# Read table name
read -p "Enter your database table name: " name
echo Creating Symfony2 entity...

# Set first character to uppercase
tableName=`awk '{ print toupper(substr($0, 1, 1)) substr($0, 2) }' <<< "$name"`

# Generate metadata
php ../www/app/console doctrine:mapping:convert xml ../www/src/MatchTracker/Bundle/AppBundle/Resources/config/doctrine/metadata/orm --from-database --filter="$tableName" --force

# Generate single entity
php ../www/app/console doctrine:mapping:import MatchTrackerAppBundle annotation --filter="$tableName"

echo ... Done!

