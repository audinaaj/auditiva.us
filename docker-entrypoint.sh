#!/bin/bash
set -e

# Wait for database to be ready
echo "Waiting for database connection..."
# Spit out the details of the host/db connection for debugging purposes
echo "DB_HOST: $DB_HOST / DB_NAME: $DB_NAME / DB_USER: $DB_USER"

attempt=0
until mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" --skip-ssl-verify-server-cert -e "SELECT 1"; do
  attempt=$((attempt+1))
  echo "Database is unavailable (attempt $attempt) - sleeping"
  if [ $attempt -gt 5 ]; then
    echo "ERROR: Could not connect to database after $attempt attempts"
    mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" --skip-ssl-verify-server-cert -e "SELECT 1"
  fi
  sleep 3
done

echo "Database is up - running migrations"
php /app/yii migrate/up --interactive=0

# Apply init.sql if present and not already applied (hash-based tracking)
INIT_DUMP_PATH="${INIT_DUMP_PATH:-/data-init/init.sql}"
APPLIED_HASH_FILE="/app/.docker-init-hash"

if [ -f "$INIT_DUMP_PATH" ]; then
  # Compute hash of current init file
  INIT_HASH=$(sha256sum "$INIT_DUMP_PATH" | awk '{print $1}')
  APPLIED_HASH=$(cat "$APPLIED_HASH_FILE" 2>/dev/null || echo "")
  
  # If hash doesn't match (first run or file changed), apply init
  if [ "$APPLIED_HASH" != "$INIT_HASH" ]; then
    echo "Applying init file: $INIT_DUMP_PATH"
    
    mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" --skip-ssl-verify-server-cert < "$INIT_DUMP_PATH"
    
    # Store hash to track this init file has been applied (persists with container)
    echo "$INIT_HASH" > "$APPLIED_HASH_FILE"
    
    echo "Init file applied successfully"
  fi
fi

echo "Starting Apache..."
exec "$@"
