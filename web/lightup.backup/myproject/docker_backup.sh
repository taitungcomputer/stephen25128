#!/bin/bash
# ===============================================
# Docker Django 全環境備份與復原腳本
# ===============================================

# -------------------------------
# 設定區
# -------------------------------
PROJECT_NAME="myproject"
WEB_DIR="./web"
NGINX_DIR="./nginx"
DOCKER_COMPOSE_FILE="./docker-compose.yml"

DB_VOLUME="${PROJECT_NAME}_db_data"
STATIC_VOLUME="${PROJECT_NAME}_static_volume"

BACKUP_DIR="./backup"
DATE=$(date +"%Y%m%d_%H%M%S")

mkdir -p $BACKUP_DIR

# -------------------------------
# 使用說明
# -------------------------------
usage() {
    echo "用法: $0 {backup|restore}"
    exit 1
}

# -------------------------------
# 備份功能
# -------------------------------
backup() {
    echo "==== 開始備份 Docker 環境 ===="

    # 停掉 container（可選，確保資料一致性）
    echo "停止 Docker container..."
    sudo docker compose down

    # 備份資料庫 volume
    echo "備份 MySQL 資料庫..."
    docker run --rm -v ${DB_VOLUME}:/volume -v $(pwd)/${BACKUP_DIR}:/backup alpine \
        sh -c "cd /volume && tar czf /backup/db_data_${DATE}.tar.gz ."

    # 備份 static / media volume
    echo "備份 static / media..."
    docker run --rm -v ${STATIC_VOLUME}:/volume -v $(pwd)/${BACKUP_DIR}:/backup alpine \
        sh -c "cd /volume && tar czf /backup/static_volume_${DATE}.tar.gz ."

    # 備份程式碼與設定
    echo "備份程式碼..."
    tar czf ${BACKUP_DIR}/${PROJECT_NAME}_code_${DATE}.tar.gz ${WEB_DIR} ${NGINX_DIR} ${DOCKER_COMPOSE_FILE}

    echo "==== 備份完成 ===="
    echo "備份檔案位於 $BACKUP_DIR"
}

# -------------------------------
# 復原功能
# -------------------------------
restore() {
    echo "==== 開始復原 Docker 環境 ===="
    echo "請將備份檔放置於 ${BACKUP_DIR} 目錄下"

    # 停掉 container
    echo "停止 Docker container..."
    sudo docker compose down

    # 復原程式碼（手動覆蓋）
    echo "請手動解壓 ${PROJECT_NAME}_code_*.tar.gz 到專案根目錄"

    # 復原 DB volume
    DB_BACKUP=$(ls -t ${BACKUP_DIR}/db_data_*.tar.gz | head -1)
    echo "復原 MySQL 資料庫: $DB_BACKUP"
    docker volume create ${DB_VOLUME}
    docker run --rm -v ${DB_VOLUME}:/volume -v $(pwd)/${BACKUP_DIR}:/backup alpine \
        sh -c "cd /volume && tar xzf /backup/$(basename $DB_BACKUP)"

    # 復原 static volume
    STATIC_BACKUP=$(ls -t ${BACKUP_DIR}/static_volume_*.tar.gz | head -1)
    echo "復原 static / media: $STATIC_BACKUP"
    docker volume create ${STATIC_VOLUME}
    docker run --rm -v ${STATIC_VOLUME}:/volume -v $(pwd)/${BACKUP_DIR}:/backup alpine \
        sh -c "cd /volume && tar xzf /backup/$(basename $STATIC_BACKUP)"

    echo "==== 復原完成 ===="
    echo "請檢查程式碼及配置，然後執行：sudo docker compose up -d"
}

# -------------------------------
# 主程式
# -------------------------------
if [ $# -ne 1 ]; then
    usage
fi

case "$1" in
    backup)
        backup
        ;;
    restore)
        restore
        ;;
    *)
        usage
        ;;
esac
