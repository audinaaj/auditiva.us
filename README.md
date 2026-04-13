# auditiva.us

# Database Backup & Initialization

## Overview

**Simple approach:**

1. **Schema** - Yii migrations handle initial database structure and minimal data
2. **Initialization** - Allow a fresh container to auto-restore from mounted data dump
3. **Data** - Admin web UI allows downloading SQL data dumps

## Quick Start: Fresh Container

### 1. Get Database Dump

Use the **admin web interface** to export the database:

```
Website Admin -> Dashboard -> Tools -> Backup Database
```

### 2. Mount in docker compose as init.sql in /data-init Directory

```yaml
php:
  volumes:
      - /opt/docker/data-init:/data-init:ro
```

### 3. Start/Restart Container

```bash
docker-compose up -d php
```

**Container startup process:**
1. Create the database & database user (from `.env`)
2. Run Yii migrations (schema setup, and add minimal data to tables)
3. Check for `init.sql`
   * Computes SHA256 hash of `init.sql` to distinguish this from a previously applied `init.sql`
   * Compares with previously applied hash (stored in )
   * Hash mismatch in `/app/.docker-init-hash` means run the new `init.sql` and store the new hash
4. Start up Apache


## Configuration

Customize in `docker-compose.yml`:

```yaml
services:
  php:
    environment:
      INIT_DUMP_PATH: /data-init/init.sql  # Change path if needed
    volumes:
      - ./data-init:/data-init:ro  # Read-only mount
```

## Workflows

### Regular Backups
Use the **admin web interface** to export the database:

```
Website Admin -> Dashboard -> Tools -> Backup Database
```

### Development Setup
1. Get dump from admin UI or production
2. cp ~/Downloads/dump.sql data-init/init.sql
3. docker-compose up -d php

### Node Failure Recovery  
```bash
1. docker-compose down
2. docker volume rm auditivaus-mysql-1
3. cp /backups/latest_dump.sql data-init/init.sql
4. docker-compose up -d php
```
